<?php
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
?>
<meta name="robots" content="<?php echo e($seoRobots); ?>">
<title><?php echo e($seoTitle); ?></title>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($seoDescription)): ?>
    <meta name="description" content="<?php echo e($seoDescription); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<meta name="author" content="<?php echo e($seoSiteName); ?>">
<meta name="application-name" content="<?php echo e($seoSiteName); ?>">
<meta name="theme-color" content="#0B59AC">
<meta name="msapplication-TileColor" content="#0B59AC">
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasCanonical): ?>
    <link rel="canonical" href="<?php echo e($seoCanonical); ?>">
    <link rel="alternate" hreflang="en" href="<?php echo e($seoCanonical); ?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo e($seoCanonical); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<link rel="icon" href="<?php echo e(media_url(setting('favicon', '/favicon.png'), '/favicon.png')); ?>">
<link rel="apple-touch-icon" href="<?php echo e(media_url(setting('favicon', '/favicon.png'), '/favicon.png')); ?>">
<meta property="og:locale" content="<?php echo e($seoLocale); ?>">
<meta property="og:site_name" content="<?php echo e($seoSiteName); ?>">
<meta property="og:type" content="<?php echo e($seoOgType); ?>">
<meta property="og:title" content="<?php echo e($seoTitle); ?>">
<meta property="og:description" content="<?php echo e($seoDescription); ?>">
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasCanonical): ?>
    <meta property="og:url" content="<?php echo e($seoCanonical); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<meta property="og:image" content="<?php echo e($seoOgImage); ?>">
<meta property="og:image:alt" content="<?php echo e($seoOgImageAlt); ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo e($seoTitle); ?>">
<meta name="twitter:description" content="<?php echo e($seoDescription); ?>">
<meta name="twitter:image" content="<?php echo e($seoOgImage); ?>">
<meta name="twitter:image:alt" content="<?php echo e($seoOgImageAlt); ?>">
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($seoTwitter)): ?>
    <meta name="twitter:site" content="<?php echo e($seoTwitter); ?>">
    <meta name="twitter:creator" content="<?php echo e($seoTwitter); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($seoOgType === 'article') && !empty($publishedAt)): ?>
    <meta property="article:published_time" content="<?php echo e($publishedAt); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($seoOgType === 'article') && !empty($modifiedAt)): ?>
    <meta property="article:modified_time" content="<?php echo e($modifiedAt); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($seoOgType === 'article') && !empty($articleAuthor)): ?>
    <meta property="article:author" content="<?php echo e($articleAuthor); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /var/www/html/sf/byp/resources/views/partials/seo.blade.php ENDPATH**/ ?>