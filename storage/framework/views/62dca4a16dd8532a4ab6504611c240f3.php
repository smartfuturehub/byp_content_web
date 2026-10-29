<?php
    $pillTones = [
        'bg-[#F0F9FF] text-[#026AA2]',
        'bg-[#ECFDF3] text-[#027A48]',
        'bg-[#F9F5FF] text-[#6941C6]',
        'bg-[#FEF3F2] text-[#B42318]',
        'bg-[#FFFAEB] text-[#B54708]',
    ];
?>


<?php $__env->startSection('content'); ?>
<section class="bg-white py-16 sm:py-20">
    <div class="container-site flex flex-wrap items-end justify-between gap-8">
        <div class="max-w-[680px]">
            <span class="mb-6 inline-flex rounded-2xl bg-[#FEF3D9] px-3.5 py-1.5 text-sm font-medium text-[#7A4B00]">Blog</span>
            <h1 class="text-[2.5rem] font-bold leading-[1.02] tracking-[-0.04em] text-[#101828] sm:text-5xl lg:text-[4rem]">News and Insights</h1>
            <p class="mt-5 max-w-2xl text-xl leading-[1.6] text-[#475467]">Articles, research and updates on remote patient monitoring and connected care.</p>
        </div>
        <div class="w-full max-w-md">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('lead-form', ['type' => 'newsletter','email-only' => true,'button-label' => 'Subscribe','placeholder' => 'Work email']);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1361031789-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
        </div>
    </div>
</section>

<section class="pb-8">
    <div class="container-site flex flex-wrap gap-2.5">
        <a href="<?php echo e(route('blog.index')); ?>" class="rounded-2xl px-4 py-2 text-sm font-medium <?php echo e($currentCategory ? 'border border-[#E5E7EB] bg-white text-[#344054]' : 'bg-[#0B59AC] text-white'); ?>">All</a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <a href="<?php echo e(route('blog.index', ['category' => $category->slug])); ?>" class="rounded-2xl px-4 py-2 text-sm font-medium <?php echo e($currentCategory === $category->slug ? 'bg-[#0B59AC] text-white' : 'border border-[#E5E7EB] bg-white text-[#344054] hover:border-[#0B59AC] hover:text-[#0B59AC]'); ?>"><?php echo e($category->name); ?></a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
</section>

<section class="pb-24">
    <div class="container-site">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($posts->isEmpty()): ?>
            <div class="rounded-2xl border border-[#E5E7EB] px-6 py-16 text-center">
                <p class="text-lg font-semibold text-[#101828]">No articles yet</p>
                <p class="mt-2 text-[#475467]">New stories will appear here. Subscribe above to get them when they publish.</p>
            </div>
        <?php else: ?>
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <a href="<?php echo e($post->url()); ?>" class="group flex flex-col gap-4 text-[#101828] no-underline">
                        <div class="aspect-[16/10] overflow-hidden rounded-[10px] bg-[#F4F7FB]">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->featured_image): ?>
                                <img src="<?php echo e(media_url($post->featured_image)); ?>" alt="<?php echo e($post->title); ?>" class="h-full w-full object-cover" loading="lazy">
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="flex flex-wrap items-center gap-2.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->category): ?>
                                <span class="inline-flex rounded-2xl px-3 py-1 text-[13px] font-medium <?php echo e($pillTones[$loop->index % count($pillTones)]); ?>"><?php echo e($post->category->name); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->published_at): ?>
                                <span class="text-[13px] font-medium text-[#6941C6]"><?php echo e($post->published_at->format('j M Y')); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="flex items-start justify-between gap-3">
                            <h2 class="text-[22px] font-bold leading-snug"><?php echo e($post->title); ?></h2>
                            <svg class="mt-1 h-5 w-5 shrink-0 text-[#1A1A1A] transition group-hover:text-[#0B59AC]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M7 17L17 7M7 7h10v10"></path></svg>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->excerpt): ?>
                            <p class="text-[15px] leading-[1.6] text-[#475467]"><?php echo e($post->excerpt); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
            <div class="mt-10"><?php echo e($posts->links()); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/sf/byp/resources/views/blog/index.blade.php ENDPATH**/ ?>