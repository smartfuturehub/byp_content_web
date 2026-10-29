<section class="border-t border-[#F2F4F7] bg-white py-16 sm:py-[88px]">
    <div class="container-site">
        @include('solutions._heading', [
            'headline' => $headline ?? null,
            'headline_html' => $headline_html ?? null,
        ])
        <div class="{{ filled($headline ?? null) ? 'mt-10' : '' }} overflow-hidden rounded-[20px] bg-[#101828]">
            <video class="aspect-video w-full" @if(!empty($poster)) poster="{{ media_url($poster) }}" @endif controls @if(!empty($autoplay)) autoplay muted loop playsinline @endif>
                <source src="{{ media_url($src) }}" type="video/mp4">
            </video>
        </div>
    </div>
</section>
