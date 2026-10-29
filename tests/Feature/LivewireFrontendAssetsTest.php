<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Mechanisms\HandleRequests\EndpointResolver;
use Tests\TestCase;

class LivewireFrontendAssetsTest extends TestCase
{
    use RefreshDatabase;

    public function test_both_livewire_javascript_files_are_served(): void
    {
        foreach ([true, false] as $minified) {
            $response = $this->get(EndpointResolver::scriptPath(minified: $minified));

            $response->assertOk();
            $this->assertStringContainsString('javascript', (string) $response->headers->get('content-type'));
            $this->assertNotSame('', $response->getContent());
        }
    }

    public function test_contact_page_loads_reachable_livewire_javascript(): void
    {
        $this->seed();

        $page = $this->get('/contact-us');
        $page->assertOk();
        $page->assertSee('wire:submit="submit"', false);

        preg_match('/src="([^"]*livewire[^"]+\.js[^"]*)"/', $page->getContent(), $matches);

        $this->assertNotEmpty($matches[1] ?? null);

        $scriptPath = parse_url($matches[1], PHP_URL_PATH);
        $query = parse_url($matches[1], PHP_URL_QUERY);

        $this->get($scriptPath.($query ? '?'.$query : ''))->assertOk();
    }

    public function test_login_page_renders_the_livewire_sign_in_form(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('wire:submit="authenticate"', false)
            ->assertSee('type="submit"', false);
    }
}
