<section class="section-pad py-13 sm:py-20">
    <div class="container-site <?php echo e(($align ?? 'left') === 'center' ? 'mx-auto text-center' : ''); ?>">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($headline)): ?>
            <h1 class="mb-6 display-h2"><?php echo $headline_html; ?></h1>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="prose-cms">
            <?php echo $body ?? ''; ?>

        </div>
    </div>
</section>
<?php /**PATH /var/www/html/sf/byp/resources/views/blocks/rich_text.blade.php ENDPATH**/ ?>