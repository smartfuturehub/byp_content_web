<?php

namespace Tests\Feature;

use App\Models\PageView;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageViewCollectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->disableCookieEncryption();
        $this->withCredentials();
    }

    /**
     * @return array<string, mixed>
     */
    protected function payload(array $overrides = []): array
    {
        return array_merge([
            'path' => '/contact-us',
            'title' => 'Contact Us',
            'referrer' => 'https://www.google.com/search',
            'utm_source' => 'google',
            'utm_medium' => 'organic',
            'utm_campaign' => null,
            'session_id' => 'session-one',
            'language' => 'en-SG',
        ], $overrides);
    }

    public function test_collect_stores_a_view_only_with_consent(): void
    {
        $this->postJson('/analytics/collect', $this->payload())
            ->assertNoContent();

        $this->assertSame(0, PageView::query()->count());

        $this->withUnencryptedCookie('sf_cookie_consent', 'accepted')
            ->postJson('/analytics/collect', $this->payload())
            ->assertNoContent();

        $view = PageView::query()->first();

        $this->assertNotNull($view);
        $this->assertSame('/contact-us', $view->path);
        $this->assertSame('www.google.com', $view->referrer_host);
        $this->assertSame('google', $view->utm_source);
        $this->assertSame('session-one', $view->session_id);
    }

    public function test_collect_ignores_admin_paths(): void
    {
        $this->withUnencryptedCookie('sf_cookie_consent', 'accepted')
            ->postJson('/analytics/collect', $this->payload(['path' => '/admin/login']))
            ->assertNoContent();

        $this->assertSame(0, PageView::query()->count());
    }

    public function test_collect_ignores_bots(): void
    {
        $this->withUnencryptedCookie('sf_cookie_consent', 'accepted')
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1)'])
            ->postJson('/analytics/collect', $this->payload())
            ->assertNoContent();

        $this->assertSame(0, PageView::query()->count());
    }

    public function test_collect_is_skipped_when_first_party_tracking_is_disabled(): void
    {
        $settings = SiteSetting::current();
        $settings->put('first_party_analytics_enabled', false);
        $settings->save();

        $this->withUnencryptedCookie('sf_cookie_consent', 'accepted')
            ->postJson('/analytics/collect', $this->payload())
            ->assertNoContent();

        $this->assertSame(0, PageView::query()->count());
    }

    public function test_collect_ignores_declined_consent(): void
    {
        $this->withUnencryptedCookie('sf_cookie_consent', 'declined')
            ->postJson('/analytics/collect', $this->payload())
            ->assertNoContent();

        $this->assertSame(0, PageView::query()->count());
    }

    public function test_collect_stores_without_a_banner_choice_when_the_banner_is_disabled(): void
    {
        $settings = SiteSetting::current();
        $settings->put('cookie_banner_enabled', false);
        $settings->save();

        $this->postJson('/analytics/collect', $this->payload())
            ->assertNoContent();

        $this->assertSame(1, PageView::query()->count());
    }
}
