<section class="section-pad bg-white">
    <div class="container-site max-w-3xl">
        <h2 class="display-h2">{!! $headline_html !!}</h2>
        <div class="mt-10 divide-y divide-line overflow-hidden rounded-3xl border border-line bg-white" x-data="{ open: 0 }">
            @foreach($items ?? [] as $index => $item)
                <div class="px-6 sm:px-8">
                    <button type="button" class="flex w-full items-center justify-between gap-4 py-5 text-left font-medium text-navy" @click="open = open === {{ $index }} ? -1 : {{ $index }}">
                        <span>{{ $item['question'] ?? '' }}</span>
                        <svg class="h-5 w-5 shrink-0 text-brand transition" :class="open === {{ $index }} && 'rotate-180'" viewBox="0 0 20 20" fill="currentColor"><path d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"/></svg>
                    </button>
                    <div x-show="open === {{ $index }}" x-cloak class="pb-5 text-sm leading-7 text-muted">
                        {!! $item['answer'] ?? '' !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
