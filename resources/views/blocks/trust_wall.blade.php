@php
    $groups = collect($groups ?? []);
    $hasHeadline = filled($headline ?? null);
    $headingTag = $hasHeadline ? 'h3' : 'h2';
    $keyed = $groups->keyBy('key');
    $clients = $keyed->get('client');
    $partners = $keyed->get('partner');
    $acceleration = $keyed->get('acceleration');
    $awards = $keyed->get('award');
    $known = ['client', 'partner', 'acceleration', 'award'];
    $extra = $groups->reject(fn ($group) => in_array($group['key'] ?? '', $known, true))->values();
@endphp

<section class="logo-wall">
    <div class="container-site flex flex-col gap-12 sm:gap-14">
        @if($hasHeadline || !empty($intro))
            <div class="text-center">
                @if($hasHeadline)
                    <h2 class="text-xl font-semibold tracking-[-0.03em] text-[#101828]">{!! $headline_html !!}</h2>
                @endif
                @if(!empty($intro))
                    <p class="mt-2 text-base leading-[1.6] text-[#475467]">{{ $intro }}</p>
                @endif
            </div>
        @endif

        @if(!empty($clients))
            @include('partials.logo-group', ['group' => $clients, 'headingTag' => $headingTag])
        @endif

        @if(!empty($partners) || !empty($acceleration))
            <div class="grid gap-12 lg:grid-cols-2 lg:gap-8">
                @if(!empty($partners))
                    @include('partials.logo-group', ['group' => $partners, 'headingTag' => $headingTag])
                @endif
                @if(!empty($acceleration))
                    @include('partials.logo-group', ['group' => $acceleration, 'headingTag' => $headingTag])
                @endif
            </div>
        @endif

        @if(!empty($awards))
            @include('partials.logo-group', ['group' => $awards, 'headingTag' => $headingTag])
        @endif

        @foreach($extra as $group)
            @include('partials.logo-group', ['group' => $group, 'headingTag' => $headingTag])
        @endforeach
    </div>
</section>
