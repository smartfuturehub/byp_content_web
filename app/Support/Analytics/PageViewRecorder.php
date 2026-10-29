<?php

namespace App\Support\Analytics;

use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageViewRecorder
{
    /**
     * @param  array{
     *     path: string,
     *     title?: string|null,
     *     referrer?: string|null,
     *     utm_source?: string|null,
     *     utm_medium?: string|null,
     *     utm_campaign?: string|null,
     *     session_id: string,
     *     language?: string|null
     * }  $payload
     */
    public function record(Request $request, array $payload): ?PageView
    {
        if (! $this->isEnabled()) {
            return null;
        }

        if (! $this->hasConsent($request)) {
            return null;
        }

        $path = $this->normalizePath($payload['path']);

        if ($this->shouldIgnorePath($path)) {
            return null;
        }

        if ($this->isBot($request->userAgent())) {
            return null;
        }

        $referrer = $this->normalizeUrl($payload['referrer'] ?? null);
        $referrerHost = $this->hostFromUrl($referrer);

        if ($this->isInternalHost($referrerHost, $request)) {
            $referrer = null;
            $referrerHost = null;
        }

        $userAgent = (string) $request->userAgent();

        return PageView::query()->create([
            'path' => $path,
            'title' => $this->limit($payload['title'] ?? null, 255),
            'referrer' => $referrer,
            'referrer_host' => $referrerHost,
            'utm_source' => $this->limit($payload['utm_source'] ?? null, 120),
            'utm_medium' => $this->limit($payload['utm_medium'] ?? null, 120),
            'utm_campaign' => $this->limit($payload['utm_campaign'] ?? null, 120),
            'session_id' => $this->limit($payload['session_id'], 64) ?: Str::uuid()->toString(),
            'device' => $this->deviceFromUserAgent($userAgent),
            'browser' => $this->browserFromUserAgent($userAgent),
            'country' => $this->limit($request->headers->get('CF-IPCountry'), 8),
            'language' => $this->limit($payload['language'] ?? null, 32),
            'occurred_at' => now(),
        ]);
    }

    public function isEnabled(): bool
    {
        return ! in_array(setting('first_party_analytics_enabled', true), [false, 0, '0', 'false'], true);
    }

    public function hasConsent(Request $request): bool
    {
        if (in_array(setting('cookie_banner_enabled', true), [false, 0, '0', 'false'], true)) {
            return true;
        }

        return $request->cookie('sf_cookie_consent') === 'accepted';
    }

    public function shouldIgnorePath(string $path): bool
    {
        return str_starts_with($path, '/admin')
            || str_starts_with($path, '/livewire')
            || str_starts_with($path, '/analytics/collect');
    }

    public function isBot(?string $userAgent): bool
    {
        if (! filled($userAgent)) {
            return false;
        }

        return (bool) preg_match('/bot|crawl|spider|slurp|facebookexternalhit|preview|wget|curl/i', $userAgent);
    }

    public function normalizePath(string $path): string
    {
        $parsed = parse_url($path);

        if (is_array($parsed) && isset($parsed['path'])) {
            $path = $parsed['path'];
        }

        $path = '/'.ltrim($path, '/');

        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        return Str::limit($path, 512, '');
    }

    public function isInternalHost(?string $host, ?Request $request = null): bool
    {
        if (! filled($host)) {
            return true;
        }

        $host = strtolower($host);
        $hosts = [
            'localhost',
            '127.0.0.1',
            'oursmartfuture.com',
            'www.oursmartfuture.com',
            'preview.oursmartfuture.com',
        ];

        $appHost = strtolower((string) parse_url((string) config('app.url'), PHP_URL_HOST));

        if (filled($appHost)) {
            $hosts[] = $appHost;
        }

        if ($request instanceof Request && filled($request->getHost())) {
            $hosts[] = strtolower($request->getHost());
        }

        return in_array($host, array_unique($hosts), true);
    }

    protected function normalizeUrl(?string $url): ?string
    {
        if (! filled($url)) {
            return null;
        }

        $url = trim($url);

        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        return Str::limit($url, 2048, '');
    }

    protected function hostFromUrl(?string $url): ?string
    {
        if (! filled($url)) {
            return null;
        }

        $host = parse_url($url, PHP_URL_HOST);

        return is_string($host) && $host !== '' ? strtolower($host) : null;
    }

    protected function deviceFromUserAgent(string $userAgent): string
    {
        if (preg_match('/iPad|Tablet/i', $userAgent)) {
            return 'tablet';
        }

        if (preg_match('/Mobile|Android|iPhone/i', $userAgent)) {
            return 'mobile';
        }

        return 'desktop';
    }

    protected function browserFromUserAgent(string $userAgent): string
    {
        return match (true) {
            str_contains($userAgent, 'Edg/') => 'Edge',
            str_contains($userAgent, 'Chrome/') && ! str_contains($userAgent, 'Edg/') => 'Chrome',
            str_contains($userAgent, 'Firefox/') => 'Firefox',
            str_contains($userAgent, 'Safari/') && ! str_contains($userAgent, 'Chrome/') => 'Safari',
            default => 'Other',
        };
    }

    protected function limit(?string $value, int $length): ?string
    {
        if (! filled($value)) {
            return null;
        }

        return Str::limit(trim($value), $length, '');
    }
}
