@php
    $pillTones = [
        'bg-[#F0F9FF] text-[#026AA2]',
        'bg-[#ECFDF3] text-[#027A48]',
        'bg-[#F9F5FF] text-[#6941C6]',
        'bg-[#FEF3F2] text-[#B42318]',
        'bg-[#FFFAEB] text-[#B54708]',
    ];
@endphp
@extends('layouts.public')

@section('content')
<section class="bg-white py-16 sm:py-20">
    <div class="container-site flex flex-wrap items-end justify-between gap-8">
        <div class="max-w-[680px]">
            <span class="mb-6 inline-flex rounded-2xl bg-[#FEF3D9] px-3.5 py-1.5 text-sm font-medium text-[#7A4B00]">Blog</span>
            <h1 class="text-[2.5rem] font-bold leading-[1.02] tracking-[-0.04em] text-[#101828] sm:text-5xl lg:text-[4rem]">News and Insights</h1>
            <p class="mt-5 max-w-2xl text-xl leading-[1.6] text-[#475467]">Articles, research and updates on remote patient monitoring and connected care.</p>
        </div>
        <div class="w-full max-w-md">
            <livewire:lead-form type="newsletter" :email-only="true" button-label="Subscribe" placeholder="Work email" />
        </div>
    </div>
</section>

<section class="pb-8">
    <div class="container-site flex flex-wrap gap-2.5">
        <a href="{{ route('blog.index') }}" class="rounded-2xl px-4 py-2 text-sm font-medium {{ $currentCategory ? 'border border-[#E5E7EB] bg-white text-[#344054]' : 'bg-[#0B59AC] text-white' }}">All</a>
        @foreach($categories as $index => $category)
            <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="rounded-2xl px-4 py-2 text-sm font-medium {{ $currentCategory === $category->slug ? 'bg-[#0B59AC] text-white' : 'border border-[#E5E7EB] bg-white text-[#344054] hover:border-[#0B59AC] hover:text-[#0B59AC]' }}">{{ $category->name }}</a>
        @endforeach
    </div>
</section>

<section class="pb-24">
    <div class="container-site">
        @if($posts->isEmpty())
            <div class="rounded-2xl border border-[#E5E7EB] px-6 py-16 text-center">
                <p class="text-lg font-semibold text-[#101828]">No articles yet</p>
                <p class="mt-2 text-[#475467]">New stories will appear here. Subscribe above to get them when they publish.</p>
            </div>
        @else
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($posts as $post)
                    <a href="{{ $post->url() }}" class="group flex flex-col gap-4 text-[#101828] no-underline">
                        <div class="aspect-[16/10] overflow-hidden rounded-[10px] bg-[#F4F7FB]">
                            @if($post->featured_image)
                                <img src="{{ media_url($post->featured_image) }}" alt="{{ $post->title }}" class="h-full w-full object-cover" loading="lazy">
                            @endif
                        </div>
                        <div class="flex flex-wrap items-center gap-2.5">
                            @if($post->category)
                                <span class="inline-flex rounded-2xl px-3 py-1 text-[13px] font-medium {{ $pillTones[$loop->index % count($pillTones)] }}">{{ $post->category->name }}</span>
                            @endif
                            @if($post->published_at)
                                <span class="text-[13px] font-medium text-[#6941C6]">{{ $post->published_at->format('j M Y') }}</span>
                            @endif
                        </div>
                        <div class="flex items-start justify-between gap-3">
                            <h2 class="text-[22px] font-bold leading-snug">{{ $post->title }}</h2>
                            <svg class="mt-1 h-5 w-5 shrink-0 text-[#1A1A1A] transition group-hover:text-[#0B59AC]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M7 17L17 7M7 7h10v10"></path></svg>
                        </div>
                        @if($post->excerpt)
                            <p class="text-[15px] leading-[1.6] text-[#475467]">{{ $post->excerpt }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
            <div class="mt-10">{{ $posts->links() }}</div>
        @endif
    </div>
</section>
@endsection
