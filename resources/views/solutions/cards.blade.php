@php
    $variant = $variant ?? 'photo';
    $columns = (string) ($columns ?? '3');
    $fit = $fit ?? 'cover';
    $grid = match ($columns) {
        '1' => 'grid-cols-1',
        '2' => 'sm:grid-cols-2',
        '4' => 'sm:grid-cols-2 lg:grid-cols-4',
        default => 'sm:grid-cols-2 lg:grid-cols-3',
    };
@endphp
<section @if(!empty($anchor)) id="{{ $anchor }}" @endif class="border-t border-[#F2F4F7] bg-white py-16 sm:py-[88px]">
    <div class="container-site">
        @include('solutions._heading', [
            'headline' => $headline ?? null,
            'headline_html' => $headline_html ?? null,
            'intro' => $intro ?? null,
        ])

        @if($variant === 'tile')
            <div class="mt-9 grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 lg:grid-cols-4">
                @foreach($items ?? [] as $item)
                    @php $tag = !empty($item['url']) ? 'a' : 'article'; @endphp
                    <{{ $tag }} @if(!empty($item['url'])) href="{{ cms_url($item['url']) }}" @endif class="overflow-hidden rounded-xl border border-[#E5E7EB] bg-white text-[#101828] no-underline">
                        @if(!empty($item['image']))
                            @php $itemFit = $item['fit'] ?? $fit; @endphp
                            <div class="aspect-[4/3] overflow-hidden bg-[#F4F7FB]">
                                <img src="{{ media_url($item['image']) }}" alt="{{ $item['title'] ?? '' }}" class="h-full w-full {{ $itemFit === 'contain' ? 'object-contain p-3' : 'object-cover' }}" loading="lazy">
                            </div>
                        @endif
                        <div class="px-3.5 py-3.5 text-[15px] font-semibold leading-snug">{{ $item['title'] ?? '' }}</div>
                    </{{ $tag }}>
                @endforeach
            </div>
        @elseif($variant === 'feature')
            <div class="mt-12 grid gap-6 {{ $grid }}">
                @foreach($items ?? [] as $item)
                    <article class="flex h-full flex-col gap-2.5 rounded-2xl border border-[#E5E7EB] bg-white p-6 sm:p-7">
                        @if(!empty($item['image']))
                            <img src="{{ media_url($item['image']) }}" alt="{{ $item['title'] ?? '' }}" class="mb-1 aspect-[16/10] w-full rounded-xl object-cover" loading="lazy">
                        @endif
                        @if(!empty($item['badge']) && empty($item['title']))
                            @include('solutions._pill', ['label' => $item['badge'], 'tone' => $item['badge_tone'] ?? 'blue', 'class' => 'mb-1 self-start'])
                        @endif
                        @if(!empty($item['title']))
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-xl font-bold leading-snug text-[#101828]">{{ $item['title'] }}</h3>
                                @if(!empty($item['badge']))
                                    @include('solutions._pill', ['label' => $item['badge'], 'tone' => $item['badge_tone'] ?? 'blue', 'class' => 'mb-0 text-xs'])
                                @endif
                            </div>
                        @endif
                        @if(!empty($item['sections']))
                            <div class="space-y-4">
                                @foreach($item['sections'] as $section)
                                    @if(!empty($section['body']))
                                        <p class="text-base leading-[1.55] text-[#475467]">
                                            @if(!empty($section['label']))
                                                <strong class="font-semibold text-[#101828]">{{ $section['label'] }}:</strong>
                                            @endif
                                            {{ $section['body'] }}
                                        </p>
                                    @endif
                                @endforeach
                            </div>
                        @elseif(!empty($item['body']))
                            <p class="text-base leading-[1.55] text-[#475467]">{{ $item['body'] }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        @else
            <div class="mt-12 grid gap-6 {{ $grid }}">
                @foreach($items ?? [] as $item)
                    @php $tag = !empty($item['url']) ? 'a' : 'article'; @endphp
                    <{{ $tag }} @if(!empty($item['url'])) href="{{ cms_url($item['url']) }}" @endif class="group flex flex-col overflow-hidden rounded-2xl border border-[#E5E7EB] bg-white text-[#101828] no-underline">
                        @if(!empty($item['image']))
                            @php $itemFit = $item['fit'] ?? $fit; @endphp
                            <div class="aspect-[4/3] overflow-hidden bg-white">
                                <img src="{{ media_url($item['image']) }}" alt="{{ $item['title'] ?? '' }}" class="h-full w-full {{ $itemFit === 'contain' ? 'object-contain p-5' : 'object-cover' }}" loading="lazy">
                            </div>
                        @endif
                        <div class="flex flex-1 flex-col gap-3 p-6">
                            @if(!empty($item['badge']))
                                @include('solutions._pill', ['label' => $item['badge'], 'tone' => $item['badge_tone'] ?? 'blue', 'class' => 'mb-0 self-start'])
                            @endif
                            @if(!empty($item['title']))
                                <h3 class="text-[22px] font-bold leading-snug">{{ $item['title'] }}</h3>
                            @endif
                            @if(!empty($item['body']))
                                <p class="flex-1 text-base leading-[1.55] text-[#475467]">{{ $item['body'] }}</p>
                            @endif
                            @if(!empty($item['pills']))
                                <div class="mt-1 flex flex-wrap gap-2">
                                    @foreach($item['pills'] as $pill)
                                        @php $pillLabel = is_array($pill) ? ($pill['label'] ?? '') : $pill; @endphp
                                        @if(filled($pillLabel))
                                            @include('solutions._pill', ['label' => $pillLabel, 'tone' => is_array($pill) ? ($pill['tone'] ?? 'gray') : 'gray', 'class' => 'mb-0 text-[13px]'])
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            @if(!empty($item['url']))
                                <span class="text-[15px] font-medium text-[#0B59AC]">Learn more →</span>
                            @endif
                        </div>
                    </{{ $tag }}>
                @endforeach
            </div>
        @endif
    </div>
</section>
