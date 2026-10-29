<?php

namespace App\Models;

use App\Models\Contracts\PubliclyViewable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model implements PubliclyViewable
{
    protected $fillable = [
        'title',
        'slug',
        'status',
        'is_homepage',
        'published_at',
        'blocks',
        'featured_image',
        'seo_title',
        'seo_description',
        'seo_canonical',
        'og_image',
        'robots',
        'schema_type',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'blocks' => 'array',
            'is_homepage' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Page $page): void {
            if (blank($page->slug)) {
                $page->slug = Str::slug($page->title);
            }

            if ($page->is_homepage) {
                static::query()->where('id', '!=', $page->id ?? 0)->update(['is_homepage' => false]);
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where(function (Builder $q): void {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function isPubliclyVisible(): bool
    {
        return $this->status === 'published'
            && (blank($this->published_at) || $this->published_at->isPast());
    }

    public function url(): string
    {
        return $this->is_homepage ? url('/') : url('/'.$this->slug);
    }

    public function seoTitle(): string
    {
        return $this->seo_title ?: $this->title.' | '.setting('site_name', 'BYP Health');
    }

    public function seoDescription(): string
    {
        return $this->seo_description ?: setting('default_meta_description', '');
    }

    public function socialImage(): string
    {
        if (filled($this->og_image)) {
            return (string) $this->og_image;
        }

        if (filled($this->featured_image)) {
            return (string) $this->featured_image;
        }

        return (string) setting('logo', '/brand/images/logo.png');
    }

    public function socialImageAlt(): string
    {
        return $this->seoTitle();
    }
}
