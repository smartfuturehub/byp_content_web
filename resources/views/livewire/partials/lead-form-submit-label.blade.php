<span wire:loading.remove wire:target="submit">{{ $buttonLabel }}</span>
<span wire:loading.inline-flex wire:target="submit" role="status" class="inline-flex items-center gap-2 whitespace-nowrap">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true" style="width:16px;height:16px;min-width:16px;min-height:16px" class="shrink-0 animate-spin">
        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity="0.25"></circle>
        <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path>
    </svg>
    {{ $loadingLabel }}
</span>
