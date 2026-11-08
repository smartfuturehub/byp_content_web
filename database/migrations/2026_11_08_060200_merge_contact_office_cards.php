<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pages')) {
            return;
        }

        foreach (DB::table('pages')->where('slug', 'contact-us')->orderBy('id')->get() as $page) {
            $blocks = $this->asArray($page->blocks);

            if (! is_array($blocks)) {
                continue;
            }

            DB::table('pages')->where('id', $page->id)->update([
                'blocks' => json_encode($this->mergedContactCards($blocks)),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Contact cards were combined into one 2x2 section.
    }

    /**
     * @param  array<int, mixed>  $blocks
     * @return array<int, mixed>
     */
    protected function mergedContactCards(array $blocks): array
    {
        $kept = [];
        $merged = false;

        foreach ($blocks as $block) {
            if (! is_array($block) || ($block['type'] ?? '') !== 'cards') {
                $kept[] = $block;

                continue;
            }

            if ($merged) {
                continue;
            }

            $kept[] = [
                'type' => 'cards',
                'data' => [
                    'variant' => 'feature',
                    'columns' => '2',
                    'headline' => 'Offices',
                    'items' => [
                        [
                            'title' => 'Email',
                            'body' => 'All emails will be replied to in working days.',
                            'url' => 'mailto:contact@byphealthtek.com',
                        ],
                        [
                            'image' => '/brand/wp/assets/img/liberty.png',
                            'title' => 'USA',
                            'body' => '651 N Broad St, Suite 201, Middletown, Delaware 19709',
                        ],
                        [
                            'image' => '/brand/wp/assets/img/merlion.png',
                            'title' => 'Singapore',
                            'body' => '246 Macpherson Road, #03-01 Betime Building, Singapore 348578',
                        ],
                        [
                            'title' => 'United Arab Emirates',
                            'body' => 'United Arab Emirates',
                        ],
                    ],
                ],
            ];
            $merged = true;
        }

        return array_values($kept);
    }

    protected function asArray(mixed $value): mixed
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }

        return $value;
    }
};
