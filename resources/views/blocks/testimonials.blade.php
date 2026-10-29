<section class="section-pad bg-white">
    <div class="container-site">
        <h2 class="display-h2 max-w-3xl">{!! $headline_html !!}</h2>
        <div class="mt-12 grid gap-5 lg:grid-cols-3">
            @foreach($items ?? [] as $item)
                <blockquote class="flex h-full flex-col rounded-[1.5rem] border border-line bg-white p-8 sm:p-9 {{ $loop->first ? 'lg:col-span-1' : '' }}">
                    <span class="font-display text-5xl leading-none text-accent">“</span>
                    <p class="mt-4 flex-1 text-[17px] leading-8 text-ink">{{ $item['quote'] ?? '' }}</p>
                    <footer class="mt-8">
                        <p class="text-sm font-semibold text-navy">{{ $item['name'] ?? '' }}</p>
                        <p class="mt-0.5 text-sm text-brand">{{ $item['organization'] ?? '' }}</p>
                    </footer>
                </blockquote>
            @endforeach
        </div>
    </div>
</section>
