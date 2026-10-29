<section class="border-t border-[#F2F4F7] bg-white py-16 sm:py-[88px]">
    <div class="container-site">
        @include('solutions._heading', [
            'headline' => $headline ?? null,
            'headline_html' => $headline_html ?? null,
        ])
        <div class="mt-10 grid gap-8 sm:grid-cols-2 sm:gap-x-12 sm:gap-y-8">
            @foreach($items ?? [] as $item)
                <div>
                    <h3 class="text-lg font-bold text-[#101828]">{{ $item['question'] ?? '' }}</h3>
                    <div class="mt-2 text-[15px] leading-[1.65] text-[#475467]">{!! $item['answer'] ?? '' !!}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
