<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Models\Page;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SiteStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Published pages', Page::query()->where('status', 'published')->count()),
            Stat::make('Blog posts', Post::query()->where('status', 'published')->count()),
            Stat::make('New leads', Lead::query()->where('status', 'new')->count()),
        ];
    }
}
