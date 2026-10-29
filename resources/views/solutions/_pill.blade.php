@php
    $tone = $tone ?? 'gold';
    $pillClass = match ($tone) {
        'blue' => 'bg-[#F0F9FF] text-[#026AA2]',
        'red' => 'bg-[#FEF3F2] text-[#B42318]',
        'green' => 'bg-[#ECFDF3] text-[#027A48]',
        'purple' => 'bg-[#F9F5FF] text-[#6941C6]',
        'pink' => 'bg-[#FDF2FA] text-[#C11574]',
        'amber' => 'bg-[#FFFAEB] text-[#B54708]',
        'gray' => 'bg-[#F2F4F7] text-[#344054]',
        default => 'bg-[#FEF3D9] text-[#7A4B00]',
    };
@endphp
<span class="{{ $class ?? 'mb-6' }} inline-flex items-center rounded-2xl px-3.5 py-1.5 text-sm font-medium {{ $pillClass }}">{{ $label }}</span>
