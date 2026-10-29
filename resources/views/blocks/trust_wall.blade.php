@php
    $groups = $groups ?? [];
    $hasHeadline = filled($headline ?? null);
@endphp

<section class="border-t border-[#F2F4F7] bg-white py-16 sm:py-[88px]">
    <div class="container-site flex flex-col gap-16">
        @if($hasHeadline || !empty($intro))
            <div>
                <div class="mb-5 h-1 w-10 rounded-sm bg-[#f5a915]"></div>
                @if($hasHeadline)
                    <h2 class="text-[1.75rem] font-semibold tracking-[-0.03em] text-[#101828]">{!! $headline_html !!}</h2>
                @endif
                @if(!empty($intro))
                    <p class="mt-3 max-w-[760px] text-lg leading-[1.6] text-[#475467]">{{ $intro }}</p>
                @endif
            </div>
        @endif

        @foreach($groups as $group)
            <div>
                @if($hasHeadline)
                    <h3 class="mb-6 text-[1.75rem] font-semibold tracking-[-0.03em] text-[#101828]">{{ $group['label'] }}</h3>
                @else
                    <h2 class="mb-6 text-[1.75rem] font-semibold tracking-[-0.03em] text-[#101828]">{{ $group['label'] }}</h2>
                @endif
                <div class="logo-grid">
                    @foreach($group['items'] ?? [] as $item)
                        @include('partials.logo-cell', ['item' => $item])
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
