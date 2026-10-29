@php
    $tone = $tone ?? 'white';
    $layout = $layout ?? 'split';
    $isBillingCollage = str_contains((string) ($image ?? ''), 'billing-image')
        || ($headline ?? '') === 'EHR / EMR Integration';

    if ($layout !== 'integrations' && $isBillingCollage) {
        $layout = 'integrations';
    }

    $systems = collect($systems ?? [])
        ->map(fn ($item) => is_array($item) ? ($item['label'] ?? $item['name'] ?? '') : $item)
        ->filter(fn ($label) => filled($label))
        ->values();

    if ($systems->isEmpty() && $layout === 'integrations') {
        $systems = collect(['Epic', 'Cerner', 'MEDITECH', 'athenahealth', 'eClinicalWorks', 'Allscripts', 'NextGen']);
    }
    $sectionClass = match ($tone) {
        'surface' => 'section-pad bg-white',
        'soft' => 'section-pad bg-brand-soft',
        'navy' => 'section-pad bg-navy text-white',
        default => 'section-pad bg-white',
    };
@endphp

@if($layout === 'integrations')
    <section class="ehr-band relative overflow-hidden bg-[#07111F] py-16 sm:py-[88px]">
        <div class="pointer-events-none absolute inset-0 bg-[#07111F]"></div>
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top,_rgba(11,89,172,0.32),_transparent_58%)]"></div>
        <div class="pointer-events-none absolute -left-24 bottom-[-6rem] h-72 w-72 rounded-full bg-[#F79F12]/10 blur-3xl"></div>
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-[#F79F12]/45 to-transparent"></div>

        <div class="container-site relative">
            <div class="mx-auto max-w-3xl text-center">
                <div class="mx-auto mb-5 h-1 w-10 rounded-sm bg-[#f5a915]"></div>
                @if(!empty($eyebrow))
                    <p class="mb-3 text-[12px] font-semibold uppercase tracking-[0.2em] text-[#8EC4F5]">{{ $eyebrow }}</p>
                @endif
                <h2 class="text-[1.9rem] font-semibold leading-[1.18] tracking-[-0.025em] text-white sm:text-[2.35rem]">{!! $headline_html !!}</h2>
                @if(!empty($body))
                    <div class="prose-cms mx-auto mt-5 max-w-[640px]">{!! $body !!}</div>
                @endif
                @if($systems->isNotEmpty())
                    <ul class="mt-8 flex flex-wrap justify-center gap-2">
                        @foreach($systems as $system)
                            <li class="rounded-full border border-white/15 bg-white/10 px-3.5 py-1.5 text-[13px] font-medium text-white/85">{{ $system }}</li>
                        @endforeach
                    </ul>
                @endif
                @if(!empty($button_label))
                    <a href="{{ cms_url($button_url ?? '#contact') }}" class="btn-accent mt-8">{{ $button_label }}</a>
                @endif
            </div>

            @if(!empty($image))
                <div class="mt-12 lg:mt-16">
                    <img
                        src="{{ media_url($image) }}"
                        alt="{{ $image_alt ?? $headline ?? '' }}"
                        class="mx-auto w-full max-w-[1080px] object-contain"
                        loading="eager"
                        decoding="async"
                    >
                </div>
            @endif
        </div>
    </section>
@else
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
@endif
