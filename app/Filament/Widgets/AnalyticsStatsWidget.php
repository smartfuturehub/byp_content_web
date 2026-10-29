<?php

namespace App\Filament\Widgets;

use App\Support\Analytics\TrafficReport;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\Reactive;

class AnalyticsStatsWidget extends StatsOverviewWidget
{
    protected static bool $isDiscovered = false;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    #[Reactive]
    public int $days = 30;

    protected function getStats(): array
    {
        $report = app(TrafficReport::class)->summarize($this->days);

        return [
            Stat::make('Pageviews', number_format($report['pageviews'])),
            Stat::make('Sessions', number_format($report['sessions'])),
            Stat::make('Contact Us leads', number_format($report['leads'])),
            Stat::make('Top referrer', $report['top_referrer'] ?: 'Direct / none'),
        ];
    }
}
