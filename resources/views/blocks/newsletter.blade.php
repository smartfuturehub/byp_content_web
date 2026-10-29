<section class="section-pad bg-brand-soft">
    <div class="container-site max-w-2xl text-center">
        <h2 class="display-h2">{!! $headline_html !!}</h2>
        @if(!empty($body))
            <p class="mt-3 text-muted">{{ $body }}</p>
        @endif
        <div class="mx-auto mt-8 max-w-lg">
            <livewire:lead-form type="newsletter" :email-only="true" :button-label="$button_label ?? 'Let\'s Talk'" />
        </div>
    </div>
</section>
