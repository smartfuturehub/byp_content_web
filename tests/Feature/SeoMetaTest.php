<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SeoMetaTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_publishes_complete_open_graph_and_twitter_metadata(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertSee('<title>Remote Patient Monitoring &amp; Remote Care Solutions | BYP Health</title>', false);
        $response->assertSee('name="description" content="BYP Health connects care teams and patients with digital solutions for hospital at home, emergency response, chronic disease and facility-based care."', false);
        $response->assertSee('name="robots" content="index,follow,max-image-preview:large"', false);
        $response->assertSee('name="author" content="BYP Health"', false);
        $response->assertSee('name="theme-color" content="#0B59AC"', false);
        $response->assertSee('rel="canonical" href="'.url('/').'"', false);
        $response->assertSee('hreflang="en"', false);
        $response->assertSee('property="og:locale" content="en_US"', false);
        $response->assertSee('property="og:site_name" content="BYP Health"', false);
        $response->assertSee('property="og:type" content="website"', false);
        $response->assertSee('property="og:title" content="Remote Patient Monitoring &amp; Remote Care Solutions | BYP Health"', false);
        $response->assertSee('property="og:image"', false);
        $response->assertSee('name="twitter:card" content="summary_large_image"', false);
        $response->assertSee('name="twitter:title" content="Remote Patient Monitoring &amp; Remote Care Solutions | BYP Health"', false);
        $response->assertDontSee('@smartfuturerpm', false);
        $response->assertDontSee('@getmedcheck', false);
        $response->assertDontSee('facebook.com/getmedcheck', false);
    }

    #[DataProvider('programmeMeta')]
    public function test_programme_pages_keep_their_existing_titles_and_canonical_urls(string $path, string $title): void
    {
        $this->seed();

        $response = $this->get($path);

        $response->assertSee('<title>'.$title.'</title>', false);
        $response->assertSee('property="og:title" content="'.$title.'"', false);
        $response->assertSee('rel="canonical" href="'.url($path).'"', false);
    }

    public function test_newsletter_article_uses_article_open_graph_tags(): void
    {
        $this->seed();

        $post = Post::query()->whereNotNull('featured_image')->first();

        $this->get($post->url())
            ->assertSee('property="og:type" content="article"', false)
            ->assertSee('property="article:published_time"', false)
            ->assertSee('property="article:author" content="'.$post->displayAuthor().'"', false)
            ->assertSee('<title>'.$post->seoTitle().'</title>', false);
    }

    public function test_search_results_are_excluded_from_indexing(): void
    {
        $this->get('/search')
            ->assertSee('name="robots" content="noindex,follow,max-image-preview:large"', false);
    }

    public function test_missing_pages_are_not_indexable(): void
    {
        $response = $this->get('/no-such-page');

        $response->assertNotFound();
        $response->assertSee('name="robots" content="noindex,follow,max-image-preview:large"', false);
        $response->assertSee('<title>Page not found | BYP Health</title>', false);
        $response->assertDontSee('rel="canonical"', false);
        $response->assertDontSee('hreflang=', false);
        $response->assertDontSee('property="og:url"', false);
    }

    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function programmeMeta(): array
    {
        return [
            'hospital at home' => ['/hospital-at-home', 'Hospital At Home - BYP Health'],
            'emergency care' => ['/emergency-care', 'Emergency Kit - BYP Health'],
            'chronic care' => ['/chronic-care', 'Chronic Care | BYP Health'],
            'facility care' => ['/facility-care', 'Resident Tracking Solution - BYP Health'],
            'contact' => ['/contact-us', 'Contact Us | BYP Health'],
        ];
    }
}
