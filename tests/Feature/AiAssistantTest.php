<?php

namespace Tests\Feature;

use App\Filament\Pages\AiAssistant;
use App\Models\AiSuggestion;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class AiAssistantTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_open_the_ai_assistant(): void
    {
        $this->get('/admin/ai-assistant')
            ->assertRedirect('/admin/login');
    }

    public function test_admins_can_open_the_ai_assistant(): void
    {
        $this->seed();

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        $this->actingAs($admin)
            ->get('/admin/ai-assistant')
            ->assertOk()
            ->assertSee('Site suggestions')
            ->assertSee('Ask about analytics');
    }

    public function test_generating_suggestions_stores_pending_items_from_openai(): void
    {
        $this->seed();
        config(['services.openai.key' => 'test-key']);
        Http::preventStrayRequests();
        Http::fake([
            'api.openai.com/*' => Http::response([
                'choices' => [[
                    'message' => [
                        'content' => json_encode([
                            'content' => [],
                            'images' => [],
                            'pages' => [[
                                'title' => 'Workplace wellness programmes',
                                'slug' => 'workplace-wellness',
                                'outline' => '<p>A draft for workplace kits.</p>',
                                'reason' => 'Contact Us traffic is high.',
                            ]],
                            'improvements' => [[
                                'title' => 'Add OG images',
                                'detail' => 'Several pages have no social image.',
                                'severity' => 'medium',
                            ]],
                        ]),
                    ],
                ]],
            ], 200),
        ]);

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        Livewire::actingAs($admin)
            ->test(AiAssistant::class)
            ->call('generateSuggestions')
            ->assertHasNoErrors();

        $this->assertTrue(AiSuggestion::query()->where('type', 'page')->where('status', 'pending')->exists());
        $this->assertTrue(AiSuggestion::query()->where('type', 'improvement')->exists());
    }

    public function test_applying_a_page_suggestion_creates_a_draft_only(): void
    {
        $this->seed();

        $suggestion = AiSuggestion::factory()->create();
        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        Livewire::actingAs($admin)
            ->test(AiAssistant::class)
            ->call('applyDraftPage', $suggestion->getKey())
            ->assertRedirect();

        $page = Page::query()->where('slug', 'workplace-wellness')->first();

        $this->assertNotNull($page);
        $this->assertSame('draft', $page->status);
        $this->assertSame('applied', $suggestion->fresh()->status);
        $this->assertNotSame('published', $page->status);
    }

    public function test_analytics_questions_use_the_openai_snapshot_and_do_not_invent_when_empty(): void
    {
        $this->seed();
        config(['services.openai.key' => 'test-key']);
        Http::preventStrayRequests();
        Http::fake([
            'api.openai.com/*' => Http::response([
                'choices' => [[
                    'message' => [
                        'content' => 'LinkedIn sent the most traffic in the snapshot.',
                    ],
                ]],
            ], 200),
        ]);

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        Livewire::actingAs($admin)
            ->test(AiAssistant::class)
            ->set('question', 'Which website sent the most traffic?')
            ->call('ask')
            ->assertSet('messages.1.content', 'LinkedIn sent the most traffic in the snapshot.');
    }
}
