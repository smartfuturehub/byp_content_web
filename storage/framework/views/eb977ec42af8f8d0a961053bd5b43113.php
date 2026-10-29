<section id="contact" class="section-pad bg-[#F8FAFC]">
    <div class="container-site">
        <div class="mb-10 text-center">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($intro)): ?>
                <p class="mb-3 whitespace-pre-line text-lg leading-7 text-[#475467]"><?php echo e($intro); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <h2 class="display-h2"><?php echo $headline_html; ?></h2>
        </div>

        <div class="grid items-start gap-12 lg:grid-cols-[220px_minmax(0,1fr)]">
            <div>
                <a href="<?php echo e(url('/')); ?>" class="inline-block">
                    <img src="<?php echo e(media_url(setting('logo', '/brand/wp/logo.png'))); ?>" alt="<?php echo e(setting('site_name', 'BYP Health')); ?>" class="h-16 w-auto">
                </a>
                <ul class="mt-6 space-y-2 text-sm">
                    <li><a href="<?php echo e(url('/tnc')); ?>" class="text-[#0B59AC] hover:underline">Terms and Conditions</a></li>
                    <li><a href="<?php echo e(url('/privacy-policy')); ?>" class="text-[#0B59AC] hover:underline">Privacy Policy</a></li>
                </ul>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($show_form)): ?>
                <div class="rounded-2xl border border-line bg-white p-8 shadow-[0_8px_24px_rgba(10,22,40,0.04)]">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('lead-form', ['type' => 'contact','show-phone' => true,'show-company' => false,'show-country' => false,'show-last-name' => true,'button-label' => 'Submit']);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2347584428-0', $__key);

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
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>
<?php /**PATH /var/www/html/sf/byp/resources/views/blocks/contact.blade.php ENDPATH**/ ?>