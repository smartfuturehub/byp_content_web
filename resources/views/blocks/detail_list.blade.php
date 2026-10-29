@php
    $tone = $tone ?? 'white';
    $sectionClass = match ($tone) {
        'navy' => 'section-pad bg-navy text-white',
        'surface' => 'section-pad bg-white',
        default => 'section-pad bg-white',
    };
    $cardClass = $tone === 'navy'
        ? 'rounded-[1.5rem] border border-white/10 bg-white/5 p-8'
        : 'rounded-[1.5rem] border border-line bg-white p-8 shadow-[0_16px_40px_rgba(10,22,40,0.04)]';
@endphp

<section class="{{ $sectionClass }}">
    <div class="container-site">
        @if(!empty($headline) || !empty($intro))
            <div class="max-w-3xl">
                @if(!empty($headline))
                    <h2 class="display-h2 {{ $tone === 'navy' ? 'text-white' : '' }}">{!! $headline_html !!}</h2>
                @endif
                @if(!empty($intro))
                    <p class="mt-4 max-w-2xl text-[17px] leading-8 {{ $tone === 'navy' ? 'text-white/70' : 'text-muted' }}">{{ $intro }}</p>
                @endif
            </div>
        @endif

        <div class="mt-12 grid gap-6 lg:grid-cols-2">
            @foreach($columns ?? [] as $column)
                <article class="{{ $cardClass }}">
                    @if(!empty($column['title']))
                        <h3 class="font-display text-xl font-semibold {{ $tone === 'navy' ? 'text-white' : 'text-navy' }}">{{ $column['title'] }}</h3>
                    @endif
                    <ul class="mt-6 space-y-5">
                        @foreach($column['items'] ?? [] as $item)
                            <li class="border-t {{ $tone === 'navy' ? 'border-white/10' : 'border-line' }} pt-5 first:border-0 first:pt-0">
                                @if(!empty($item['label']))
                                    <p class="text-sm font-semibold {{ $tone === 'navy' ? 'text-accent' : 'text-brand' }}">{{ $item['label'] }}</p>
                                @endif
                                @if(!empty($item['body']))
                                    <p class="mt-1.5 text-[15px] leading-7 {{ $tone === 'navy' ? 'text-white/75' : 'text-muted' }}">{{ $item['body'] }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>
    </div>
</section>
