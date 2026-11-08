<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $from = '/brand/wp/new-assets/images/pa-img-8.png';
        $to = '/brand/wp/new-assets/images/spirometer.jpg';

        if (Schema::hasTable('pages')) {
            foreach (DB::table('pages')->orderBy('id')->get() as $page) {
                $blocks = $this->asArray($page->blocks);

                if (! is_array($blocks)) {
                    continue;
                }

                $updated = $this->replaceSpirometerImage($blocks, $from, $to);

                if ($updated !== $blocks) {
                    DB::table('pages')->where('id', $page->id)->update([
                        'blocks' => json_encode($updated),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        if (Schema::hasTable('medical_devices')) {
            DB::table('medical_devices')
                ->where('name', 'Spirometer')
                ->update([
                    'image' => $to,
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        // New spirometer photos replaced a weight-scale file used by mistake.
    }

    /**
     * @param  array<int|string, mixed>  $blocks
     * @return array<int|string, mixed>
     */
    protected function replaceSpirometerImage(array $blocks, string $from, string $to): array
    {
        foreach ($blocks as $index => $block) {
            if (! is_array($block)) {
                continue;
            }

            $items = $block['data']['items'] ?? null;

            if (! is_array($items)) {
                continue;
            }

            foreach ($items as $itemIndex => $item) {
                if (! is_array($item)) {
                    continue;
                }

                $name = strtolower(trim((string) ($item['name'] ?? '')));
                $image = (string) ($item['image'] ?? '');

                if ($name === 'spirometer' && ($image === $from || $image === '' || str_contains($image, 'pa-img-8'))) {
                    $blocks[$index]['data']['items'][$itemIndex]['image'] = $to;
                }
            }
        }

        return $blocks;
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
