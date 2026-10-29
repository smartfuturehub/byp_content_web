@php
    $layout = $layout ?? 'split';
@endphp

@if($layout === 'home')
@php
    $paragraphs = filled($body ?? null) ? preg_split("/\n+/", trim((string) $body)) : [];
@endphp
<section class="bg-white">
    <div class="container-site py-16 sm:py-20 lg:pb-24 lg:pt-16">
        <div class="max-w-3xl">
            @if(!empty($eyebrow))
                <p class="mb-6 inline-flex rounded-2xl bg-[#FEF3D9] px-3.5 py-1.5 text-sm font-medium text-[#7A4B00]">{{ $eyebrow }}</p>
            @endif
            <h1 class="display-h1">{!! $headline_html !!}</h1>
            @if(!empty($subhead))
                <p class="mt-4 text-lg font-medium text-brand sm:text-xl">{{ $subhead }}</p>
            @endif
            @foreach($paragraphs as $paragraph)
                <p class="mt-5 max-w-[42rem] text-[17px] leading-8 text-muted sm:text-xl sm:leading-8">{{ $paragraph }}</p>
            @endforeach
            <div class="mt-9 flex flex-col gap-3 sm:flex-row sm:items-center">
                @if(!empty($cta_label))
                    <a href="{{ cms_url($cta_url ?? '/contact-us') }}" class="btn-primary">{{ $cta_label }}</a>
                @endif
                @if(!empty($secondary_label))
                    <a href="{{ cms_url($secondary_url ?? '#solutions') }}" class="btn-outline">{{ $secondary_label }}</a>
                @endif
            </div>
        </div>
        @if(!empty($image))
            <img
                src="{{ media_url($image) }}"
                alt="{{ $image_alt ?? 'BYP Health connected healthcare' }}"
                class="photo-frame mt-14 aspect-[16/8] w-full object-cover"
                width="1920"
                height="960"
            >
        @endif
    </div>
</section>
@elseif($layout === 'studio')
<section class="bg-white">
    <div class="container-site grid items-center gap-12 py-16 lg:grid-cols-12 lg:gap-16 lg:py-24">
        <div class="lg:col-span-6">
            @if(!empty($eyebrow))
                <p class="eyebrow mb-5">{{ $eyebrow }}</p>
            @endif
            <h1 class="display-h1">{!! $headline_html !!}</h1>
            @if(!empty($body))
                <p class="mt-6 max-w-[36rem] text-[17px] leading-8 text-muted">{{ $body }}</p>
            @endif
            <div class="mt-9 flex flex-col gap-3 sm:flex-row sm:items-center">
                @if(!empty($cta_label))
                    <a href="{{ cms_url($cta_url ?? '/contact-us') }}" class="btn-primary">{{ $cta_label }}</a>
                @endif
                @if(!empty($secondary_label))
                    <a href="{{ cms_url($secondary_url ?? '#') }}" class="btn-outline">{{ $secondary_label }}</a>
                @endif
            </div>
            @if(!empty($show_form))
                <div class="mt-8 max-w-lg">
                    <livewire:lead-form type="newsletter" :email-only="true" :button-label="$form_button ?? 'Book a demo'" :placeholder="$form_placeholder ?? 'Work email'" />
                </div>
            @endif
        </div>
        @if(!empty($image))
            <figure class="lg:col-span-6">
                <img
                    src="{{ media_url($image) }}"
                    alt="{{ $image_alt ?? 'BYP Health connected healthcare' }}"
                    class="photo-frame aspect-[5/4] h-auto shadow-[0_20px_50px_rgba(10,22,40,0.12)] {{ ($fit ?? 'cover') === 'contain' ? 'photo-contain' : '' }}"
                    width="920"
                    height="736"
                >
                @if(!empty($caption))
                    <figcaption class="mt-4 text-sm leading-6 text-muted">{{ $caption }}</figcaption>
                @endif
            </figure>
        @endif
    </div>
</section>
@elseif($layout === 'overlay')
<section class="relative isolate min-h-[68vh] overflow-hidden bg-navy text-white">
    @if(!empty($image))
        <img src="{{ media_url($image) }}" alt="{{ $image_alt ?? 'BYP Health connected healthcare' }}" class="absolute inset-0 h-full w-full object-cover object-center" width="1600" height="1060">
    @endif
    <div class="absolute inset-0 bg-navy/70"></div>
    <div class="container-site relative">
        <div class="grid min-h-[68vh] items-center py-16 lg:grid-cols-12 lg:py-20">
        <div class="lg:col-span-8">
            @if(!empty($eyebrow))
                <p class="eyebrow mb-5 text-white/70">{{ $eyebrow }}</p>
            @endif
            <h1 class="font-display text-[2.5rem] font-semibold leading-[1.12] tracking-[-0.03em] sm:text-5xl lg:text-[3.65rem]">{!! $headline_html !!}</h1>
            @if(!empty($body))
                <p class="mt-6 max-w-xl text-[17px] leading-8 text-white/78">{{ $body }}</p>
            @endif
            <div class="mt-9 flex flex-col gap-3 sm:flex-row sm:items-center">
                @if(!empty($cta_label))
                    <a href="{{ cms_url($cta_url ?? '/contact-us') }}" class="btn-accent">{{ $cta_label }}</a>
                @endif
                @if(!empty($secondary_label))
                    <a href="{{ cms_url($secondary_url ?? '#') }}" class="btn-ghost">{{ $secondary_label }}</a>
                @endif
            </div>
        </div>
        </div>
    </div>
</section>
@else
<section class="bg-white">
    <div class="container-site grid items-center gap-12 py-16 lg:grid-cols-2 lg:py-24">
        <div>
            @if(!empty($eyebrow))
                <p class="eyebrow mb-4">{{ $eyebrow }}</p>
            @endif
            <h1 class="display-h1">{!! $headline_html !!}</h1>
            @if(!empty($body))
                <p class="mt-6 max-w-xl text-[17px] leading-8 text-muted">{{ $body }}</p>
            @endif
            <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:items-center">
                @if(!empty($show_form))
                    <div class="w-full max-w-md">
                        <livewire:lead-form type="newsletter" :email-only="true" :button-label="$form_button ?? 'Let\'s Talk'" :placeholder="$form_placeholder ?? 'Enter your email'" />
                    </div>
                @endif
                @if(!empty($cta_label))
                    <a href="{{ cms_url($cta_url ?? '/contact-us') }}" class="btn-primary">{{ $cta_label }}</a>
                @endif
                @if(!empty($secondary_label))
                    <a href="{{ cms_url($secondary_url ?? '#') }}" class="text-sm font-semibold text-brand hover:underline">{{ $secondary_label }}</a>
                @endif
            </div>
        </div>
        @if(!empty($image))
            <img src="{{ media_url($image) }}" alt="{{ $image_alt ?? 'BYP Health connected healthcare' }}" class="photo-frame" width="720" height="560">
        @endif
    </div>
</section>
@endif
