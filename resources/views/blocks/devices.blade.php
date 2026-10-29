@php
    $tones = ['red', 'blue', 'amber', 'pink', 'purple', 'green', 'blue', 'gray'];
    $pills = collect($tags ?? [])
        ->map(fn ($tag): array => is_string($tag) ? ['label' => $tag] : $tag)
        ->filter(fn (array $tag): bool => filled($tag['label'] ?? null))
        ->values();

    if ($pills->isEmpty()) {
        $pills = collect($items ?? [])
            ->map(fn (array $item, int $index): array => [
                'label' => $item['name'] ?? '',
                'tone' => $tones[$index % count($tones)],
            ])
            ->filter(fn (array $tag): bool => filled($tag['label']))
            ->values();
    }
    $pillClass = fn (string $tone): string => match ($tone) {
        'blue' => 'bg-[#F0F9FF] text-[#026AA2]',
        'red' => 'bg-[#FEF3F2] text-[#B42318]',
        'green' => 'bg-[#ECFDF3] text-[#027A48]',
        'purple' => 'bg-[#F9F5FF] text-[#6941C6]',
        'pink' => 'bg-[#FDF2FA] text-[#C11574]',
        'amber' => 'bg-[#FFFAEB] text-[#B54708]',
        'gray' => 'bg-[#F2F4F7] text-[#344054]',
        default => 'bg-[#FEF3D9] text-[#7A4B00]',
    };
@endphp
<section class="section-pad">
    <div class="container-site">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="display-h2">{!! $headline_html !!}</h2>
            @if(!empty($intro))
                <p class="mt-4 text-muted">{{ $intro }}</p>
            @endif
            @if(($show_pills ?? true) && $pills->isNotEmpty())
                <div class="mt-6 flex flex-wrap justify-center gap-2">
                    @foreach($pills as $index => $pill)
                        <span class="inline-flex items-center rounded-2xl px-3 py-1.5 text-[13px] font-medium {{ $pillClass($pill['tone'] ?? $tones[$index % count($tones)]) }}">{{ $pill['label'] }}</span>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-3">
            @foreach($items ?? [] as $item)
                <div class="relative flex min-h-[140px] items-end overflow-hidden rounded-xl bg-[#0B59AC] bg-cover bg-center sm:min-h-[180px]" @if(!empty($item['image'])) style="background-image: url('{{ media_url($item['image']) }}')" @endif>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/55 to-black/5"></div>
                    <h3 class="relative z-10 p-4 text-sm font-semibold text-white sm:text-base">{{ $item['name'] ?? '' }}</h3>
                </div>
            @endforeach
        </div>
    </div>
</section>
