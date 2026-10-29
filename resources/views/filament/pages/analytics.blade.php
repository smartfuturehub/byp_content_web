<x-filament-panels::page>
    @php
        $report = $this->report();
        $ga4 = $tab === 'google'
            ? $this->ga4()
            : ['configured' => false, 'sessions' => [], 'sources' => []];
    @endphp

    <div class="fi-ac">
        <x-filament::input.wrapper prefix="Range">
            <x-filament::input.select wire:model.live="days">
                @foreach ($this->ranges() as $range)
                    <option value="{{ $range }}">Last {{ $range }} days</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>
    </div>

    <x-filament::tabs label="Analytics source">
        <x-filament::tabs.item
            :active="$tab === 'site'"
            wire:click="$set('tab', 'site')"
        >
            Site traffic
        </x-filament::tabs.item>
        <x-filament::tabs.item
            :active="$tab === 'google'"
            wire:click="$set('tab', 'google')"
        >
            Google Analytics
        </x-filament::tabs.item>
    </x-filament::tabs>

    @if ($tab === 'site')
        <x-filament-widgets::widgets
            :widgets="[
                \App\Filament\Widgets\AnalyticsStatsWidget::class,
                \App\Filament\Widgets\ViewsOverTimeChart::class,
            ]"
            :columns="1"
            :data="['days' => $days]"
        />

        <div {{ $this->insightsGrid(['lg' => 2]) }}>
            @include('filament.pages.partials.insights-table', [
                'heading' => 'Top pages',
                'columns' => [
                    ['label' => 'Path', 'key' => 'path'],
                    ['label' => 'Views', 'key' => 'views', 'align' => 'end', 'numeric' => true],
                ],
                'rows' => $report['top_pages'],
                'emptyHeading' => 'No pageviews in this range yet',
                'emptyDescription' => 'Graphs fill after visitors accept cookies.',
            ])

            @include('filament.pages.partials.insights-table', [
                'heading' => 'Referring websites',
                'columns' => [
                    ['label' => 'Website', 'key' => 'host'],
                    ['label' => 'Views', 'key' => 'views', 'align' => 'end', 'numeric' => true],
                ],
                'rows' => $report['referrers'],
                'emptyHeading' => 'No external referrers yet',
                'emptyDescription' => 'Direct visits are excluded from this table.',
            ])

            @include('filament.pages.partials.insights-table', [
                'heading' => 'Campaigns (UTM)',
                'columns' => [
                    ['label' => 'Source', 'key' => 'source'],
                    ['label' => 'Medium', 'key' => 'medium'],
                    ['label' => 'Campaign', 'key' => 'campaign'],
                    ['label' => 'Views', 'key' => 'views', 'align' => 'end', 'numeric' => true],
                ],
                'rows' => $report['campaigns'],
                'emptyHeading' => 'No UTM campaigns in this range',
            ])

            @include('filament.pages.partials.insights-table', [
                'heading' => 'Devices',
                'columns' => [
                    ['label' => 'Device', 'key' => 'device'],
                    ['label' => 'Views', 'key' => 'views', 'align' => 'end', 'numeric' => true],
                ],
                'rows' => $report['devices'],
                'emptyHeading' => 'No device data yet',
            ])
        </div>
    @elseif (! ($ga4['configured'] ?? false))
        <x-filament::section heading="Google Analytics is not connected yet">
            <p class="fi-section-header-description">
                Site traffic above is stored in this CMS after cookie Accept. To also pull historical Google reports, add the numeric GA4 property ID in Site settings and set
                <code>GOOGLE_ANALYTICS_CREDENTIALS</code>
                in
                <code>.env</code>
                to a service account JSON with Analytics read access. The public measurement ID (G-5MWJ5HDFMZ) stays on the website as it is today.
            </p>
        </x-filament::section>
    @elseif (! empty($ga4['error']))
        <x-filament::callout color="danger" heading="Google Analytics could not be loaded">
            {{ $ga4['error'] }}
        </x-filament::callout>
    @else
        <div {{ $this->insightsGrid(['lg' => 2]) }}>
            @include('filament.pages.partials.insights-table', [
                'heading' => 'GA4 sessions by day',
                'columns' => [
                    ['label' => 'Date', 'key' => 'date'],
                    ['label' => 'Sessions', 'key' => 'sessions', 'align' => 'end', 'numeric' => true],
                    ['label' => 'Views', 'key' => 'screenPageViews', 'align' => 'end', 'numeric' => true],
                ],
                'rows' => $ga4['sessions'],
                'emptyHeading' => 'No GA4 rows returned',
            ])

            @include('filament.pages.partials.insights-table', [
                'heading' => 'GA4 source / medium',
                'columns' => [
                    ['label' => 'Source', 'key' => 'sessionSource'],
                    ['label' => 'Medium', 'key' => 'sessionMedium'],
                    ['label' => 'Sessions', 'key' => 'sessions', 'align' => 'end', 'numeric' => true],
                ],
                'rows' => $ga4['sources'],
                'emptyHeading' => 'No GA4 sources returned',
            ])
        </div>
    @endif
</x-filament-panels::page>
