@php
    $variant = $variant ?? 'panel';
@endphp

@if($variant === 'strip')
<section class="relative z-[1] -mt-10 pb-4 sm:-mt-14">
    <div class="container-site">
        @if(!empty($headline) || !empty($body))
            <div class="mb-8 max-w-3xl">
                @if(!empty($headline))
                    <h2 class="font-display text-3xl font-semibold tracking-[-0.025em] text-navy sm:text-4xl">{!! $headline_html !!}</h2>
                @endif
                @if(!empty($body))
                    <p class="mt-4 text-[17px] leading-8 text-muted">{{ $body }}</p>
                @endif
            </div>
        @endif
        <div class="grid grid-cols-2 gap-6 rounded-[1.75rem] border border-line bg-white px-5 py-8 shadow-[0_24px_70px_rgba(10,22,40,0.12)] sm:px-8 lg:grid-cols-4 lg:gap-0 lg:divide-x lg:divide-line lg:px-4 lg:py-10">
            @foreach($items ?? [] as $item)
                <div class="lg:px-8">
                    <p class="font-display text-4xl font-semibold tracking-[-0.04em] text-navy sm:text-5xl">
                        <span data-counter="{{ preg_replace('/[^0-9]/', '', $item['value'] ?? '0') }}">{{ $item['value'] ?? '0' }}</span><span class="text-accent">{{ $item['suffix'] ?? '+' }}</span>
                    </p>
                    <p class="mt-2 text-sm leading-6 text-muted">{{ $item['label'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@else
<section class="section-pad bg-navy text-white">
    <div class="container-site grid items-center gap-12 lg:grid-cols-2">
        <div class="grid grid-cols-2 gap-8">
            @foreach($items ?? [] as $item)
                <div>
                    <p class="font-display text-4xl font-semibold tracking-[-0.04em] text-white">
                        <span data-counter="{{ preg_replace('/[^0-9]/', '', $item['value'] ?? '0') }}">{{ $item['value'] ?? '0' }}</span><span class="text-accent">{{ $item['suffix'] ?? '+' }}</span>
                    </p>
                    <p class="mt-2 text-sm text-white/60">{{ $item['label'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
        <div>
            <h2 class="display-h2 text-white">{!! $headline_html !!}</h2>
            @if(!empty($body))
                <p class="mt-5 text-[17px] leading-8 text-white/70">{{ $body }}</p>
            @endif
        </div>
    </div>
</section>
@endif
