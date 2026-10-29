<?php
    $tone = $tone ?? 'white';
    $sectionClass = match ($tone) {
        'surface' => 'section-pad bg-white',
        'soft' => 'section-pad bg-brand-soft',
        default => 'section-pad bg-white',
    };
?>

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
<?php /**PATH /var/www/html/sf/byp/resources/views/blocks/split.blade.php ENDPATH**/ ?>