<?php

namespace App\Support\Analytics;

use App\Models\Lead;
use App\Models\PageView;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class TrafficReport
{
    /**
     * @return array{
     *     from: string,
     *     to: string,
     *     pageviews: int,
     *     sessions: int,
     *     leads: int,
     *     top_referrer: string|null,
     *     views_by_day: array<int, array{date: string, views: int}>,
     *     top_pages: array<int, array{path: string, views: int}>,
     *     referrers: array<int, array{host: string, views: int}>,
     *     campaigns: array<int, array{source: string, medium: string, campaign: string, views: int}>,
     *     devices: array<int, array{device: string, views: int}>
     * }
     */
    public function summarize(int $days = 30): array
    {
        $days = in_array($days, [7, 30, 90], true) ? $days : 30;
        $to = now()->endOfDay();
        $from = now()->subDays($days - 1)->startOfDay();

        $views = PageView::query()->occurredBetween($from, $to);

        $pageviews = (clone $views)->count();
        $sessions = (clone $views)->distinct()->count('session_id');
        $leads = Lead::query()
            ->where('type', 'contact')
            ->whereBetween('created_at', [$from, $to])
            ->count();

        $referrers = $this->groupedCounts((clone $views)->whereNotNull('referrer_host'), 'referrer_host', 'host');
        $topReferrer = $referrers[0]['host'] ?? null;

        return [
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'pageviews' => $pageviews,
            'sessions' => $sessions,
            'leads' => $leads,
            'top_referrer' => $topReferrer,
            'views_by_day' => $this->viewsByDay($from, $to),
            'top_pages' => $this->groupedCounts(clone $views, 'path', 'path'),
            'referrers' => $referrers,
            'campaigns' => $this->campaigns($from, $to),
            'devices' => $this->groupedCounts(clone $views, 'device', 'device'),
        ];
    }

    /**
     * @return array<int, array{date: string, views: int}>
     */
    protected function viewsByDay(Carbon $from, Carbon $to): array
    {
        $counts = PageView::query()
            ->occurredBetween($from, $to)
            ->selectRaw('DATE(occurred_at) as day, COUNT(*) as views')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('views', 'day');

        $days = [];
        $cursor = $from->copy()->startOfDay();

        while ($cursor->lte($to)) {
            $key = $cursor->toDateString();
            $days[] = [
                'date' => $key,
                'views' => (int) ($counts[$key] ?? 0),
            ];
            $cursor->addDay();
        }

        return $days;
    }

    /**
     * @param  Builder<PageView>  $query
     * @return array<int, array<string, mixed>>
     */
    protected function groupedCounts($query, string $column, string $label): array
    {
        return $query
            ->whereNotNull($column)
            ->where($column, '!=', '')
            ->selectRaw($column.' as '.$label.', COUNT(*) as views')
            ->groupBy($column)
            ->orderByDesc('views')
            ->limit(20)
            ->get()
            ->map(fn ($row): array => [
                $label => (string) $row->{$label},
                'views' => (int) $row->views,
            ])
            ->all();
    }

    /**
     * @return array<int, array{source: string, medium: string, campaign: string, views: int}>
     */
    protected function campaigns(Carbon $from, Carbon $to): array
    {
        return PageView::query()
            ->occurredBetween($from, $to)
            ->whereNotNull('utm_source')
            ->where('utm_source', '!=', '')
            ->selectRaw('utm_source, utm_medium, utm_campaign, COUNT(*) as views')
            ->groupBy('utm_source', 'utm_medium', 'utm_campaign')
            ->orderByDesc('views')
            ->limit(20)
            ->get()
            ->map(fn ($row): array => [
                'source' => (string) $row->utm_source,
                'medium' => (string) ($row->utm_medium ?: '—'),
                'campaign' => (string) ($row->utm_campaign ?: '—'),
                'views' => (int) $row->views,
            ])
            ->all();
    }

    /**
     * Compact snapshot for the AI assistant.
     *
     * @return array<string, mixed>
     */
    public function forAssistant(int $days = 30): array
    {
        $summary = $this->summarize($days);

        return Collection::make($summary)
            ->except(['views_by_day'])
            ->all();
    }
}
