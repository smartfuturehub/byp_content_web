<?php
    $tone = $tone ?? 'white';
    $layout = $layout ?? 'split';
    $isBillingCollage = str_contains((string) ($image ?? ''), 'billing-image')
        || ($headline ?? '') === 'EHR / EMR Integration';

    if ($layout !== 'integrations' && $isBillingCollage) {
        $layout = 'integrations';
    }

    $systems = collect($systems ?? [])
        ->map(fn ($item) => is_array($item) ? ($item['label'] ?? $item['name'] ?? '') : $item)
        ->filter(fn ($label) => filled($label))
        ->values();

    if ($systems->isEmpty() && $layout === 'integrations') {
        $systems = collect(['Epic', 'Cerner', 'MEDITECH', 'athenahealth', 'eClinicalWorks', 'Allscripts', 'NextGen']);
    }
    $sectionClass = match ($tone) {
        'surface' => 'section-pad bg-white',
        'soft' => 'section-pad bg-brand-soft',
        'navy' => 'section-pad bg-navy text-white',
        default => 'section-pad bg-white',
    };
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($layout === 'integrations'): ?>
    <section class="ehr-band relative overflow-hidden bg-[#07111F] py-16 sm:py-[88px]">
        <div class="pointer-events-none absolute inset-0 bg-[#07111F]"></div>
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top,_rgba(11,89,172,0.32),_transparent_58%)]"></div>
        <div class="pointer-events-none absolute -left-24 bottom-[-6rem] h-72 w-72 rounded-full bg-[#F79F12]/10 blur-3xl"></div>
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-[#F79F12]/45 to-transparent"></div>

        <div class="container-site relative">
            <div class="mx-auto max-w-3xl text-center">
                <div class="mx-auto mb-5 h-1 w-10 rounded-sm bg-[#f5a915]"></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($eyebrow)): ?>
                    <p class="mb-3 text-[12px] font-semibold uppercase tracking-[0.2em] text-[#8EC4F5]"><?php echo e($eyebrow); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <h2 class="text-[1.9rem] font-semibold leading-[1.18] tracking-[-0.025em] text-white sm:text-[2.35rem]"><?php echo $headline_html; ?></h2>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($body)): ?>
                    <div class="prose-cms mx-auto mt-5 max-w-[640px]"><?php echo $body; ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($systems->isNotEmpty()): ?>
                    <ul class="mt-8 flex flex-wrap justify-center gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $systems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $system): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <li class="rounded-full border border-white/15 bg-white/10 px-3.5 py-1.5 text-[13px] font-medium text-white/85"><?php echo e($system); ?></li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($button_label)): ?>
                    <a href="<?php echo e(cms_url($button_url ?? '#contact')); ?>" class="btn-accent mt-8"><?php echo e($button_label); ?></a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($image)): ?>
                <div class="mt-12 lg:mt-16">
                    <img
                        src="<?php echo e(media_url($image)); ?>"
                        alt="<?php echo e($image_alt ?? $headline ?? ''); ?>"
                        class="mx-auto w-full max-w-[1080px] object-contain"
                        loading="eager"
                        decoding="async"
                    >
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>
<?php else: ?>
    <section class="<?php echo e($sectionClass); ?>">
        <div class="container-site grid items-center gap-12 lg:grid-cols-2 lg:gap-20">
            <div class="<?php echo e(!empty($image_right) ? '' : 'lg:order-2'); ?>">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($eyebrow)): ?>
                    <p class="eyebrow mb-4"><?php echo e($eyebrow); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <h2 class="display-h2"><?php echo $headline_html; ?></h2>
                <div class="prose-cms mt-5"><?php echo $body ?? ''; ?></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($button_label)): ?>
                    <a href="<?php echo e(cms_url($button_url ?? '#')); ?>" class="btn-primary mt-8"><?php echo e($button_label); ?></a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($image)): ?>
                <div class="<?php echo e(!empty($image_right) ? '' : 'lg:order-1'); ?>">
                    <div class="overflow-hidden rounded-[1.5rem] shadow-[0_24px_60px_rgba(10,22,40,0.12)]">
                        <img
                            src="<?php echo e(media_url($image)); ?>"
                            alt="<?php echo e($image_alt ?? $headline ?? ''); ?>"
                            class="aspect-[4/3] w-full <?php echo e(($fit ?? 'cover') === 'contain' ? 'object-contain bg-white p-8' : 'object-cover'); ?>"
                            loading="lazy"
                        >
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /var/www/html/sf/byp/resources/views/blocks/split.blade.php ENDPATH**/ ?>