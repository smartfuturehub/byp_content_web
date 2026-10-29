<?php

namespace App\Support\Ai;

use App\Models\AiSuggestion;
use Illuminate\Support\Str;
use RuntimeException;

class SuggestionGenerator
{
    public function __construct(
        private OpenAiClient $openAi,
        private SiteSnapshot $snapshot,
    ) {}

    public function generate(int $days = 30): string
    {
        if (! $this->openAi->isConfigured()) {
            throw new RuntimeException('Set OPENAI_API_KEY in the environment to generate suggestions.');
        }

        $snapshot = $this->snapshot->toArray($days);
        $allowList = $snapshot['image_allowlist'] ?? [];

        $decoded = $this->openAi->jsonCompletion(
            $this->systemPrompt(),
            'CMS snapshot JSON:\n'.json_encode($snapshot, JSON_UNESCAPED_SLASHES),
        );

        $batchId = (string) Str::uuid();
        $this->storeItems($batchId, 'content', $decoded['content'] ?? []);
        $this->storeImages($batchId, $decoded['images'] ?? [], $allowList);
        $this->storeItems($batchId, 'page', $decoded['pages'] ?? []);
        $this->storeItems($batchId, 'improvement', $decoded['improvements'] ?? []);

        return $batchId;
    }

    protected function systemPrompt(): string
    {
        return <<<'PROMPT'
You are an editor for the BYP Health Laravel CMS (oursmartfuture.com).
Return JSON only with keys: content, images, pages, improvements.
Each content item: page_id, slug, field (seo_title|seo_description|title), suggested, reason.
Each image item: page_id, slug, field (featured_image|og_image), suggested_path, reason. suggested_path MUST be copied exactly from image_allowlist. Never invent image files.
Each page item: title, slug, outline (HTML paragraphs), reason. These are new-page ideas only. Do not add header menu items.
Each improvement item: title, detail, severity (low|medium|high).
Never invent visitor statistics, office locations, or partner logos.
Do not recommend publishing. Do not change the four header programmes.
PROMPT;
    }

    /**
     * @param  list<mixed>  $items
     */
    protected function storeItems(string $batchId, string $type, array $items): void
    {
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            AiSuggestion::query()->create([
                'batch_id' => $batchId,
                'type' => $type,
                'payload' => $item,
                'status' => 'pending',
            ]);
        }
    }

    /**
     * @param  list<mixed>  $items
     * @param  list<string>  $allowList
     */
    protected function storeImages(string $batchId, array $items, array $allowList): void
    {
        $normalized = array_map(fn (string $path): string => '/'.ltrim($path, '/'), $allowList);

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $path = '/'.ltrim((string) ($item['suggested_path'] ?? ''), '/');

            if (! in_array($path, $normalized, true)) {
                continue;
            }

            $item['suggested_path'] = $path;

            AiSuggestion::query()->create([
                'batch_id' => $batchId,
                'type' => 'image',
                'payload' => $item,
                'status' => 'pending',
            ]);
        }
    }
}
