<section class="py-16 sm:py-[88px]">
    <div class="container-site">
        <div class="flex flex-wrap items-center justify-between gap-8 rounded-[30px] bg-[#0B59AC] px-10 py-12 text-white sm:px-[72px] sm:py-16">
            <div class="max-w-[620px]">
                <h2 class="text-[1.875rem] font-semibold leading-[1.15] tracking-[-0.03em] sm:text-[2.75rem]">{!! $headline_html !!}</h2>
                @if(!empty($body))
                    <p class="mt-4 text-lg leading-[1.6] text-white">{{ $body }}</p>
                @endif
            </div>
            @if(!empty($button_label))
                <a href="{{ cms_url($button_url ?? '/contact-us') }}" class="inline-flex items-center justify-center rounded-full bg-[#f5a915] px-[30px] py-4 text-base font-semibold text-[#1A1A1A] hover:bg-[#E0960C]">{{ $button_label }}</a>
            @endif
        </div>
    </div>
</section>
