<?php
    $email = setting('email');
    $phoneAe = setting('phone_ae');
    $phoneSg = setting('phone_sg');
    $phoneUs = setting('phone_us');
    $whatsapp = setting('whatsapp_url');
?>

<section id="contact" class="contact-band relative overflow-hidden bg-[#0B59AC] py-16 sm:py-[88px]">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_left,_rgba(255,255,255,0.14),_transparent_55%)]"></div>
    <div class="pointer-events-none absolute -right-24 top-10 h-72 w-72 rounded-full bg-[#F79F12]/20 blur-3xl"></div>

    <div class="container-site relative grid items-start gap-12 lg:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)] lg:gap-16">
        <div>
            <div class="mb-5 h-1 w-10 rounded-sm bg-[#f5a915]"></div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($intro)): ?>
                <p class="mb-4 whitespace-pre-line text-lg leading-7 text-white/75"><?php echo e($intro); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <h2 class="text-[1.9rem] font-semibold leading-[1.18] tracking-[-0.025em] text-white sm:text-[2.35rem]"><?php echo $headline_html; ?></h2>

            <div class="mt-8 space-y-3 text-[15px] text-white/85">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($email)): ?>
                    <p>
                        <a href="mailto:<?php echo e($email); ?>" class="hover:text-white"><?php echo e($email); ?></a>
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($phoneAe)): ?>
                    <p>
                        <a href="tel:<?php echo e(preg_replace('/[^\d+]/', '', (string) $phoneAe)); ?>" class="hover:text-white"><?php echo e($phoneAe); ?></a>
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($phoneSg)): ?>
                    <p>
                        <a href="tel:<?php echo e(preg_replace('/[^\d+]/', '', (string) $phoneSg)); ?>" class="hover:text-white"><?php echo e($phoneSg); ?></a>
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($phoneUs)): ?>
                    <p>
                        <a href="tel:<?php echo e(preg_replace('/[^\d+]/', '', (string) $phoneUs)); ?>" class="hover:text-white"><?php echo e($phoneUs); ?></a>
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($whatsapp)): ?>
                    <p>
                        <a href="<?php echo e($whatsapp); ?>" class="font-medium text-[#F79F12] hover:text-white" target="_blank" rel="noopener">WhatsApp us</a>
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($show_form)): ?>
            <div class="rounded-[1.5rem] bg-white p-6 shadow-[0_24px_60px_rgba(10,22,40,0.18)] sm:p-8">
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
</section>
<?php /**PATH /var/www/html/sf/byp/resources/views/blocks/contact.blade.php ENDPATH**/ ?>