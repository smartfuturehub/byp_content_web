<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('redirects')) {
            $now = now();

            foreach ([
                '/product' => '/solutions',
                '/store' => '/solutions',
                '/shop' => '/solutions',
                '/cart' => '/',
                '/checkout' => '/contact-us',
            ] as $from => $to) {
                $payload = [
                    'to_path' => $to,
                    'status_code' => 301,
                    'is_active' => true,
                    'updated_at' => $now,
                ];

                if (DB::table('redirects')->where('from_path', $from)->exists()) {
                    DB::table('redirects')->where('from_path', $from)->update($payload);
                } else {
                    DB::table('redirects')->insert([
                        ...$payload,
                        'from_path' => $from,
                        'created_at' => $now,
                    ]);
                }
            }
        }

        if (Schema::hasTable('menus')) {
            foreach (DB::table('menus')->orderBy('id')->get() as $menu) {
                $items = is_string($menu->items) ? json_decode($menu->items, true) : $menu->items;

                if (! is_array($items)) {
                    continue;
                }

                $cleaned = $this->withoutShopLinks($items);

                if ($cleaned === $items) {
                    continue;
                }

                DB::table('menus')->where('id', $menu->id)->update([
                    'items' => json_encode($cleaned),
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

                $cleaned = array_values(array_filter(
                    $blocks,
                    fn (mixed $block): bool => ! is_array($block) || ($block['type'] ?? null) !== 'product_grid',
                ));

                if ($cleaned === array_values($blocks)) {
                    continue;
                }

                DB::table('pages')->where('id', $page->id)->update([
                    'blocks' => json_encode($cleaned),
                    'updated_at' => now(),
                ]);
            }
        }

        if (Schema::hasTable('categories')) {
            DB::table('categories')->where('type', 'product')->delete();
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('redirects')) {
            return;
        }

        foreach (['/shop', '/cart', '/checkout'] as $from) {
            DB::table('redirects')->where('from_path', $from)->delete();
        }

        foreach (['/product', '/store'] as $from) {
            DB::table('redirects')->where('from_path', $from)->update([
                'to_path' => '/shop',
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * @param  array<int, mixed>  $items
     * @return array<int, mixed>
     */
    protected function withoutShopLinks(array $items): array
    {
        $blocked = ['/shop', '/cart', '/checkout', '/store'];
        $cleaned = [];

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $path = $this->menuPath($item['url'] ?? null);

            if (in_array($path, $blocked, true) || str_starts_with($path, '/shop/')) {
                continue;
            }

            if (isset($item['children']) && is_array($item['children'])) {
                $item['children'] = $this->withoutShopLinks($item['children']);
            }

            $cleaned[] = $item;
        }

        return $cleaned;
    }

    protected function menuPath(mixed $url): string
    {
        if (! filled($url)) {
            return '';
        }

        $path = parse_url((string) $url, PHP_URL_PATH);

        if (! is_string($path) || $path === '') {
            $path = (string) $url;
        }

        if (! str_starts_with($path, '/')) {
            $path = '/'.$path;
        }

        return rtrim($path, '/') === '' ? '/' : rtrim($path, '/');
    }
};
