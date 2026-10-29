<?php

namespace Tests\Feature;

use App\Filament\Pages\Analytics;
use App\Models\PageView;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class AnalyticsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_open_analytics(): void
    {
        $this->get('/admin/analytics')
            ->assertRedirect('/admin/login');
    }

    public function test_editors_can_open_analytics_with_referrers_and_charts(): void
    {
        $this->seed();

        PageView::factory()->create([
            'path' => '/hospital-at-home',
            'referrer' => 'https://www.linkedin.com/feed',
            'referrer_host' => 'www.linkedin.com',
            'device' => 'desktop',
            'occurred_at' => now()->subDay(),
        ]);

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        $this->actingAs($admin)
            ->get('/admin/analytics')
            ->assertOk()
            ->assertSee('Analytics')
            ->assertSee('Referring websites')
            ->assertSee('www.linkedin.com')
            ->assertSee('/hospital-at-home')
            ->assertSee('Google Analytics')
            ->assertSee('Pageviews by day');
    }

    public function test_google_analytics_tab_loads_faked_reports_when_configured(): void
    {
        $this->seed();

        $key = openssl_pkey_new([
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ]);

        $this->assertNotFalse($key);
        openssl_pkey_export($key, $pem);

        $path = tempnam(sys_get_temp_dir(), 'ga4');
        file_put_contents($path, json_encode([
            'client_email' => 'ga4@test.iam.gserviceaccount.com',
            'private_key' => $pem,
        ]));

        config([
            'services.ga4.property_id' => '123456789',
            'services.ga4.credentials' => $path,
        ]);

        Http::preventStrayRequests();
        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response([
                'access_token' => 'ya29.test-token',
            ], 200),
            'https://analyticsdata.googleapis.com/*' => Http::response([
                'rows' => [[
                    'dimensionValues' => [
                        ['value' => 'linkedin'],
                        ['value' => 'referral'],
                    ],
                    'metricValues' => [
                        ['value' => '18'],
                        ['value' => '42'],
                    ],
                ]],
            ], 200),
        ]);

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        try {
            Livewire::actingAs($admin)
                ->test(Analytics::class)
                ->set('tab', 'google')
                ->assertSee('GA4 source / medium')
                ->assertSee('linkedin')
                ->assertSee('referral');
        } finally {
            if (is_file($path)) {
                unlink($path);
            }
        }
    }
}
