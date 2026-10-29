<section class="section-pad bg-navy">
    <div class="container-site">
        @if(!empty($headline))
            <h2 class="mb-8 text-center text-3xl font-semibold text-white sm:text-4xl">{!! $headline_html !!}</h2>
        @endif
        <div class="overflow-hidden rounded-[2rem] bg-black/30 shadow-2xl">
            <video class="aspect-video w-full" @if(!empty($poster)) poster="{{ media_url($poster) }}" @endif controls @if(!empty($autoplay)) autoplay muted loop playsinline @endif>
                <source src="{{ media_url($src) }}" type="video/mp4">
            </video>
        </div>
    </div>
</section>
