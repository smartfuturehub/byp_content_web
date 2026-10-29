@php
    $tag = $headingTag ?? 'h2';
@endphp
<div class="logo-group">
    <{{ $tag }} class="logo-heading">{{ $group['label'] ?? '' }}</{{ $tag }}>
    <div class="logo-grid">
        @foreach($group['items'] ?? [] as $item)
            @include('partials.logo-cell', ['item' => $item])
        @endforeach
    </div>
</div>
