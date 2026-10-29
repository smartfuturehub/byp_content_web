@php
    $style = $style ?? 'light';
@endphp

@if($style === 'navy')
<section class="relative overflow-hidden bg-navy py-20 text-white sm:py-28">
    <div class="absolute -right-24 top-10 h-72 w-72 rounded-full bg-brand/30 blur-3xl"></div>
    <div class="absolute -left-16 bottom-0 h-56 w-56 rounded-full bg-accent/20 blur-3xl"></div>
    <div class="container-site relative grid items-center gap-12 lg:grid-cols-2">
        <div>
            @if(!empty($headline))
                <h2 class="display-h2 text-white">{!! $headline_html !!}</h2>
            @endif
            @if(!empty($intro))
                <p class="mt-5 max-w-xl text-[17px] leading-8 text-white/75">{{ $intro }}</p>
            @endif
        </div>
        <div class="rounded-3xl bg-white p-8 text-navy shadow-[0_24px_60px_rgba(4,12,28,0.28)] sm:p-10">
            <livewire:lead-form :type="$type ?? 'demo'" :show-phone="$show_phone ?? true" :show-company="$show_company ?? true" :show-message="$show_message ?? true" :button-label="$button_label ?? 'Submit'" />
        </div>
    </div>
</section>
@else
<section class="section-pad bg-white">
    <div class="container-site max-w-2xl">
        @if(!empty($headline))
            <h2 class="display-h2 mb-3">{!! $headline_html !!}</h2>
        @endif
        @if(!empty($intro))
            <p class="mb-8 text-muted">{{ $intro }}</p>
        @endif
        <div class="rounded-3xl border border-line bg-white p-8 shadow-[0_12px_40px_rgba(10,22,40,0.05)]">
            <livewire:lead-form :type="$type ?? 'demo'" :show-phone="$show_phone ?? true" :show-company="$show_company ?? true" :show-message="$show_message ?? true" :button-label="$button_label ?? 'Submit'" />
        </div>
    </div>
</section>
@endif
