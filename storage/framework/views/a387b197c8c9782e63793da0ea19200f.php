<section class="section-pad bg-navy">
    <div class="container-site">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($headline)): ?>
            <h2 class="mb-8 text-center text-3xl font-semibold text-white sm:text-4xl"><?php echo $headline_html; ?></h2>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="overflow-hidden rounded-[2rem] bg-black/30 shadow-2xl">
            <video class="aspect-video w-full" <?php if(!empty($poster)): ?> poster="<?php echo e(media_url($poster)); ?>" <?php endif; ?> controls <?php if(!empty($autoplay)): ?> autoplay muted loop playsinline <?php endif; ?>>
                <source src="<?php echo e(media_url($src)); ?>" type="video/mp4">
            </video>
        </div>
    </div>
</section>
<?php /**PATH /var/www/html/sf/byp/resources/views/blocks/video.blade.php ENDPATH**/ ?>