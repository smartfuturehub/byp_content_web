<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CookieConsentTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_show_cookie_banner_and_hold_analytics_until_consent(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertSee('id="cookie-banner"', false);
        $response->assertSee('data-cookie-accept', false);
        $response->assertSee('data-cookie-decline', false);
        $response->assertSee('data-cookie-settings', false);
        $response->assertSee('We use cookies to understand how visitors use this website.');
        $response->assertSee('Accept');
        $response->assertSee('Decline');
        $response->assertSee('href="'.url('/privacy-policy').'"', false);
        $response->assertSee('G-5MWJ5HDFMZ', false);
        $response->assertSee('GTM-KCDG6B9B', false);
        $response->assertSee('sfLoadAnalytics', false);
        $response->assertSee('sfTrackPageView', false);
        $response->assertSee('/analytics/collect', false);
        $response->assertDontSee('<script async src="https://www.googletagmanager.com/gtag/js', false);
        $response->assertDontSee('googletagmanager.com/ns.html', false);
    }

    public function test_analytics_load_immediately_when_cookie_banner_is_disabled(): void
    {
        $this->seed();

        $settings = SiteSetting::current();
        $settings->put('cookie_banner_enabled', false);
        $settings->save();

        $this->get('/')
            ->assertDontSee('id="cookie-banner"', false)
            ->assertDontSee('Cookie settings')
            ->assertSee('sfLoadAnalytics', false)
            ->assertSee('G-5MWJ5HDFMZ', false)
            ->assertSee('GTM-KCDG6B9B', false);
    }

    public function test_site_settings_confirm_the_analytics_ids(): void
    {
        $this->seed();

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        $this->actingAs($admin)
            ->get('/admin/manage-site-settings')
            ->assertOk()
            ->assertSee('Cookies &amp; analytics', false)
            ->assertSee('G-5MWJ5HDFMZ')
            ->assertSee('GTM-KCDG6B9B')
            ->assertSee('Confirmed measurement ID for this site: G-5MWJ5HDFMZ')
            ->assertSee('Confirmed container ID for this site: GTM-KCDG6B9B')
            ->assertSee('Store site visits in this CMS')
            ->assertSee('GA4 property ID');
    }
}
