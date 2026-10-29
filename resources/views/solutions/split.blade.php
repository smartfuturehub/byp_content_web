@php
    $stacked = ($layout ?? 'split') === 'stack';
    $imageFirst = ! $stacked && empty($image_right);
@endphp
<section class="border-t border-[#F2F4F7] bg-white py-16 sm:py-[88px]">
    <div @class([
        'container-site',
        'flex flex-col gap-10' => $stacked,
        'grid items-center gap-12 lg:grid-cols-2 lg:gap-14' => ! $stacked,
    ])>
        <div @class(['lg:order-2' => $imageFirst])>
            @include('solutions._heading', [
                'headline' => $headline ?? null,
                'headline_html' => $headline_html ?? null,
                'subhead' => $eyebrow ?? null,
            ])
            <div class="prose-cms mt-5">{!! $body ?? '' !!}</div>
            @if(!empty($button_label))
                <a href="{{ cms_url($button_url ?? '#') }}" class="mt-8 inline-flex items-center justify-center rounded-full bg-[#0B59AC] px-[30px] py-4 text-base font-medium text-white hover:bg-[#034D7E]">{{ $button_label }}</a>
            @endif
        </div>
        @if(!empty($image))
            <div @class(['lg:order-1' => $imageFirst])>
                <img
                    src="{{ media_url($image) }}"
                    alt="{{ $image_alt ?? $headline ?? '' }}"
                    @class([
                        'w-full rounded-[20px]',
                        ($fit ?? 'cover') === 'contain' ? 'bg-white object-contain p-6' : 'object-cover',
                        $stacked ? 'max-h-[32rem]' : 'aspect-video',
                    ])
                    loading="lazy"
                >
            </div>
        @endif
    </div>
</section>
