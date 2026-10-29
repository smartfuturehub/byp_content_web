<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0))
            ->add(Url::create('/blog')->setPriority(0.8));

        Page::query()->published()->get()->each(function (Page $page) use ($sitemap) {
            $sitemap->add(Url::create($page->url())->setLastModificationDate($page->updated_at));
        });

        Post::query()->published()->get()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(Url::create($post->url())->setLastModificationDate($post->updated_at));
        });

        return $sitemap->toResponse(request());
    }

    public function robots(): Response
    {
        $body = "User-agent: *\nAllow: /\nDisallow: /admin\n\nSitemap: ".url('/sitemap.xml')."\n";
        $extra = setting('robots_extra');

        if (filled($extra)) {
            $body .= "\n".$extra."\n";
        }

        return response($body, 200, ['Content-Type' => 'text/plain']);
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $pages = collect();
        $posts = collect();

        if (strlen($q) >= 2) {
            $pages = Page::query()->published()->where('title', 'like', "%{$q}%")->limit(8)->get();
            $posts = Post::query()->published()->where('title', 'like', "%{$q}%")->limit(8)->get();
        }

        return view('pages.search', [
            'q' => $q,
            'pages' => $pages,
            'posts' => $posts,
            'metaTitle' => ($q ? "Search results for {$q}" : 'Search').' | '.setting('site_name', 'BYP Health'),
            'metaDescription' => 'Search BYP Health pages and articles on remote patient monitoring and digital care.',
            'robots' => 'noindex,follow',
            'canonical' => url('/search'),
            'breadcrumbs' => [],
        ]);
    }
}
