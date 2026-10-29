<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.seo')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    @livewireStyles
    @if(!empty($jsonLd))
        <script type="application/ld+json">{!! $jsonLd !!}</script>
    @endif
    @include('partials.analytics')
</head>
@php
    $onSolutions = request()->is('solutions', 'hospital-at-home', 'emergency-care', 'emergency-kit', 'chronic-care', 'cellular-platform', 'facility-care', 'solution-in-clinic', 'wellness-kit', 'wellness-kit/*');
    $onBlog = request()->is('blog', 'blog/*', 'newsletter', 'newsletter/*');
@endphp
<body class="min-h-screen bg-white text-ink {{ !empty($isHome) ? 'page-home' : '' }}" x-data="{ mobile: false }">

    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-full focus:bg-brand focus:px-4 focus:py-2 focus:text-white">Skip to content</a>

    <header id="site-header" class="sticky top-0 z-40 bg-white shadow-[0_2px_12px_rgba(10,22,40,0.06)]">
        <div class="container-site flex min-h-[73px] items-center justify-between gap-6">
            <a href="{{ url('/') }}" class="flex shrink-0 items-center py-3">
                <img src="{{ media_url(setting('logo', '/brand/wp/logo.png')) }}" alt="{{ setting('site_name', 'BYP Health') }}" class="h-[48px] w-auto">
            </a>

            <nav class="hidden items-center gap-8 lg:flex" aria-label="Primary">
                <a href="{{ url('/') }}" class="text-[15px] font-medium {{ request()->is('/') ? 'text-[#0B59AC]' : 'text-[#444444] hover:text-[#0B59AC]' }}">Home</a>
                @foreach($headerMenu as $item)
                    @if(!empty($item['children']))
                        <div class="group relative">
                            <a
                                href="{{ cms_url($item['url'] ?? '#') }}"
                                class="inline-flex items-center gap-1 text-[15px] font-medium {{ $onSolutions ? 'text-[#0B59AC]' : 'text-[#444444] hover:text-[#0B59AC]' }}"
                            >
                                {{ $item['label'] }}
                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M6 9l6 6 6-6"></path></svg>
                            </a>
                            <div class="invisible absolute left-0 top-full z-30 min-w-[280px] pt-3 opacity-0 transition group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100">
                                <ul class="rounded-md border border-[#E5E7EB] bg-white py-2 shadow-[0_12px_30px_rgba(10,22,40,0.12)]">
                                    @foreach($item['children'] as $child)
                                        <li>
                                            <a href="{{ cms_url($child['url']) }}" class="block px-4 py-2.5 text-sm text-[#444444] hover:bg-[#F4F7FB] hover:text-[#0B59AC]">{{ $child['label'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        <a href="{{ cms_url($item['url']) }}" class="text-[15px] font-medium {{ ($onBlog && (str_contains((string) $item['url'], 'newsletter') || str_contains((string) $item['url'], 'blog'))) ? 'text-[#0B59AC]' : 'text-[#444444] hover:text-[#0B59AC]' }}">{{ $item['label'] }}</a>
                    @endif
                @endforeach
                <a href="{{ cms_url(setting('header_cta_url', '/contact-us')) }}" class="text-[15px] font-medium text-[#444444] hover:text-[#0B59AC]">{{ setting('header_cta_label', 'Book a call') }}</a>
            </nav>

            <button type="button" class="inline-flex rounded-full p-2 text-[#101828] lg:hidden" @click="mobile = true" aria-label="Open menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </header>

    <div x-show="mobile" x-cloak class="fixed inset-0 z-50 lg:hidden" @keydown.escape.window="mobile = false">
        <div class="absolute inset-0 cursor-pointer bg-[#101828]/50" @click="mobile = false"></div>
        <div class="absolute right-0 top-0 h-full w-[88%] max-w-sm overflow-y-auto bg-white p-6 shadow-2xl" x-show="mobile" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0">
            <div class="mb-8 flex items-center justify-between">
                <img src="{{ media_url(setting('logo', '/brand/wp/logo.png')) }}" alt="" class="h-8">
                <button type="button" @click="mobile = false" class="rounded-full p-2 hover:bg-[#F4F7FB]" aria-label="Close menu">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/></svg>
                </button>
            </div>
            <nav class="space-y-1" aria-label="Mobile">
                <a href="{{ url('/') }}" class="block rounded-xl px-3 py-3 font-semibold text-[#101828] hover:bg-[#F4F7FB]">Home</a>
                @foreach($headerMenu as $item)
                    <div class="border-b border-[#E5E7EB] pb-3 last:border-0">
                        <a href="{{ cms_url($item['url'] ?? '#') }}" class="block rounded-xl px-3 py-3 font-semibold text-[#101828] hover:bg-[#F4F7FB]">{{ $item['label'] }}</a>
                        @foreach($item['children'] ?? [] as $child)
                            <a href="{{ cms_url($child['url']) }}" class="block rounded-xl px-6 py-2.5 text-sm text-[#444444] hover:bg-[#F4F7FB] hover:text-[#0B59AC]">{{ $child['label'] }}</a>
                        @endforeach
                    </div>
                @endforeach
            </nav>
            <a href="{{ cms_url(setting('header_cta_url', '/contact-us')) }}" class="mt-8 block rounded-xl px-3 py-3 text-[15px] font-semibold text-[#101828] hover:bg-[#F4F7FB]">{{ setting('header_cta_label', 'Book a call') }}</a>
        </div>
    </div>

    <main id="main">
        @if(session('status'))
            <div class="container-site pt-6">
                <div class="rounded-2xl bg-brand-soft px-4 py-3 text-sm text-brand-dark">{{ session('status') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.site-footer')
    @include('partials.cookie-banner')
    @livewireScripts
    <style>[x-cloak]{display:none !important;}</style>
</body>
</html>
