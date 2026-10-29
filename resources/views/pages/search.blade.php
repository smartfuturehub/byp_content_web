@extends('layouts.public')

@section('content')
<section class="section-pad">
    <div class="container-site">
        <h1 class="text-4xl font-semibold tracking-tight text-navy">Search</h1>
        <form action="{{ route('search') }}" method="get" class="mt-6 max-w-xl">
            <input type="search" name="q" value="{{ $q }}" placeholder="Search the site" class="input-field rounded-full px-5">
        </form>

        @if(strlen($q) < 2)
            <p class="mt-8 text-muted">Type at least two characters to search pages and articles.</p>
        @else
            <div class="mt-10 grid gap-10 lg:grid-cols-2">
                <div>
                    <h2 class="mb-4 font-semibold text-navy">Pages</h2>
                    @forelse($pages as $page)
                        <a href="{{ $page->url() }}" class="mb-3 block rounded-2xl border border-line p-4 hover:border-brand">{{ $page->title }}</a>
                    @empty
                        <p class="text-sm text-muted">No pages found.</p>
                    @endforelse
                </div>
                <div>
                    <h2 class="mb-4 font-semibold text-navy">Newsletter</h2>
                    @forelse($posts as $post)
                        <a href="{{ $post->url() }}" class="mb-3 block rounded-2xl border border-line p-4 hover:border-brand">{{ $post->title }}</a>
                    @empty
                        <p class="text-sm text-muted">No articles found.</p>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
