<?php

namespace App\Filament\Pages;

use App\Support\Analytics\Ga4Client;
use App\Support\Analytics\TrafficReport;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Support\View\ComponentAttributeBag;
use UnitEnum;

class Analytics extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Insights';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Analytics';

    protected static ?string $title = 'Analytics';

    protected static ?string $slug = 'analytics';

    protected string $view = 'filament.pages.analytics';

    public int $days = 30;

    public string $tab = 'site';

    public function getSubheading(): ?string
    {
        return 'First-party visits after cookie Accept. Connect GA4 in Site settings for Google reports.';
    }

    /**
     * @param  array<string, int|null>  $columns
     */
    public function insightsGrid(array $columns = ['lg' => 2]): ComponentAttributeBag
    {
        return (new ComponentAttributeBag)->grid($columns)->class(['fi-wi']);
    }

    /**
     * @return list<int>
     */
    public function ranges(): array
    {
        return [7, 30, 90];
    }

    /**
     * @return array<string, mixed>
     */
    public function report(): array
    {
        return app(TrafficReport::class)->summarize($this->days);
    }

    /**
     * @return array<string, mixed>
     */
    public function ga4(): array
    {
        return app(Ga4Client::class)->overview($this->days);
    }
}
