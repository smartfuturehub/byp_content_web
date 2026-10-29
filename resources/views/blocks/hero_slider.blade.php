@php
    $slides = collect($slides ?? [])->filter(fn ($slide) => filled($slide['image'] ?? null) || filled($slide['headline'] ?? null))->values();
@endphp
@if($slides->isNotEmpty())
<section
    id="hero-slider"
    class="relative isolate overflow-hidden bg-[#0A1628] text-white"
    x-data="{
        i: 0,
        total: {{ $slides->count() }},
        timer: null,
        go(n) { this.i = (n + this.total) % this.total; this.restart() },
        restart() {
            clearInterval(this.timer)
            this.timer = setInterval(() => { this.i = (this.i + 1) % this.total }, 7000)
        }
    }"
    x-init="restart()"
    @mouseenter="clearInterval(timer)"
    @mouseleave="restart()"
>
    <div class="relative w-full overflow-hidden" style="aspect-ratio: 1349 / 516; min-height: 16rem;">
        @foreach($slides as $index => $slide)
            @php $slideUrl = $slide['cta_url'] ?? null; @endphp
            <article
                class="absolute inset-0"
                :class="i === {{ $index }} ? 'z-[1]' : 'pointer-events-none z-0'"
                :style="'opacity:' + (i === {{ $index }} ? '1' : '0') + ';visibility:' + (i === {{ $index }} ? 'visible' : 'hidden') + ';z-index:' + (i === {{ $index }} ? '1' : '0')"
            >
                @if(!empty($slide['image']))
                    @if($slideUrl)
                        <a href="{{ cms_url($slideUrl) }}" class="absolute inset-0 block" aria-label="{{ $slide['headline'] ?? $slide['image_alt'] ?? 'View solution' }}">
                            <img
                                src="{{ media_url($slide['image']) }}"
                                alt="{{ $slide['image_alt'] ?? $slide['headline'] ?? 'BYP Health' }}"
                                class="absolute inset-0 size-full object-cover object-center"
                                style="width: 100%; height: 100%; max-width: none; object-fit: cover;"
                                @if($index === 0) fetchpriority="high" @endif
                            >
                        </a>
                    @else
                        <img
                            src="{{ media_url($slide['image']) }}"
                            alt="{{ $slide['image_alt'] ?? $slide['headline'] ?? 'BYP Health' }}"
                            class="absolute inset-0 size-full object-cover object-center"
                            style="width: 100%; height: 100%; max-width: none; object-fit: cover;"
                            @if($index === 0) fetchpriority="high" @endif
                        >
                    @endif
                @endif
                @if(($slide['overlay'] ?? true) !== false)
                    <div class="absolute inset-0 bg-gradient-to-r from-[#071428]/92 via-[#0B59AC]/72 to-[#0B59AC]/25"></div>
                    <div class="relative z-10 flex h-full items-center">
                        <div class="container-site py-20 sm:py-28">
                            <div class="max-w-2xl">
                                @if(!empty($slide['eyebrow']))
                                    <p class="mb-5 inline-flex rounded-full bg-white/15 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-white/90 backdrop-blur-sm">{{ $slide['eyebrow'] }}</p>
                                @endif
                                @if(!empty($slide['headline']) || !empty($slide['headline_html']))
                                    <h1 class="font-sans text-[2.15rem] font-bold leading-[1.12] tracking-[-0.03em] sm:text-5xl lg:text-[3.4rem]">{!! $slide['headline_html'] ?? e($slide['headline'] ?? '') !!}</h1>
                                @endif
                                @if(!empty($slide['body']))
                                    <p class="mt-6 max-w-xl text-base leading-8 text-white/85 sm:text-lg">{{ $slide['body'] }}</p>
                                @endif
                                @if(!empty($slide['cta_label']))
                                    <a href="{{ cms_url($slide['cta_url'] ?? '/contact-us') }}" class="btn-accent mt-8">{{ $slide['cta_label'] }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </article>
        @endforeach
    </div>

    @if($slides->count() > 1)
        <button type="button" class="absolute left-3 top-1/2 z-20 hidden size-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/15 text-white backdrop-blur-md hover:bg-white/30 sm:inline-flex" @click="go(i - 1)" aria-label="Previous slide">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button type="button" class="absolute right-3 top-1/2 z-20 hidden size-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/15 text-white backdrop-blur-md hover:bg-white/30 sm:inline-flex" @click="go(i + 1)" aria-label="Next slide">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
        <div class="absolute bottom-6 left-0 right-0 z-20 flex justify-center gap-2">
            @foreach($slides as $index => $slide)
                <button type="button" class="h-2.5 rounded-full transition-all" :class="i === {{ $index }} ? 'w-8 bg-accent' : 'w-2.5 bg-white/50 hover:bg-white'" @click="go({{ $index }})" aria-label="Go to slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
    @endif
</section>
@endif
