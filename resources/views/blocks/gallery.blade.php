@php
    $variant = $variant ?? 'scene';
    $isProduct = $variant === 'product';
@endphp

<section class="section-pad bg-white">
    <div class="container-site">
        @if(!empty($headline))
            <h2 class="text-center text-3xl font-semibold text-navy sm:text-4xl">{!! $headline_html !!}</h2>
        @endif
        @if(!empty($intro))
            <p class="mx-auto mt-4 max-w-3xl text-center leading-7 text-muted">{{ $intro }}</p>
        @endif
        <div class="mt-10 grid grid-cols-2 gap-4 {{ $isProduct ? 'md:grid-cols-4' : 'md:grid-cols-3' }}">
            @foreach($images ?? [] as $image)
                <figure class="overflow-hidden rounded-lg border border-line bg-white">
                    <img
                        src="{{ media_url($image['src'] ?? '') }}"
                        alt="{{ $image['alt'] ?? '' }}"
                        class="{{ $isProduct ? 'h-48 w-full object-contain p-6 sm:h-56' : 'h-52 w-full object-cover sm:h-64' }}"
                        loading="lazy"
                    >
                    @if(!empty($image['caption']))
                        <figcaption class="border-t border-line px-4 py-3 text-sm text-muted">{{ $image['caption'] }}</figcaption>
                    @endif
                </figure>
            @endforeach
        </div>
    </div>
</section>
