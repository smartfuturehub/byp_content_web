@php
    $paragraphs = filled($body ?? null) ? preg_split("/\n+/", trim((string) $body)) : [];
@endphp
<section class="bg-white py-16 sm:py-20">
    <div class="container-site grid items-center gap-12 lg:grid-cols-2 lg:gap-12">
        <div>
            @if(!empty($eyebrow))
                @include('solutions._pill', ['label' => $eyebrow, 'tone' => $eyebrow_tone ?? 'blue'])
            @endif
            <h1 class="text-[2.5rem] font-bold leading-[1.02] tracking-[-0.04em] text-[#101828] sm:text-5xl lg:text-[4rem]">{!! $headline_html !!}</h1>
            @if(!empty($subhead) || !empty($caption))
                <p class="mt-4 text-[22px] font-medium leading-[1.4] text-[#0B59AC]">{{ $subhead ?? $caption }}</p>
            @endif
            @foreach($paragraphs as $paragraph)
                <p class="mt-5 text-lg leading-[1.6] text-[#475467]">{{ $paragraph }}</p>
            @endforeach
            <div class="mt-8 flex flex-wrap gap-3.5">
                @if(!empty($cta_label))
                    <a href="{{ cms_url($cta_url ?? '/contact-us') }}" class="inline-flex items-center justify-center rounded-full bg-[#0B59AC] px-[30px] py-4 text-base font-medium text-white hover:bg-[#034D7E]">{{ $cta_label }}</a>
                @endif
                @if(!empty($secondary_label))
                    <a href="{{ cms_url($secondary_url ?? '#') }}" class="inline-flex items-center justify-center rounded-full bg-[#f5a915] px-[30px] py-4 text-base font-semibold text-[#1A1A1A] hover:bg-[#E0960C]">{{ $secondary_label }}</a>
                @endif
            </div>
        </div>
        @if(!empty($image))
            <img
                src="{{ media_url($image) }}"
                alt="{{ $image_alt ?? 'BYP Health connected healthcare' }}"
                class="aspect-video w-full rounded-[20px] {{ ($fit ?? 'cover') === 'contain' ? 'bg-white object-contain p-6' : 'object-cover' }}"
                width="920"
                height="518"
            >
        @endif
    </div>
</section>
