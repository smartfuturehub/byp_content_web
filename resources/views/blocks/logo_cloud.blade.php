<section class="border-t border-[#F2F4F7] bg-white py-12 sm:py-16">
    <div class="container-site">
        @if(!empty($headline))
            <h2 class="mb-3 text-base font-semibold tracking-[-0.02em] text-[#101828]">{!! $headline_html !!}</h2>
        @endif
        <div class="logo-grid">
            @foreach($items ?? [] as $item)
                @include('partials.logo-cell', ['item' => $item])
            @endforeach
        </div>
    </div>
</section>
