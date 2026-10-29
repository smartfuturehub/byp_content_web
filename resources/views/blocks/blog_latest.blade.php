<section class="section-pad bg-white">
    <div class="container-site">
        <div class="mb-10 flex items-end justify-between gap-4">
            <h2 class="display-h2">{!! $headline_html !!}</h2>
            @if(!empty($button_label))
                <a href="{{ cms_url($button_url ?? '/blog') }}" class="hidden text-sm font-semibold text-brand hover:underline sm:inline">{{ $button_label }}</a>
            @endif
        </div>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach($posts ?? [] as $post)
                <a href="{{ $post->url() }}" class="group overflow-hidden rounded-[1.5rem] border border-line bg-white shadow-[0_12px_40px_rgba(10,22,40,0.04)]">
                    @if($post->featured_image)
                        <img src="{{ media_url($post->featured_image) }}" alt="{{ $post->title }}" class="h-44 w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                    @endif
                    <div class="p-5">
                        <p class="text-xs text-muted">{{ $post->displayAuthor() }} • {{ optional($post->published_at)->format('j M Y') }}</p>
                        <h3 class="mt-2 font-display font-semibold text-navy group-hover:text-brand">{{ $post->title }}</h3>
                        <p class="mt-2 line-clamp-3 text-sm text-muted">{{ $post->excerpt }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
