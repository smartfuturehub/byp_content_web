<?php

namespace App\Filament\Pages;

use App\Filament\Resources\PageResource;
use App\Models\AiSuggestion;
use App\Models\Page;
use App\Support\Ai\OpenAiClient;
use App\Support\Ai\SiteSnapshot;
use App\Support\Ai\SuggestionGenerator;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page as FilamentPage;
use Filament\Support\Icons\Heroicon;
use Filament\Support\View\ComponentAttributeBag;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Throwable;
use UnitEnum;

class AiAssistant extends FilamentPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|UnitEnum|null $navigationGroup = 'Insights';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'AI assistant';

    protected static ?string $title = 'AI assistant';

    protected static ?string $slug = 'ai-assistant';

    protected string $view = 'filament.pages.ai-assistant';

    public string $question = '';

    /**
     * @var list<array{role: string, content: string}>
     */
    public array $messages = [];

    /**
     * @param  array<string, int|null>  $columns
     */
    public function insightsGrid(array $columns = ['lg' => 2]): ComponentAttributeBag
    {
        return (new ComponentAttributeBag)->grid($columns)->class(['fi-wi']);
    }

    public function suggestionHeading(AiSuggestion $suggestion): string
    {
        $payload = $suggestion->payload ?? [];

        return match ($suggestion->type) {
            'page' => (string) ($payload['title'] ?? 'New page'),
            'content' => trim(($payload['slug'] ?? 'Page').' · '.($payload['field'] ?? 'copy')),
            'image' => trim(($payload['slug'] ?? 'Page').' · '.($payload['field'] ?? 'image')),
            default => (string) ($payload['title'] ?? 'Improvement'),
        };
    }

    public function generateSuggestions(SuggestionGenerator $generator): void
    {
        try {
            $generator->generate(30);

            Notification::make()
                ->title('Suggestions ready')
                ->body('Review them below. Nothing is published until you apply a draft page.')
                ->success()
                ->send();
        } catch (Throwable $exception) {
            report($exception);

            Notification::make()
                ->title('Could not generate suggestions')
                ->body($exception->getMessage())
                ->danger()
                ->send();
        }
    }

    public function ask(OpenAiClient $client, SiteSnapshot $snapshot): void
    {
        $question = trim($this->question);

        if ($question === '') {
            return;
        }

        $this->messages[] = ['role' => 'user', 'content' => $question];
        $this->question = '';

        $history = array_slice($this->messages, -8);

        try {
            $answer = $client->chat([
                [
                    'role' => 'system',
                    'content' => 'You answer CMS analytics questions for BYP Health. Use only the snapshot numbers. If a figure is not present, say you do not have it. Do not invent traffic, offices, or logos. Be concise.',
                ],
                [
                    'role' => 'system',
                    'content' => 'Analytics snapshot: '.json_encode($snapshot->toArray(30), JSON_UNESCAPED_SLASHES),
                ],
                ...$history,
            ]);

            $this->messages[] = ['role' => 'assistant', 'content' => $answer !== '' ? $answer : 'I could not produce an answer from the current snapshot.'];
        } catch (Throwable $exception) {
            report($exception);
            array_pop($this->messages);

            Notification::make()
                ->title('Could not answer')
                ->body($exception->getMessage())
                ->danger()
                ->send();
        }
    }

    public function dismiss(int $id): void
    {
        AiSuggestion::query()->whereKey($id)->where('status', 'pending')->update(['status' => 'dismissed']);
    }

    public function applyDraftPage(int $id): void
    {
        $suggestion = AiSuggestion::query()->whereKey($id)->where('type', 'page')->where('status', 'pending')->first();

        if ($suggestion === null) {
            Notification::make()->title('That suggestion is no longer pending.')->warning()->send();

            return;
        }

        $title = trim((string) data_get($suggestion->payload, 'title', ''));
        $outline = (string) data_get($suggestion->payload, 'outline', '');

        if ($title === '') {
            Notification::make()->title('This suggestion has no title.')->warning()->send();

            return;
        }

        $slug = Str::slug((string) data_get($suggestion->payload, 'slug', $title));
        $base = $slug !== '' ? $slug : 'idea';
        $candidate = $base;
        $i = 1;

        while (Page::query()->where('slug', $candidate)->exists()) {
            $candidate = $base.'-'.$i;
            $i++;
        }

        $page = Page::query()->create([
            'title' => $title,
            'slug' => $candidate,
            'status' => 'draft',
            'schema_type' => 'WebPage',
            'blocks' => [
                [
                    'type' => 'rich_text',
                    'data' => [
                        'headline' => $title,
                        'body' => $outline !== '' ? $outline : '<p></p>',
                        'align' => 'left',
                    ],
                ],
            ],
        ]);

        $suggestion->update(['status' => 'applied']);

        Notification::make()
            ->title('Draft page created')
            ->body('It is unpublished. Review it in Pages before going live.')
            ->success()
            ->send();

        $this->redirect(PageResource::getUrl('edit', ['record' => $page]));
    }

    /**
     * @return Collection<int, AiSuggestion>
     */
    public function pendingSuggestions(): Collection
    {
        return AiSuggestion::query()->pending()->latest()->limit(50)->get();
    }

    public function editPageUrl(int $pageId): ?string
    {
        $page = Page::query()->find($pageId);

        return $page ? PageResource::getUrl('edit', ['record' => $page]) : null;
    }
}
