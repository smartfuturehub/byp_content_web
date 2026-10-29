<?php

namespace App\Support\Analytics;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class Ga4Client
{
    public function isConfigured(): bool
    {
        return filled($this->propertyId()) && is_array($this->credentials());
    }

    /**
     * @return array<string, mixed>
     */
    public function overview(int $days = 30): array
    {
        if (! $this->isConfigured()) {
            return [
                'configured' => false,
                'sessions' => [],
                'sources' => [],
            ];
        }

        $days = in_array($days, [7, 30, 90], true) ? $days : 30;

        try {
            $token = $this->accessToken();
            $property = $this->propertyId();

            $sessions = $this->runReport($token, $property, [
                'dateRanges' => [['startDate' => $days.'daysAgo', 'endDate' => 'today']],
                'dimensions' => [['name' => 'date']],
                'metrics' => [['name' => 'sessions'], ['name' => 'screenPageViews']],
                'orderBys' => [['dimension' => ['dimensionName' => 'date']]],
            ]);

            $sources = $this->runReport($token, $property, [
                'dateRanges' => [['startDate' => $days.'daysAgo', 'endDate' => 'today']],
                'dimensions' => [['name' => 'sessionSource'], ['name' => 'sessionMedium']],
                'metrics' => [['name' => 'sessions']],
                'orderBys' => [['metric' => ['metricName' => 'sessions'], 'desc' => true]],
                'limit' => 20,
            ]);

            return [
                'configured' => true,
                'sessions' => $this->dimensionRows($sessions, ['date'], ['sessions', 'screenPageViews']),
                'sources' => $this->dimensionRows($sources, ['sessionSource', 'sessionMedium'], ['sessions']),
            ];
        } catch (Throwable $exception) {
            report($exception);
            Log::error('GA4 analytics request failed.', ['message' => $exception->getMessage()]);

            return [
                'configured' => true,
                'error' => 'Google Analytics could not be loaded. Check the property ID and service account.',
                'sessions' => [],
                'sources' => [],
            ];
        }
    }

    public function propertyId(): ?string
    {
        $fromSettings = preg_replace('/\D+/', '', (string) setting('ga4_property_id', '')) ?: null;

        if (filled($fromSettings)) {
            return $fromSettings;
        }

        $fromEnv = preg_replace('/\D+/', '', (string) config('services.ga4.property_id')) ?: null;

        return $fromEnv;
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function credentials(): ?array
    {
        $path = (string) config('services.ga4.credentials');

        if ($path === '' || ! is_file($path)) {
            return null;
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        return is_array($decoded) ? $decoded : null;
    }

    protected function accessToken(): string
    {
        $cacheKey = 'ga4-access-token';
        $cached = Cache::get($cacheKey);

        if (is_string($cached) && $cached !== '') {
            return $cached;
        }

        $credentials = $this->credentials();

        if ($credentials === null) {
            throw new \RuntimeException('GA4 credentials are missing.');
        }

        $now = time();
        $header = $this->base64UrlEncode(json_encode(['alg' => 'RS256', 'typ' => 'JWT'], JSON_THROW_ON_ERROR));
        $claims = $this->base64UrlEncode(json_encode([
            'iss' => $credentials['client_email'] ?? '',
            'scope' => 'https://www.googleapis.com/auth/analytics.readonly',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now,
        ], JSON_THROW_ON_ERROR));

        $unsigned = $header.'.'.$claims;
        $key = openssl_pkey_get_private((string) ($credentials['private_key'] ?? ''));

        if ($key === false) {
            throw new \RuntimeException('GA4 private key is invalid.');
        }

        openssl_sign($unsigned, $signature, $key, OPENSSL_ALGO_SHA256);

        $response = Http::connectTimeout(5)
            ->timeout(15)
            ->asForm()
            ->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $unsigned.'.'.$this->base64UrlEncode($signature),
            ]);

        if (! $response->successful() || ! filled($response->json('access_token'))) {
            throw new \RuntimeException('GA4 token request failed.');
        }

        $token = (string) $response->json('access_token');
        Cache::put($cacheKey, $token, now()->addMinutes(50));

        return $token;
    }

    /**
     * @param  array<string, mixed>  $body
     * @return array<string, mixed>
     */
    protected function runReport(string $token, string $propertyId, array $body): array
    {
        $response = Http::connectTimeout(5)
            ->timeout(20)
            ->withToken($token)
            ->post('https://analyticsdata.googleapis.com/v1beta/properties/'.$propertyId.':runReport', $body);

        if (! $response->successful()) {
            throw new \RuntimeException('GA4 runReport failed: '.$response->status());
        }

        return $response->json() ?? [];
    }

    /**
     * @param  array<string, mixed>  $report
     * @param  list<string>  $dimensionNames
     * @param  list<string>  $metricNames
     * @return list<array<string, string>>
     */
    protected function dimensionRows(array $report, array $dimensionNames, array $metricNames): array
    {
        $rows = [];

        foreach ($report['rows'] ?? [] as $row) {
            $item = [];

            foreach ($dimensionNames as $index => $name) {
                $item[$name] = (string) data_get($row, 'dimensionValues.'.$index.'.value', '');
            }

            foreach ($metricNames as $index => $name) {
                $item[$name] = (string) data_get($row, 'metricValues.'.$index.'.value', '0');
            }

            $rows[] = $item;
        }

        return $rows;
    }

    protected function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
