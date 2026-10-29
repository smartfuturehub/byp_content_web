@php
    $items = $items ?? ($breadcrumbs ?? []);
    $variant = $variant ?? 'bar';
    $contained = $contained ?? true;
    $onDark = $variant === 'overlay';
@endphp

@if($items !== [])
    <nav class="{{ $onDark ? 'relative z-10' : 'border-b border-line bg-white' }}" aria-label="Breadcrumb">
        <div class="{{ $contained ? 'container-site' : '' }}">
            <ol class="flex h-12 items-center gap-2 overflow-hidden text-[13px] leading-none">
                @foreach($items as $crumb)
                    <li class="flex min-w-0 items-center gap-2">
                        @if(! $loop->first)
                            <svg class="{{ $onDark ? 'text-white/40' : 'text-[#C5CDD6]' }} h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/>
                            </svg>
                        @endif

                        @if(! $loop->last)
                            <a
                                href="{{ cms_url($crumb['url'] ?? '#') }}"
                                class="{{ $onDark ? 'text-white/75 hover:text-white' : 'text-muted hover:text-brand' }} inline-flex min-h-8 max-w-[9rem] items-center gap-1.5 truncate sm:max-w-none"
                            >
                                @if($loop->first)
                                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-6H2a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                                <span>{{ $crumb['name'] }}</span>
                            </a>
                        @else
                            <span
                                class="{{ $onDark ? 'text-white' : 'text-navy' }} inline-flex min-h-8 min-w-0 max-w-[11rem] items-center truncate font-medium sm:max-w-[22rem] lg:max-w-[32rem]"
                                title="{{ $crumb['name'] }}"
                                aria-current="page"
                            >{{ $crumb['name'] }}</span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>
    </nav>
@endif
