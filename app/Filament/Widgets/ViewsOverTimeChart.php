<?php

namespace App\Filament\Widgets;

use App\Support\Analytics\TrafficReport;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\Reactive;

class ViewsOverTimeChart extends ChartWidget
{
    protected static bool $isDiscovered = false;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Pageviews by day';

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '280px';

    #[Reactive]
    public int $days = 30;

    protected function getData(): array
    {
        $report = app(TrafficReport::class)->summarize($this->days);

        return [
            'datasets' => [
                [
                    'label' => 'Pageviews',
                    'data' => array_column($report['views_by_day'], 'views'),
                    'borderColor' => '#0B59AC',
                    'backgroundColor' => 'rgba(11, 89, 172, 0.12)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => array_column($report['views_by_day'], 'date'),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
