<?php
    $style = $style ?? 'light';
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($style === 'navy'): ?>
<section class="relative overflow-hidden bg-navy py-20 text-white sm:py-28">
    <div class="absolute -right-24 top-10 h-72 w-72 rounded-full bg-brand/30 blur-3xl"></div>
    <div class="absolute -left-16 bottom-0 h-56 w-56 rounded-full bg-accent/20 blur-3xl"></div>
    <div class="container-site relative grid items-center gap-12 lg:grid-cols-2">
        <div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($headline)): ?>
                <h2 class="display-h2 text-white"><?php echo $headline_html; ?></h2>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($intro)): ?>
                <p class="mt-5 max-w-xl text-[17px] leading-8 text-white/75"><?php echo e($intro); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="rounded-3xl bg-white p-8 text-navy shadow-[0_24px_60px_rgba(4,12,28,0.28)] sm:p-10">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('lead-form', ['type' => $type ?? 'demo','show-phone' => $show_phone ?? true,'show-company' => $show_company ?? true,'show-message' => $show_message ?? true,'button-label' => $button_label ?? 'Submit']);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1366406863-0', $__key);

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
<?php else: ?>
<section class="section-pad bg-white">
    <div class="container-site max-w-2xl">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($headline)): ?>
            <h2 class="display-h2 mb-3"><?php echo $headline_html; ?></h2>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($intro)): ?>
            <p class="mb-8 text-muted"><?php echo e($intro); ?></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="rounded-3xl border border-line bg-white p-8 shadow-[0_12px_40px_rgba(10,22,40,0.05)]">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('lead-form', ['type' => $type ?? 'demo','show-phone' => $show_phone ?? true,'show-company' => $show_company ?? true,'show-message' => $show_message ?? true,'button-label' => $button_label ?? 'Submit']);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1366406863-1', $__key);

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
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /var/www/html/sf/byp/resources/views/blocks/form.blade.php ENDPATH**/ ?>