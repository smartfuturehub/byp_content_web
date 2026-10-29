<?php

use App\Models\SiteSetting;

if (! function_exists('setting')) {
    function setting(?string $key = null, mixed $default = null): mixed
    {
        $settings = SiteSetting::current();

        if ($key === null) {
            return $settings;
        }

        return $settings->get($key, $default);
    }
}

if (! function_exists('media_url')) {
    function media_url(mixed $path, ?string $fallback = null): string
    {
        if (is_array($path)) {
            $path = $path[0] ?? null;
        }

        if (! filled($path)) {
            return $fallback ? media_url($fallback) : '';
        }

        $path = (string) $path;

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//') || str_starts_with($path, 'data:')) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        if (
            str_starts_with($path, 'brand/')
            || str_starts_with($path, 'Logos/')
            || str_starts_with($path, 'Medical Devices')
            || str_starts_with($path, 'uploads/')
            || str_starts_with($path, 'favicon')
            || str_starts_with($path, 'build/')
        ) {
            return asset($path);
        }

        return asset('storage/'.$path);
    }
}

if (! function_exists('cms_url')) {
    function cms_url(mixed $path, string $fallback = '/'): string
    {
        if (! filled($path)) {
            return url($fallback);
        }

        $path = (string) $path;

        if (
            str_starts_with($path, 'http://')
            || str_starts_with($path, 'https://')
            || str_starts_with($path, '//')
            || str_starts_with($path, '#')
            || str_starts_with($path, 'mailto:')
            || str_starts_with($path, 'tel:')
        ) {
            return $path;
        }

        return url($path);
    }
}
