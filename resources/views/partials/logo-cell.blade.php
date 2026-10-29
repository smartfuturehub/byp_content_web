@php
    $href = $item['url'] ?? null;
    $tag = filled($href) ? 'a' : 'div';
@endphp
<{{ $tag }}
    @if(filled($href)) href="{{ $href }}" rel="noopener" target="_blank" @endif
    class="logo-cell"
>
    <img
        src="{{ media_url($item['image'] ?? '') }}"
        alt="{{ $item['name'] ?? '' }}"
        class="logo-mark"
        loading="lazy"
        decoding="async"
    >
    @if(!empty($item['name']))
        <span class="sr-only">{{ $item['name'] }}</span>
    @endif
</{{ $tag }}>
