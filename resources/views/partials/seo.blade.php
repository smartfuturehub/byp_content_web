@php
    $seoTitle = $metaTitle ?? setting('default_meta_title', setting('site_name', 'BYP Health'));
    $seoDescription = $metaDescription ?? setting('default_meta_description', '');
    // A view may pass $canonical = false to emit no canonical at all (error pages).
    $seoCanonical = $canonical ?? url()->current();
    $hasCanonical = $seoCanonical !== false && filled($seoCanonical);
    $seoRobots = \App\Support\Seo::robots($robots ?? 'index,follow');
    $seoOgType = $ogType ?? 'website';
    $seoOgImage = media_url($ogImage ?? '/brand/sf/home-hero.jpg', '/brand/sf/home-hero.jpg');
    $seoOgImageAlt = $ogImageAlt ?? $seoTitle;
    $seoSiteName = setting('site_name', 'BYP Health');
    $seoTwitter = \App\Support\Seo::twitterHandle();
    $seoLocale = str_replace('-', '_', app()->getLocale());
    if (! str_contains($seoLocale, '_')) {
        $seoLocale .= '_US';
    }
@endphp
<meta name="robots" content="{{ $seoRobots }}">
<title>{{ $seoTitle }}</title>
@if(filled($seoDescription))
    <meta name="description" content="{{ $seoDescription }}">
@endif
<meta name="author" content="{{ $seoSiteName }}">
<meta name="application-name" content="{{ $seoSiteName }}">
<meta name="theme-color" content="#0B59AC">
<meta name="msapplication-TileColor" content="#0B59AC">
@if($hasCanonical)
    <link rel="canonical" href="{{ $seoCanonical }}">
    <link rel="alternate" hreflang="en" href="{{ $seoCanonical }}">
    <link rel="alternate" hreflang="x-default" href="{{ $seoCanonical }}">
@endif
<link rel="icon" href="{{ media_url(setting('favicon', '/favicon.png'), '/favicon.png') }}">
<link rel="apple-touch-icon" href="{{ media_url(setting('favicon', '/favicon.png'), '/favicon.png') }}">
<meta property="og:locale" content="{{ $seoLocale }}">
<meta property="og:site_name" content="{{ $seoSiteName }}">
<meta property="og:type" content="{{ $seoOgType }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
@if($hasCanonical)
    <meta property="og:url" content="{{ $seoCanonical }}">
@endif
<meta property="og:image" content="{{ $seoOgImage }}">
<meta property="og:image:alt" content="{{ $seoOgImageAlt }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoOgImage }}">
<meta name="twitter:image:alt" content="{{ $seoOgImageAlt }}">
@if(filled($seoTwitter))
    <meta name="twitter:site" content="{{ $seoTwitter }}">
    <meta name="twitter:creator" content="{{ $seoTwitter }}">
@endif
@if(($seoOgType === 'article') && !empty($publishedAt))
    <meta property="article:published_time" content="{{ $publishedAt }}">
@endif
@if(($seoOgType === 'article') && !empty($modifiedAt))
    <meta property="article:modified_time" content="{{ $modifiedAt }}">
@endif
@if(($seoOgType === 'article') && !empty($articleAuthor))
    <meta property="article:author" content="{{ $articleAuthor }}">
@endif
