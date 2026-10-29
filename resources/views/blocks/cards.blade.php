@php
    $variant = $variant ?? 'photo';
    $columns = (string) ($columns ?? '3');
    $fit = $fit ?? 'cover';
    $tone = $tone ?? 'white';
    $grid = $columns === '4' ? 'lg:grid-cols-4' : ($columns === '2' ? 'lg:grid-cols-2' : 'lg:grid-cols-3');
    $sectionClass = match ($tone) {
        'surface' => 'section-pad bg-white',
        'soft' => 'section-pad bg-brand-soft',
        'navy' => 'section-pad bg-navy text-white',
        default => 'section-pad bg-white',
    };

    if ($variant === 'feature') {
        $sectionClass = match ($tone) {
            'navy' => 'border-t border-white/10 bg-navy py-16 text-white sm:py-[88px]',
            'soft' => 'border-t border-[#F2F4F7] bg-brand-soft py-16 sm:py-[88px]',
            default => 'border-t border-[#F2F4F7] bg-[#FAFAFA] py-16 sm:py-[88px]',
        };
    }
@endphp

<section @if(!empty($anchor)) id="{{ $anchor }}" @endif class="{{ $sectionClass }}">
    <div class="container-site">
        @if(!empty($headline) || !empty($intro))
            <div>
                @if($tone !== 'navy')
                    <div class="mb-5 h-1 w-10 rounded-sm bg-[#f5a915]"></div>
                @endif
                @if(!empty($headline))
                    <h2 class="text-[2rem] font-semibold leading-[1.15] tracking-[-0.03em] sm:text-[2.75rem] {{ $tone === 'navy' ? 'text-white' : 'text-[#101828]' }}">{!! $headline_html !!}</h2>
                @endif
                @if(!empty($intro))
                    <p class="mt-3 max-w-[760px] text-lg leading-[1.6] {{ $tone === 'navy' ? 'text-white/70' : 'text-[#475467]' }}">{{ $intro }}</p>
                @endif
            </div>
        @endif

        @if($variant === 'feature')
            <div class="feature-grid mt-12">
                @foreach($items ?? [] as $item)
                    <article class="flex h-full flex-col gap-2.5 rounded-2xl border p-7 {{ $tone === 'navy' ? 'border-white/10 bg-white/5' : 'border-[#E5E7EB] bg-white' }}">
                        @if(!empty($item['title']))
                            <h3 class="text-xl font-bold leading-snug {{ $tone === 'navy' ? 'text-white' : 'text-[#101828]' }}">{{ $item['title'] }}</h3>
                        @endif
                        @if(!empty($item['body']))
                            <p class="text-base leading-[1.55] {{ $tone === 'navy' ? 'text-white/70' : 'text-[#475467]' }}">{{ $item['body'] }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        @elseif($variant === 'tile')
            <div class="mt-9 grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 lg:grid-cols-4">
                @foreach($items ?? [] as $item)
                    @php $tag = !empty($item['url']) ? 'a' : 'article'; @endphp
                    <{{ $tag }} @if(!empty($item['url'])) href="{{ cms_url($item['url']) }}" @endif class="overflow-hidden rounded-xl border border-[#E5E7EB] bg-white text-navy no-underline">
                        @if(!empty($item['image']))
                            <div class="aspect-[4/3] overflow-hidden bg-[#F4F7FB]">
                                <img src="{{ media_url($item['image']) }}" alt="{{ $item['title'] ?? '' }}" class="h-full w-full object-cover" loading="lazy">
                            </div>
                        @endif
                        <div class="px-3.5 py-3.5 text-[15px] font-semibold leading-snug">{{ $item['title'] ?? '' }}</div>
                    </{{ $tag }}>
                @endforeach
            </div>
        @elseif($variant === 'bento')
            <div class="mt-12 grid gap-4 lg:grid-cols-3">
                @foreach($items ?? [] as $index => $item)
                    @php
                        $tag = !empty($item['url']) ? 'a' : 'article';
                        $featured = $index === 0;
                    @endphp
                    <{{ $tag }} @if(!empty($item['url'])) href="{{ cms_url($item['url']) }}" @endif class="group relative overflow-hidden rounded-[1.5rem] {{ $featured ? 'min-h-[420px] lg:col-span-2 lg:row-span-2 lg:min-h-[560px]' : 'min-h-[260px]' }}">
                        @if(!empty($item['image']))
                            <img src="{{ media_url($item['image']) }}" alt="{{ $item['title'] ?? '' }}" class="absolute inset-0 h-full w-full object-cover object-center transition duration-700 group-hover:scale-[1.04]" loading="lazy">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-navy via-navy/35 to-navy/5"></div>
                        <div class="relative flex h-full flex-col justify-end p-7 text-white sm:p-8">
                            @if(!empty($item['title']))
                                <h3 class="font-display font-semibold {{ $featured ? 'text-3xl lg:text-4xl' : 'text-xl' }}">{{ $item['title'] }}</h3>
                            @endif
                            @if(!empty($item['body']))
                                <p class="mt-2 max-w-lg text-sm leading-6 text-white/80 {{ $featured ? 'sm:text-base sm:leading-7' : '' }}">{{ $item['body'] }}</p>
                            @endif
                            @if(!empty($item['url']))
                                <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-accent">Explore <span aria-hidden="true">→</span></span>
                            @endif
                        </div>
                    </{{ $tag }}>
                @endforeach
            </div>
        @else
            <div class="mt-12 grid gap-6 sm:grid-cols-2 {{ $grid }}">
                @foreach($items ?? [] as $item)
                    @php
                        $tag = !empty($item['url']) ? 'a' : 'article';
                        $itemFit = $item['fit'] ?? $fit;
                        $cardAspect = $columns === '4' ? 'aspect-[4/3]' : 'aspect-[16/10]';
                        $badgeClass = match ($item['badge_tone'] ?? 'blue') {
                            'red' => 'bg-[#FEF3F2] text-[#B42318]',
                            'green' => 'bg-[#ECFDF3] text-[#027A48]',
                            'purple' => 'bg-[#F9F5FF] text-[#6941C6]',
                            default => 'bg-[#F0F9FF] text-[#026AA2]',
                        };
                    @endphp
                    <{{ $tag }} @if(!empty($item['url'])) href="{{ cms_url($item['url']) }}" @endif class="group flex flex-col overflow-hidden rounded-2xl border border-[#E5E7EB] bg-white transition hover:border-brand/30">
                        @if(!empty($item['image']))
                            <div class="{{ $cardAspect }} overflow-hidden bg-white">
                                <img
                                    src="{{ media_url($item['image']) }}"
                                    alt="{{ $item['title'] ?? '' }}"
                                    class="h-full w-full {{ $itemFit === 'contain' ? 'object-contain p-5' : 'object-cover object-center transition duration-500 group-hover:scale-[1.03]' }}"
                                    loading="lazy"
                                >
                            </div>
                        @endif
                        <div class="flex flex-1 flex-col p-6">
                            @if(!empty($item['badge']))
                                <span class="mb-3 inline-flex self-start rounded-2xl px-3 py-1 text-[13px] font-medium {{ $badgeClass }}">{{ $item['badge'] }}</span>
                            @endif
                            @if(!empty($item['title']))
                                <h3 class="text-xl font-bold text-navy group-hover:text-brand">{{ $item['title'] }}</h3>
                            @endif
                            @if(!empty($item['body']))
                                <p class="mt-2 flex-1 text-sm leading-6 text-muted">{{ $item['body'] }}</p>
                            @endif
                            @if(!empty($item['url']))
                                <p class="mt-4 text-sm font-semibold text-brand">Read More</p>
                            @endif
                        </div>
                    </{{ $tag }}>
                @endforeach
            </div>
        @endif
    </div>
</section>
