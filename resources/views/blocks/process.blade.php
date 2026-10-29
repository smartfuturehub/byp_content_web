<section @if(!empty($anchor)) id="{{ $anchor }}" @endif class="section-pad bg-white">
    <div class="container-site">
        @if(!empty($headline))
            <h2 class="display-h2 max-w-3xl">{!! $headline_html !!}</h2>
        @endif
        <ol class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach($steps ?? [] as $i => $step)
                <li class="relative rounded-[1.5rem] border border-line bg-white p-7">
                    <span class="font-display text-3xl font-semibold text-brand/25">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="mt-4 text-lg font-semibold text-navy">{{ $step['title'] ?? '' }}</h3>
                    <p class="mt-3 text-sm leading-6 text-muted">{{ $step['body'] ?? '' }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>
