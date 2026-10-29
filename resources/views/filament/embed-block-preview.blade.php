<div style="display:flex;align-items:center;gap:.75rem;border:1px dashed #cbd5e1;border-radius:.75rem;padding:1rem;background:#f8fafc;">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#64748b" style="width:1.5rem;height:1.5rem;flex-shrink:0;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
    </svg>
    <div style="min-width:0;">
        <div style="font-weight:600;color:#0f172a;">{{ $label }}</div>
        @if($url)
            <div style="color:#64748b;font-size:.8125rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $url }}</div>
        @else
            <div style="color:#64748b;font-size:.8125rem;">Custom HTML</div>
        @endif
    </div>
</div>
