<?php

namespace Database\Factories;

use App\Models\PageView;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PageView>
 */
class PageViewFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => '/contact-us',
            'title' => 'Contact Us',
            'referrer' => 'https://www.google.com/',
            'referrer_host' => 'www.google.com',
            'utm_source' => null,
            'utm_medium' => null,
            'utm_campaign' => null,
            'session_id' => Str::uuid()->toString(),
            'device' => 'desktop',
            'browser' => 'Chrome',
            'country' => 'SG',
            'language' => 'en',
            'occurred_at' => now(),
        ];
    }
}
