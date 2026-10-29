<?php
    $livewire ??= null;
    $base = rtrim(request()->getBaseUrl(), '/');
    $home = $base === '' ? '/' : $base.'/';
    $logo = media_url(setting('logo', '/brand/images/logo.png'), '/brand/images/logo.png');
    $scene = $base.'/uploads/2024/07/man-using-telemedicine-service-2024-04-08-15-09-10-utc-2048x1365.jpg';
?>

<?php if (isset($component)) { $__componentOriginale960ae7ad1b1ce9e3596e483505fadc9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale960ae7ad1b1ce9e3596e483505fadc9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.layout.base','data' => ['livewire' => $livewire]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::layout.base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['livewire' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($livewire)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <style>
        .sf-login-body {
            margin: 0;
            background: #eef3f8;
        }

        .sf-login {
            min-height: 100dvh;
            display: grid;
            background: #eef3f8;
        }

        @media (min-width: 960px) {
            .sf-login {
                grid-template-columns: minmax(22rem, 46%) minmax(0, 1fr);
            }
        }

        .sf-login-mobile {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.25rem;
            background: #0a1628;
        }

        @media (min-width: 960px) {
            .sf-login-mobile {
                display: none;
            }
        }

        .sf-login-brand {
            display: none;
            position: relative;
            overflow: hidden;
            color: #fff;
            background: #0a1628;
        }

        @media (min-width: 960px) {
            .sf-login-brand {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 2.5rem;
            }
        }

        .sf-login-brand img.sf-login-scene {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 68% center;
        }

        .sf-login-brand-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(105deg, rgba(7, 16, 24, 0.94) 0%, rgba(7, 16, 24, 0.78) 46%, rgba(11, 89, 172, 0.28) 100%),
                linear-gradient(180deg, rgba(7, 16, 24, 0.15) 0%, rgba(7, 16, 24, 0.62) 100%);
        }

        .sf-login-brand-inner {
            position: relative;
            z-index: 1;
            display: flex;
            height: 100%;
            flex-direction: column;
            justify-content: space-between;
        }

        .sf-login-logo {
            display: inline-flex;
            align-items: center;
            align-self: flex-start;
            background: #fff;
            border-radius: 0.9rem;
            padding: 0.55rem 0.85rem;
            box-shadow: 0 10px 30px rgba(7, 16, 24, 0.18);
        }

        .sf-login-logo img {
            display: block;
            height: 2.1rem;
            width: auto;
        }

        .sf-login-copy h1 {
            margin: 0;
            max-width: 11ch;
            font-size: clamp(2rem, 3vw, 2.65rem);
            font-weight: 600;
            line-height: 1.12;
            letter-spacing: -0.035em;
        }

        .sf-login-copy p {
            margin: 1rem 0 0;
            max-width: 28rem;
            font-size: 1.02rem;
            line-height: 1.65;
            color: rgba(255, 255, 255, 0.78);
        }

        .sf-login-kicker {
            margin: 0 0 0.85rem;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #f79f12;
        }

        .sf-login-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        .sf-login-meta span {
            display: inline-flex;
            align-items: center;
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 999px;
            padding: 0.35rem 0.7rem;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            color: rgba(255, 255, 255, 0.88);
            background: rgba(255, 255, 255, 0.08);
        }

        .sf-login-panel {
            display: flex;
            min-height: calc(100dvh - 4.5rem);
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1.25rem 2rem;
        }

        @media (min-width: 960px) {
            .sf-login-panel {
                min-height: 100dvh;
                padding: 2.5rem;
            }
        }

        .sf-login-form {
            width: 100%;
            max-width: 26.5rem;
        }

        .sf-login-form .fi-simple-page,
        .sf-login-form .fi-simple-page-content {
            width: 100%;
        }

        .sf-login-form .fi-simple-page-content {
            position: relative;
            overflow: hidden;
            background: #fff;
            border: 1px solid #dbe4ee;
            border-radius: 1.6rem;
            box-shadow: 0 28px 70px rgba(10, 22, 40, 0.1);
            padding: 2.15rem 1.85rem 1.85rem;
        }

        .sf-login-form .fi-simple-page-content::before {
            content: "";
            position: absolute;
            inset: 0 0 auto;
            height: 4px;
            background: linear-gradient(90deg, #0b59ac 0%, #1a7ad9 52%, #f79f12 100%);
        }

        .sf-login-form .fi-simple-header {
            align-items: flex-start;
        }

        .sf-login-form .fi-logo {
            height: 2.25rem;
            width: auto;
            margin-bottom: 1.15rem;
        }

        .sf-login-form .fi-simple-header-heading,
        .sf-login-form .fi-simple-header-subheading {
            text-align: left;
        }

        .sf-login-form .fi-simple-header-heading {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.03em;
            color: #0a1628;
        }

        .sf-login-form .fi-simple-header-subheading {
            margin-top: 0.45rem;
            max-width: 22rem;
            color: #5c6b7a;
        }

        .sf-login-form .fi-input-wrp {
            border-radius: 0.85rem;
            box-shadow: none;
            background: #f7fafc;
        }

        .sf-login-form input.fi-input {
            text-overflow: ellipsis;
        }

        .sf-login a,
        .sf-login button,
        .sf-login-form .fi-btn {
            cursor: pointer;
        }

        .sf-login-form .fi-btn {
            border-radius: 999px;
            padding-block: 0.75rem;
            font-weight: 600;
            background-color: #0b59ac !important;
            color: #fff !important;
        }

        .sf-login-form .fi-btn:hover {
            background-color: #084785 !important;
        }

        .sf-login-back {
            margin-top: 1.35rem;
            text-align: center;
            font-size: 0.8125rem;
        }

        .sf-login-back a {
            color: #0b59ac;
            text-decoration: none;
            font-weight: 600;
        }

        .sf-login-back a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="sf-login">
        <header class="sf-login-mobile">
            <a href="<?php echo e($home); ?>" class="sf-login-logo">
                <img src="<?php echo e($logo); ?>" alt="BYP Health">
            </a>
        </header>

        <aside class="sf-login-brand">
            <img class="sf-login-scene" src="<?php echo e($scene); ?>" alt="">
            <div class="sf-login-brand-overlay"></div>
            <div class="sf-login-brand-inner">
                <a href="<?php echo e($home); ?>" class="sf-login-logo">
                    <img src="<?php echo e($logo); ?>" alt="BYP Health">
                </a>
                <div class="sf-login-copy">
                    <p class="sf-login-kicker">Content studio</p>
                    <h1>Powering connected healthcare</h1>
                    <p>Sign in to update programmes, partner logos, articles, and the images visitors see on the public site.</p>
                    <div class="sf-login-meta">
                        <span>Pages</span>
                        <span>Blog</span>
                        <span>SEO</span>
                    </div>
                </div>
            </div>
        </aside>

        <div class="sf-login-panel">
            <div class="sf-login-form">
                <?php echo e($slot); ?>

                <p class="sf-login-back"><a href="<?php echo e($home); ?>">Back to the website</a></p>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale960ae7ad1b1ce9e3596e483505fadc9)): ?>
<?php $attributes = $__attributesOriginale960ae7ad1b1ce9e3596e483505fadc9; ?>
<?php unset($__attributesOriginale960ae7ad1b1ce9e3596e483505fadc9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale960ae7ad1b1ce9e3596e483505fadc9)): ?>
<?php $component = $__componentOriginale960ae7ad1b1ce9e3596e483505fadc9; ?>
<?php unset($__componentOriginale960ae7ad1b1ce9e3596e483505fadc9); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/sf/byp/resources/views/filament/layouts/login.blade.php ENDPATH**/ ?>