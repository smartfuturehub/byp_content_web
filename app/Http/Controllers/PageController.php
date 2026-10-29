<?php

namespace App\Http\Controllers;

use App\Blocks\BlockRegistry;
use App\Models\Page;
use App\Support\Seo;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    public function home(): View
    {
        $page = Page::query()->published()->where('is_homepage', true)->first()
            ?? Page::query()->published()->where('slug', 'home')->first();

        if (! $page) {
            throw new NotFoundHttpException;
        }

        return $this->render($page, [
            Seo::organization(),
            Seo::website(),
            Seo::webPage($page),
        ]);
    }

    public function show(string $slug): View
    {
        $page = Page::query()->published()->where('slug', $slug)->firstOrFail();

        if ($page->is_homepage) {
            return redirect()->route('home');
        }

        $graph = [
            Seo::organization(),
            Seo::website(),
            Seo::webPage($page),
            Seo::breadcrumbs([
                ['name' => 'Home', 'url' => url('/')],
                ['name' => $page->title, 'url' => $page->url()],
            ]),
        ];

        return $this->render($page, $graph);
    }

    /**
     * @param  array<int, array<string, mixed>>  $graph
     */
    protected function render(Page $page, array $graph): View
    {
        $faqGraph = $this->faqJsonLd($page);

        if ($faqGraph !== null) {
            $graph[] = $faqGraph;
        }

        return view('pages.show', [
            'page' => $page,
            'content' => BlockRegistry::render($page->blocks),
            'jsonLd' => Seo::jsonLd($graph),
            'canonical' => $page->seo_canonical ?: $page->url(),
            'metaTitle' => $page->seoTitle(),
            'metaDescription' => $page->seoDescription(),
            'ogImage' => $page->socialImage(),
            'ogImageAlt' => $page->socialImageAlt(),
            'ogType' => 'website',
            'robots' => Seo::robots($page->robots ?: 'index,follow'),
            'isHome' => (bool) $page->is_homepage,
            'breadcrumbs' => [],
        ]);
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function faqJsonLd(Page $page): ?array
    {
        foreach ($page->blocks ?? [] as $block) {
            if (($block['type'] ?? null) !== 'faq') {
                continue;
            }

            $items = collect(BlockRegistry::viewData('faq', $block['data'] ?? [])['items'] ?? [])
                ->filter(fn (array $item): bool => filled($item['question'] ?? null));

            if ($items->isEmpty()) {
                return null;
            }

            return Seo::faqPage($items->values());
        }

        return null;
    }
}
