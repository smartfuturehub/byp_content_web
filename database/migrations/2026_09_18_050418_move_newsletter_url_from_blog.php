<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('redirects')) {
            DB::table('redirects')->where('from_path', '/newsletter')->delete();

            $now = now();
            $payload = [
                'to_path' => '/newsletter',
                'status_code' => 301,
                'is_active' => true,
                'updated_at' => $now,
            ];

            if (DB::table('redirects')->where('from_path', '/blog')->exists()) {
                DB::table('redirects')->where('from_path', '/blog')->update($payload);
            } else {
                DB::table('redirects')->insert([
                    ...$payload,
                    'from_path' => '/blog',
                    'created_at' => $now,
                ]);
            }
        }

        if (Schema::hasTable('menus')) {
            foreach (DB::table('menus')->orderBy('id')->get() as $menu) {
                $items = is_string($menu->items) ? json_decode($menu->items, true) : $menu->items;

                if (! is_array($items)) {
                    continue;
                }

                $updated = $this->replaceBlogPaths($items);

                if ($updated === $items) {
                    continue;
                }

                DB::table('menus')->where('id', $menu->id)->update([
                    'items' => json_encode($updated),
                    'updated_at' => now(),
                ]);
            }
        }

        if (Schema::hasTable('pages')) {
            foreach (DB::table('pages')->orderBy('id')->get() as $page) {
                $blocks = is_string($page->blocks) ? json_decode($page->blocks, true) : $page->blocks;

                if (! is_array($blocks)) {
                    continue;
                }

                $updated = $this->replaceBlogPaths($blocks);

                if ($updated === $blocks) {
                    continue;
                }

                DB::table('pages')->where('id', $page->id)->update([
                    'blocks' => json_encode($updated),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('redirects')) {
            DB::table('redirects')->where('from_path', '/blog')->delete();

            $now = now();
            $payload = [
                'to_path' => '/blog',
                'status_code' => 301,
                'is_active' => true,
                'updated_at' => $now,
            ];

            if (DB::table('redirects')->where('from_path', '/newsletter')->exists()) {
                DB::table('redirects')->where('from_path', '/newsletter')->update($payload);
            } else {
                DB::table('redirects')->insert([
                    ...$payload,
                    'from_path' => '/newsletter',
                    'created_at' => $now,
                ]);
            }
        }
    }

    /**
     * @param  array<int|string, mixed>  $items
     * @return array<int|string, mixed>
     */
    protected function replaceBlogPaths(array $items): array
    {
        foreach ($items as $key => $item) {
            if (is_string($item) && $this->isBlogPath($item)) {
                $items[$key] = $this->newsletterPath($item);

                continue;
            }

            if (! is_array($item)) {
                continue;
            }

            $items[$key] = $this->replaceBlogPaths($item);
        }

        return $items;
    }

    protected function isBlogPath(string $value): bool
    {
        $path = parse_url($value, PHP_URL_PATH);

        if (! is_string($path) || $path === '') {
            $path = $value;
        }

        return $path === '/blog' || str_starts_with($path, '/blog/');
    }

    protected function newsletterPath(string $value): string
    {
        return (string) preg_replace('#(^|/)blog(/|$)#', '$1newsletter$2', $value, 1);
    }
};
