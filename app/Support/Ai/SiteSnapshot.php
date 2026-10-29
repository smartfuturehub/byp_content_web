<?php

namespace App\Support\Ai;

use App\Models\Lead;
use App\Models\Logo;
use App\Models\MedicalDevice;
use App\Models\Page;
use App\Models\Post;
use App\Support\Analytics\Ga4Client;
use App\Support\Analytics\TrafficReport;
use Illuminate\Support\Str;

class SiteSnapshot
{
    public function __construct(
        private TrafficReport $trafficReport,
        private Ga4Client $ga4Client,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(int $days = 30): array
    {
        return [
            'site' => [
                'name' => setting('site_name', 'BYP Health'),
                'rules' => [
                    'Do not invent offices, countries, or statistics.',
                    'Do not invent logos or medical-device photos.',
                    'Image suggestions must use paths from image_allowlist only.',
                    'Header mega-menu stays four programmes: Hospital at Home, Emergency Care, Chronic Care, Facility-Based Care.',
                    'Never publish pages. New pages must stay drafts.',
                    'Brand blue is #0B59AC. Copy stays CMS-editable.',
                ],
            ],
            'pages' => $this->pages(),
            'posts' => $this->posts(),
            'image_allowlist' => $this->imageAllowList(),
            'leads_30d' => Lead::query()->where('created_at', '>=', now()->subDays($days))->count(),
            'traffic' => $this->trafficReport->forAssistant($days),
            'ga4' => $this->ga4Client->isConfigured()
                ? $this->ga4Client->overview($days)
                : ['configured' => false],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function pages(): array
    {
        return Page::query()
            ->orderBy('sort_order')
            ->get(['id', 'title', 'slug', 'status', 'is_homepage', 'seo_title', 'seo_description', 'og_image', 'featured_image', 'blocks'])
            ->map(function (Page $page): array {
                $excerpt = $this->excerptFromBlocks($page->blocks ?? []);

                return [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'status' => $page->status,
                    'is_homepage' => $page->is_homepage,
                    'seo_title' => $page->seo_title,
                    'seo_description' => $page->seo_description,
                    'has_og_image' => filled($page->og_image) || filled($page->featured_image),
                    'featured_image' => $page->featured_image,
                    'excerpt' => $excerpt,
                    'thin' => strlen($excerpt) < 80 && ! $page->is_homepage,
                ];
            })
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function posts(): array
    {
        return Post::query()
            ->latest('id')
            ->limit(12)
            ->get(['id', 'title', 'slug', 'status', 'excerpt', 'featured_image'])
            ->map(fn (Post $post): array => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'status' => $post->status,
                'excerpt' => Str::limit(strip_tags((string) $post->excerpt), 180),
                'featured_image' => $post->featured_image,
            ])
            ->all();
    }

    /**
     * @return list<string>
     */
    protected function imageAllowList(): array
    {
        $paths = Logo::query()->whereNotNull('image')->pluck('image')
            ->merge(MedicalDevice::query()->whereNotNull('image')->pluck('image'))
            ->merge(Page::query()->whereNotNull('featured_image')->pluck('featured_image'))
            ->merge(Page::query()->whereNotNull('og_image')->pluck('og_image'))
            ->merge(Post::query()->whereNotNull('featured_image')->pluck('featured_image'));

        foreach (Page::query()->get(['blocks']) as $page) {
            $paths = $paths->merge($this->imagesFromBlocks($page->blocks ?? []));
        }

        return $paths
            ->filter(fn (mixed $path): bool => filled($path) && is_string($path))
            ->map(fn (string $path): string => '/'.ltrim($path, '/'))
            ->unique()
            ->take(80)
            ->values()
            ->all();
    }

    /**
     * @param  array<int, mixed>  $blocks
     */
    protected function excerptFromBlocks(array $blocks): string
    {
        $chunks = [];

        foreach ($blocks as $block) {
            if (! is_array($block)) {
                continue;
            }

            $data = is_array($block['data'] ?? null) ? $block['data'] : [];

            foreach (['headline', 'body', 'intro', 'subhead'] as $field) {
                if (filled($data[$field] ?? null)) {
                    $chunks[] = strip_tags((string) $data[$field]);
                }
            }
        }

        return Str::limit(trim(implode(' ', $chunks)), 240);
    }

    /**
     * @param  array<int, mixed>  $blocks
     * @return list<string>
     */
    protected function imagesFromBlocks(array $blocks): array
    {
        $images = [];

        $walk = function (mixed $value) use (&$images, &$walk): void {
            if (! is_array($value)) {
                return;
            }

            foreach ($value as $key => $item) {
                if (is_string($key) && in_array($key, ['image', 'poster', 'og_image', 'featured_image', 'src'], true) && is_string($item) && $item !== '') {
                    $images[] = $item;
                }

                $walk($item);
            }
        };

        $walk($blocks);

        return $images;
    }
}
