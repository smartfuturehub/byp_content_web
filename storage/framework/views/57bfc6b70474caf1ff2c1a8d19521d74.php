<?php
    $href = $item['url'] ?? null;
    $tag = filled($href) ? 'a' : 'div';
?>
<<?php echo e($tag); ?>

    <?php if(filled($href)): ?> href="<?php echo e($href); ?>" rel="noopener" target="_blank" <?php endif; ?>
    class="logo-cell"
>
    <img
        src="<?php echo e(media_url($item['image'] ?? '')); ?>"
        alt="<?php echo e($item['name'] ?? ''); ?>"
        class="logo-mark"
        loading="lazy"
        decoding="async"
    >
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['name'])): ?>
        <span class="sr-only"><?php echo e($item['name']); ?></span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</<?php echo e($tag); ?>>
<?php /**PATH /var/www/html/sf/byp/resources/views/partials/logo-cell.blade.php ENDPATH**/ ?>