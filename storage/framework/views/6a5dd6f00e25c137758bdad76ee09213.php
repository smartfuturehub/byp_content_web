<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['url', 'logoSrc' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['url', 'logoSrc' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $logoSrc = filled($logoSrc) ? $logoSrc : \App\Support\MailLogo::src();
?>
<tr>
<td class="header">
<a href="<?php echo new \Illuminate\Support\EncodedHtmlString($url); ?>" style="display: inline-block;" target="_blank" rel="noopener noreferrer">
<img src="<?php echo new \Illuminate\Support\EncodedHtmlString($logoSrc); ?>" alt="BYP Health" class="logo" height="72" style="display: block; border: 0; outline: none; text-decoration: none; height: 72px; width: auto; max-width: 160px;">
</a>
</td>
</tr>
<?php /**PATH /var/www/html/sf/byp/resources/views/vendor/mail/html/header.blade.php ENDPATH**/ ?>