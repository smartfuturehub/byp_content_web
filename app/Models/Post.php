<?php

namespace App\Models;

use App\Filament\Forms\CmsRichEditor;
use App\Filament\Forms\EmbedBlock;
use App\Models\Contracts\PubliclyViewable;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Post extends Model implements PubliclyViewable
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'status',
        'excerpt',
        'body',
        'featured_image',
        'author_name',
        'published_at',
        'seo_title',
        'seo_description',
        'seo_canonical',
        'og_image',
        'robots',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Post $post): void {
            if (blank($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
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
        return url('/blog/'.$this->slug);
    }

    /**
     * The body as it goes on the page.
     *
     * Embeds are stored as empty placeholder nodes in the body HTML, so the
     * content has to pass through the renderer to get their markup back.
     *
     * `toUnsafeHtml()` rather than `toHtml()`: the sanitizer strips exactly what
     * an embed needs — its `<script>`, its inline styles, its data attributes.
     * Post bodies are written by signed-in CMS users, who are trusted with raw
     * HTML here the same way they are in the Custom HTML page block.
     */
    public function renderedBody(): HtmlString
    {
        if (blank($this->body)) {
            return new HtmlString('');
        }

        return new HtmlString(
            RichContentRenderer::make($this->body)
                ->customBlocks([EmbedBlock::class])
                ->fileAttachmentsDisk(CmsRichEditor::IMAGE_DISK)
                ->fileAttachmentsVisibility('public')
                ->toUnsafeHtml(),
        );
    }

    public function seoTitle(): string
    {
        return $this->seo_title ?: $this->title.' | '.setting('site_name', 'BYP Health');
    }

    public function seoDescription(): string
    {
        return $this->seo_description ?: $this->excerpt ?: setting('default_meta_description', '');
    }

    public function socialImage(): string
    {
        if (filled($this->og_image)) {
            return (string) $this->og_image;
        }

        if (filled($this->featured_image)) {
            return (string) $this->featured_image;
        }

        return '/brand/sf/home-hero.jpg';
    }

    public function displayAuthor(): string
    {
        return $this->author_name ?: $this->author?->name ?: setting('site_name', 'BYP Health');
    }
}
