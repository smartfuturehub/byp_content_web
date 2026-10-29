<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::query()
            ->published()
            ->with('category')
            ->when($request->string('category')->toString(), function ($query, $slug) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $slug));
            })
            ->latest('published_at')
            ->paginate(9);

        $categories = Category::query()->where('type', 'post')->orderBy('name')->get();

        return view('blog.index', [
            'posts' => $posts,
            'categories' => $categories,
            'currentCategory' => $request->string('category')->toString(),
            'metaTitle' => 'Blog | '.setting('site_name', 'BYP Health'),
            'metaDescription' => 'Articles, research and updates on remote patient monitoring and connected care.',
            'canonical' => url('/blog'),
            'ogType' => 'website',
            'robots' => Seo::robots('index,follow'),
            'jsonLd' => Seo::jsonLd([
                Seo::organization(),
                Seo::website(),
                Seo::breadcrumbs([
                    ['name' => 'Home', 'url' => url('/')],
                    ['name' => 'Blog', 'url' => url('/blog')],
                ]),
            ]),
            'breadcrumbs' => [],
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::query()->published()->with('category')->where('slug', $slug)->firstOrFail();
        $related = Post::query()->published()->where('id', '!=', $post->id)->latest('published_at')->limit(3)->get();

        return view('blog.show', [
            'post' => $post,
            'related' => $related,
            'metaTitle' => $post->seoTitle(),
            'metaDescription' => $post->seoDescription(),
            'canonical' => $post->seo_canonical ?: $post->url(),
            'ogImage' => $post->socialImage(),
            'ogImageAlt' => $post->title,
            'ogType' => 'article',
            'publishedAt' => $post->published_at?->toIso8601String(),
            'modifiedAt' => $post->updated_at?->toIso8601String(),
            'articleAuthor' => $post->displayAuthor(),
            'robots' => Seo::robots($post->robots ?: 'index,follow'),
            'jsonLd' => Seo::jsonLd([
                Seo::organization(),
                Seo::website(),
                Seo::article($post),
                Seo::breadcrumbs([
                    ['name' => 'Home', 'url' => url('/')],
                    ['name' => 'Blog', 'url' => url('/blog')],
                    ['name' => $post->title, 'url' => $post->url()],
                ]),
            ]),
            'breadcrumbs' => [],
        ]);
    }
}
