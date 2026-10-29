<?php
    $variant = $variant ?? 'photo';
    $columns = (string) ($columns ?? '3');
    $fit = $fit ?? 'cover';
    $tone = $tone ?? 'white';
    $grid = $columns === '4' ? 'lg:grid-cols-4' : ($columns === '2' ? 'lg:grid-cols-2' : 'lg:grid-cols-3');
    $sectionClass = match ($tone) {
        'surface' => 'section-pad bg-white',
        'soft' => 'section-pad bg-brand-soft',
        'navy' => 'section-pad bg-navy text-white',
        default => 'section-pad bg-white',
    };

    if ($variant === 'feature') {
        $sectionClass = match ($tone) {
            'navy' => 'border-t border-white/10 bg-navy py-16 text-white sm:py-[88px]',
            'soft' => 'border-t border-[#F2F4F7] bg-brand-soft py-16 sm:py-[88px]',
            default => 'border-t border-[#F2F4F7] bg-[#FAFAFA] py-16 sm:py-[88px]',
        };
    }
?>

<section <?php if(!empty($anchor)): ?> id="<?php echo e($anchor); ?>" <?php endif; ?> class="<?php echo e($sectionClass); ?>">
    <div class="container-site">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($headline) || !empty($intro)): ?>
            <div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tone !== 'navy'): ?>
                    <div class="mb-5 h-1 w-10 rounded-sm bg-[#f5a915]"></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($headline)): ?>
                    <h2 class="text-[2rem] font-semibold leading-[1.15] tracking-[-0.03em] sm:text-[2.75rem] <?php echo e($tone === 'navy' ? 'text-white' : 'text-[#101828]'); ?>"><?php echo $headline_html; ?></h2>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($intro)): ?>
                    <p class="mt-3 max-w-[760px] text-lg leading-[1.6] <?php echo e($tone === 'navy' ? 'text-white/70' : 'text-[#475467]'); ?>"><?php echo e($intro); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($variant === 'feature'): ?>
            <div class="feature-grid mt-12">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <article class="flex h-full flex-col gap-2.5 rounded-2xl border p-7 <?php echo e($tone === 'navy' ? 'border-white/10 bg-white/5' : 'border-[#E5E7EB] bg-white'); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['title'])): ?>
                            <h3 class="text-xl font-bold leading-snug <?php echo e($tone === 'navy' ? 'text-white' : 'text-[#101828]'); ?>"><?php echo e($item['title']); ?></h3>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['body'])): ?>
                            <p class="text-base leading-[1.55] <?php echo e($tone === 'navy' ? 'text-white/70' : 'text-[#475467]'); ?>"><?php echo e($item['body']); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </article>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php elseif($variant === 'tile'): ?>
            <div class="mt-9 grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 lg:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php $tag = !empty($item['url']) ? 'a' : 'article'; ?>
                    <<?php echo e($tag); ?> <?php if(!empty($item['url'])): ?> href="<?php echo e(cms_url($item['url'])); ?>" <?php endif; ?> class="overflow-hidden rounded-xl border border-[#E5E7EB] bg-white text-navy no-underline">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['image'])): ?>
                            <div class="aspect-[4/3] overflow-hidden bg-[#F4F7FB]">
                                <img src="<?php echo e(media_url($item['image'])); ?>" alt="<?php echo e($item['title'] ?? ''); ?>" class="h-full w-full object-cover" loading="lazy">
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="px-3.5 py-3.5 text-[15px] font-semibold leading-snug"><?php echo e($item['title'] ?? ''); ?></div>
                    </<?php echo e($tag); ?>>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php elseif($variant === 'bento'): ?>
            <div class="mt-12 grid gap-4 lg:grid-cols-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $tag = !empty($item['url']) ? 'a' : 'article';
                        $featured = $index === 0;
                    ?>
                    <<?php echo e($tag); ?> <?php if(!empty($item['url'])): ?> href="<?php echo e(cms_url($item['url'])); ?>" <?php endif; ?> class="group relative overflow-hidden rounded-[1.5rem] <?php echo e($featured ? 'min-h-[420px] lg:col-span-2 lg:row-span-2 lg:min-h-[560px]' : 'min-h-[260px]'); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['image'])): ?>
                            <img src="<?php echo e(media_url($item['image'])); ?>" alt="<?php echo e($item['title'] ?? ''); ?>" class="absolute inset-0 h-full w-full object-cover object-center transition duration-700 group-hover:scale-[1.04]" loading="lazy">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-navy via-navy/35 to-navy/5"></div>
                        <div class="relative flex h-full flex-col justify-end p-7 text-white sm:p-8">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['title'])): ?>
                                <h3 class="font-display font-semibold <?php echo e($featured ? 'text-3xl lg:text-4xl' : 'text-xl'); ?>"><?php echo e($item['title']); ?></h3>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['body'])): ?>
                                <p class="mt-2 max-w-lg text-sm leading-6 text-white/80 <?php echo e($featured ? 'sm:text-base sm:leading-7' : ''); ?>"><?php echo e($item['body']); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['url'])): ?>
                                <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-accent">Explore <span aria-hidden="true">→</span></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </<?php echo e($tag); ?>>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php else: ?>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 <?php echo e($grid); ?>">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $tag = !empty($item['url']) ? 'a' : 'article';
                        $itemFit = $item['fit'] ?? $fit;
                        $cardAspect = $columns === '4' ? 'aspect-[4/3]' : 'aspect-[16/10]';
                        $badgeClass = match ($item['badge_tone'] ?? 'blue') {
                            'red' => 'bg-[#FEF3F2] text-[#B42318]',
                            'green' => 'bg-[#ECFDF3] text-[#027A48]',
                            'purple' => 'bg-[#F9F5FF] text-[#6941C6]',
                            default => 'bg-[#F0F9FF] text-[#026AA2]',
                        };
                    ?>
                    <<?php echo e($tag); ?> <?php if(!empty($item['url'])): ?> href="<?php echo e(cms_url($item['url'])); ?>" <?php endif; ?> class="group flex flex-col overflow-hidden rounded-2xl border border-[#E5E7EB] bg-white transition hover:border-brand/30">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['image'])): ?>
                            <div class="<?php echo e($cardAspect); ?> overflow-hidden bg-white">
                                <img
                                    src="<?php echo e(media_url($item['image'])); ?>"
                                    alt="<?php echo e($item['title'] ?? ''); ?>"
                                    class="h-full w-full <?php echo e($itemFit === 'contain' ? 'object-contain p-5' : 'object-cover object-center transition duration-500 group-hover:scale-[1.03]'); ?>"
                                    loading="lazy"
                                >
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="flex flex-1 flex-col p-6">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['badge'])): ?>
                                <span class="mb-3 inline-flex self-start rounded-2xl px-3 py-1 text-[13px] font-medium <?php echo e($badgeClass); ?>"><?php echo e($item['badge']); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['title'])): ?>
                                <h3 class="text-xl font-bold text-navy group-hover:text-brand"><?php echo e($item['title']); ?></h3>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['body'])): ?>
                                <p class="mt-2 flex-1 text-sm leading-6 text-muted"><?php echo e($item['body']); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['url'])): ?>
                                <p class="mt-4 text-sm font-semibold text-brand">Read More</p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </<?php echo e($tag); ?>>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>
<?php /**PATH /var/www/html/sf/byp/resources/views/blocks/cards.blade.php ENDPATH**/ ?>