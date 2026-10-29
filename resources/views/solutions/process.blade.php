@php
    $stepCount = count($steps ?? []);
    $stepGrid = match (true) {
        $stepCount <= 1 => 'lg:grid-cols-1',
        $stepCount === 2 => 'lg:grid-cols-2',
        $stepCount === 3 => 'lg:grid-cols-3',
        default => 'lg:grid-cols-4',
    };
@endphp
<section @if(!empty($anchor)) id="{{ $anchor }}" @endif class="border-t border-[#F2F4F7] bg-white py-16 sm:py-[88px]">
    <div class="container-site">
        @include('solutions._heading', [
            'headline' => $headline ?? null,
            'headline_html' => $headline_html ?? null,
            'intro' => $intro ?? null,
        ])
        <div class="mt-12 grid gap-6 sm:grid-cols-2 {{ $stepGrid }}">
            @foreach($steps ?? [] as $i => $step)
                <div class="flex flex-col gap-4">
                    @if(!empty($step['image']))
                        <img src="{{ media_url($step['image']) }}" alt="{{ $step['title'] ?? '' }}" class="aspect-[4/3] w-full rounded-xl object-cover" loading="lazy">
                    @endif
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#0B59AC] text-[15px] font-bold text-white">{{ $i + 1 }}</span>
                        <h3 class="text-xl font-bold text-[#101828]">{{ $step['title'] ?? '' }}</h3>
                    </div>
                    <p class="text-base leading-[1.6] text-[#475467]">{{ $step['body'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
