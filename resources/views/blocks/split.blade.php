@php
    $tone = $tone ?? 'white';
    $sectionClass = match ($tone) {
        'surface' => 'section-pad bg-white',
        'soft' => 'section-pad bg-brand-soft',
        default => 'section-pad bg-white',
    };
@endphp

<section class="{{ $sectionClass }}">
    <div class="container-site grid items-center gap-12 lg:grid-cols-2 lg:gap-20">
        <div class="{{ !empty($image_right) ? '' : 'lg:order-2' }}">
            @if(!empty($eyebrow))
                <p class="eyebrow mb-4">{{ $eyebrow }}</p>
            @endif
            <h2 class="display-h2">{!! $headline_html !!}</h2>
            <div class="prose-cms mt-5">{!! $body ?? '' !!}</div>
            @if(!empty($button_label))
                <a href="{{ cms_url($button_url ?? '#') }}" class="btn-primary mt-8">{{ $button_label }}</a>
            @endif
        </div>
        @if(!empty($image))
            <div class="{{ !empty($image_right) ? '' : 'lg:order-1' }}">
                <div class="overflow-hidden rounded-[1.5rem] shadow-[0_24px_60px_rgba(10,22,40,0.12)]">
                    <img
                        src="{{ media_url($image) }}"
                        alt="{{ $image_alt ?? $headline ?? '' }}"
                        class="aspect-[4/3] w-full {{ ($fit ?? 'cover') === 'contain' ? 'object-contain bg-white p-8' : 'object-cover' }}"
                        loading="lazy"
                    >
                </div>
            </div>
        @endif
    </div>
</section>
