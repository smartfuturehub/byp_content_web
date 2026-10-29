<section class="section-pad py-13 sm:py-20">
    <div class="container-site {{ ($align ?? 'left') === 'center' ? 'mx-auto text-center' : '' }}">
        @if(!empty($headline))
            <h1 class="mb-6 display-h2">{!! $headline_html !!}</h1>
        @endif
        <div class="prose-cms">
            {!! $body ?? '' !!}
        </div>
    </div>
</section>
