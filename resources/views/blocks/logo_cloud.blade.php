<section class="border-t border-[#F2F4F7] bg-white py-16 sm:py-[88px]">
    <div class="container-site">
        @if(!empty($headline))
            <h2 class="mb-6 text-[1.75rem] font-semibold tracking-[-0.03em] text-[#101828]">{!! $headline_html !!}</h2>
        @endif
        <div class="logo-grid">
            @foreach($items ?? [] as $item)
                @include('partials.logo-cell', ['item' => $item])
            @endforeach
        </div>
    </div>
</section>
