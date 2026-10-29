@php
    $tones = ['red', 'blue', 'amber', 'pink', 'purple', 'green', 'blue', 'gray'];
    $showPills = $show_pills ?? true;
    $pills = collect($tags ?? [])
        ->map(fn ($tag): array => is_string($tag) ? ['label' => $tag] : $tag)
        ->filter(fn (array $tag): bool => filled($tag['label'] ?? null))
        ->values();

    if ($showPills && $pills->isEmpty()) {
        $pills = collect($items ?? [])
            ->map(fn (array $item, int $index): array => [
                'label' => $item['name'] ?? '',
                'tone' => $tones[$index % count($tones)],
            ])
            ->filter(fn (array $tag): bool => filled($tag['label']))
            ->values();
    }

    if (! $showPills) {
        $pills = collect();
    }
@endphp
<section class="border-t border-[#F2F4F7] bg-white py-16 sm:py-[88px]">
    <div class="container-site grid items-start gap-10 lg:grid-cols-2 lg:items-center lg:gap-12">
        <div>
            @include('solutions._heading', [
                'headline' => $headline ?? null,
                'headline_html' => $headline_html ?? null,
                'intro' => $intro ?? null,
                'subhead' => $eyebrow ?? null,
            ])
            @if($pills->isNotEmpty())
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach($pills as $index => $pill)
                        @include('solutions._pill', [
                            'label' => $pill['label'],
                            'tone' => $pill['tone'] ?? $tones[$index % count($tones)],
                            'class' => 'mb-0 text-[13px]',
                        ])
                    @endforeach
                </div>
            @endif
            @if(!empty($closing))
                <p class="mt-5 text-[17px] font-semibold text-[#101828]">{{ $closing }}</p>
            @endif
        </div>
        <div class="grid min-w-0 grid-cols-2 gap-2 sm:grid-cols-3 sm:gap-3">
            @foreach($items ?? [] as $item)
                <div class="flex aspect-square min-w-0 items-center justify-center overflow-hidden rounded-xl bg-white p-2 sm:p-3">
                    @if(!empty($item['image']))
                        <img src="{{ media_url($item['image']) }}" alt="{{ $item['name'] ?? '' }}" class="h-auto max-h-[82%] w-auto max-w-[82%] object-contain" loading="lazy">
                    @else
                        <span class="px-1 text-center text-[11px] font-medium leading-snug text-[#475467] sm:text-xs">{{ $item['name'] ?? '' }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
