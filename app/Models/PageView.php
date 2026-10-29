<?php

namespace App\Models;

use Database\Factories\PageViewFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

#[Fillable([
    'path',
    'title',
    'referrer',
    'referrer_host',
    'utm_source',
    'utm_medium',
    'utm_campaign',
    'session_id',
    'device',
    'browser',
    'country',
    'language',
    'occurred_at',
])]
class PageView extends Model
{
    /** @use HasFactory<PageViewFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'occurred_at' => 'datetime',
        ];
    }

    /**
     * @param  Builder<PageView>  $query
     * @return Builder<PageView>
     */
    public function scopeOccurredBetween(Builder $query, Carbon $from, Carbon $to): Builder
    {
        return $query->whereBetween('occurred_at', [$from, $to]);
    }
}
