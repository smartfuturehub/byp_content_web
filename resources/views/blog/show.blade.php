@extends('layouts.public')

@section('content')
<article class="bg-white">
    <div class="container-site py-16 sm:py-20">
        <p class="text-sm text-[#667085]">{{ $post->displayAuthor() }} • {{ optional($post->published_at)->format('j M Y') }}</p>
        <h1 class="mt-3 text-[2.5rem] font-bold leading-[1.15] tracking-[-0.03em] text-[#101828] sm:text-5xl">{{ $post->title }}</h1>
        @if($post->excerpt)
            <p class="mt-4 text-lg leading-8 text-[#475467]">{{ $post->excerpt }}</p>
        @endif
        @if($post->featured_image)
            <img src="{{ media_url($post->featured_image) }}" alt="" class="mt-10 aspect-[16/10] w-full rounded-[20px] object-cover" loading="lazy">
        @endif
        <div class="prose-cms mt-10">
            {!! $post->renderedBody() !!}
        </div>
    </div>
    @if($related->isNotEmpty())
        <div class="container-site pb-20">
            <h2 class="mb-6 text-3xl font-semibold text-[#101828]">Related articles</h2>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach($related as $item)
                    <a href="{{ $item->url() }}" class="rounded-2xl border border-[#E5E7EB] bg-white p-6 text-[#101828] no-underline">
                        <h3 class="text-lg font-bold">{{ $item->title }}</h3>
                        <p class="mt-2 line-clamp-3 text-sm leading-6 text-[#475467]">{{ $item->excerpt }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</article>
@endsection
