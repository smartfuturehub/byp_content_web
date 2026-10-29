<?php
    $legalItems = collect($legalMenu ?? [])->filter(fn ($item) => filled($item['label'] ?? null) && filled($item['url'] ?? null))->values();
    if ($legalItems->isEmpty()) {
        $legalItems = collect([
            ['label' => 'Terms and Conditions', 'url' => '/tnc'],
            ['label' => 'Privacy Policy', 'url' => '/privacy-policy'],
        ]);
    }

    $footerItems = collect($footerMenu ?? [])
        ->filter(fn ($item) => filled($item['label'] ?? null) && filled($item['url'] ?? null))
        ->reject(fn ($item) => strcasecmp((string) ($item['label'] ?? ''), 'Blog') === 0 || str_contains((string) ($item['url'] ?? ''), '/blog'))
        ->values();
    $footerCta = trim((string) setting('footer_cta', ''));
    $email = setting('email');
    $phoneAe = setting('phone_ae');
    $phoneSg = setting('phone_sg');
    $phoneUs = setting('phone_us');
?>

<footer id="footer" class="bg-[#0A1628] text-white">
    <div class="container-site grid gap-10 py-14 sm:grid-cols-2 lg:grid-cols-[minmax(0,1.3fr)_minmax(0,1fr)_minmax(0,1fr)] lg:gap-16">
        <div>
            <a href="<?php echo e(url('/')); ?>" class="inline-block">
                <img
                    src="<?php echo e(media_url(setting('logo', '/brand/wp/logo.png'))); ?>"
                    alt="<?php echo e(setting('site_name', 'BYP Health')); ?>"
                    class="footer-logo"
                >
            </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerCta !== ''): ?>
                <p class="mt-5 max-w-sm text-sm leading-6 text-white/70"><?php echo e($footerCta); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerItems->isNotEmpty()): ?>
            <div>
                <p class="text-sm font-semibold text-white">Solutions</p>
                <ul class="mt-4 space-y-2.5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $footerItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <li>
                            <a href="<?php echo e(cms_url($item['url'])); ?>" class="text-sm text-white/70 hover:text-white"><?php echo e($item['label']); ?></a>
                        </li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div>
            <p class="text-sm font-semibold text-white">Contact</p>
            <ul class="mt-4 space-y-2.5 text-sm text-white/70">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($email)): ?>
                    <li><a href="mailto:<?php echo e($email); ?>" class="hover:text-white"><?php echo e($email); ?></a></li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($phoneAe)): ?>
                    <li><a href="tel:<?php echo e(preg_replace('/[^\d+]/', '', (string) $phoneAe)); ?>" class="hover:text-white"><?php echo e($phoneAe); ?></a></li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($phoneSg)): ?>
                    <li><a href="tel:<?php echo e(preg_replace('/[^\d+]/', '', (string) $phoneSg)); ?>" class="hover:text-white"><?php echo e($phoneSg); ?></a></li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($phoneUs)): ?>
                    <li><a href="tel:<?php echo e(preg_replace('/[^\d+]/', '', (string) $phoneUs)); ?>" class="hover:text-white"><?php echo e($phoneUs); ?></a></li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-site flex flex-col gap-3 py-5 text-sm text-white/55 sm:flex-row sm:items-center sm:justify-between">
            <p>© Copyright <?php echo e(date('Y')); ?>. All Rights Reserved</p>
            <ul class="flex flex-wrap gap-x-5 gap-y-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $legalItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li>
                        <a href="<?php echo e(cms_url($item['url'])); ?>" class="hover:text-white"><?php echo e($item['label']); ?></a>
                    </li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </ul>
        </div>
    </div>
</footer>
<?php /**PATH /var/www/html/sf/byp/resources/views/partials/site-footer.blade.php ENDPATH**/ ?>