@php
    $styleKey = $style ?? 'blue';
@endphp
<section class="bg-white py-16 sm:py-[88px]">
    <div class="container-site">
        <div @class([
            'flex flex-wrap items-center justify-between gap-8 rounded-[30px] px-10 py-12 sm:px-[72px] sm:py-16',
            'bg-[#F4F7FB] text-[#101828]' => $styleKey === 'light',
            'bg-[#101828] text-white' => $styleKey === 'navy',
            'bg-[#0B59AC] text-white' => $styleKey !== 'light' && $styleKey !== 'navy',
        ])>
            <div class="max-w-[620px]">
                <h2 class="text-[1.875rem] font-semibold leading-[1.15] tracking-[-0.03em] sm:text-[2.75rem]">{!! $headline_html !!}</h2>
                @if(!empty($body))
                    <p @class([
                        'mt-4 text-lg leading-[1.6]',
                        'text-[#475467]' => $styleKey === 'light',
                        'text-white' => $styleKey !== 'light',
                    ])>{{ $body }}</p>
                @endif
            </div>
            @if(!empty($button_label))
                <a
                    href="{{ cms_url($button_url ?? '/contact-us') }}"
                    @class([
                        'inline-flex items-center justify-center rounded-full px-[30px] py-4 text-base font-semibold',
                        'bg-[#0B59AC] text-white hover:bg-[#034D7E]' => $styleKey === 'light',
                        'bg-[#f5a915] text-[#1A1A1A] hover:bg-[#E0960C]' => $styleKey !== 'light',
                    ])
                >{{ $button_label }}</a>
            @endif
        </div>
    </div>
</section>
