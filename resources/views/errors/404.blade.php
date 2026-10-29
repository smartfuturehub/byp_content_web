@extends('layouts.public')

@php
    $metaTitle = 'Page not found | '.setting('site_name', 'BYP Health');
    $metaDescription = 'The page you are looking for may have moved or no longer exists.';
    $robots = 'noindex,follow';
    // A missing URL should not canonicalise itself, and nothing here belongs in an index.
    $canonical = false;
@endphp

@section('content')
<section class="section-pad">
    <div class="container-site max-w-xl text-center">
        <p class="eyebrow">404</p>
        <h1 class="mt-3 text-4xl font-semibold tracking-tight text-navy">Page not found</h1>
        <p class="mt-4 text-muted">The page you are looking for may have moved. Return home to continue.</p>
        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ url('/') }}" class="btn-primary">Go home</a>
        </div>
    </div>
</section>
@endsection
