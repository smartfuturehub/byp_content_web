@if(!empty($headline) || !empty($headline_html) || !empty($intro) || !empty($subhead))
    <div class="w-full text-left">
        <div class="mb-5 h-1 w-10 rounded-sm bg-[#f5a915]"></div>
        @if(!empty($headline_html) || !empty($headline))
            <h2 class="w-full text-[2rem] font-semibold leading-[1.15] tracking-[-0.03em] text-[#101828] sm:text-[2.75rem]">{!! $headline_html ?? e($headline) !!}</h2>
        @endif
        @if(!empty($subhead))
            <p class="mt-3 text-xl font-medium text-[#0B59AC]">{{ $subhead }}</p>
        @endif
        @if(!empty($intro))
            <p class="mt-3 text-lg leading-[1.6] text-[#475467]">{{ $intro }}</p>
        @endif
    </div>
@endif
