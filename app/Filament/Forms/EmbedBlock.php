<?php

namespace App\Filament\Forms;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Str;

/**
 * A place to drop an embed — Instagram, YouTube, X — inside a post body.
 *
 * The editor is a TipTap document with a fixed schema, so pasted embed markup
 * is stripped on save: the wrapper divs, every inline `style`, and the provider
 * `<script>` all disappear. A custom block sidesteps that by keeping the markup
 * in the node's config rather than in the document itself, and printing it back
 * out at render time.
 */
class EmbedBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'embed';
    }

    public static function getLabel(): string
    {
        return 'Embed / custom HTML';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Paste the embed code from Instagram, YouTube, X, or anywhere else. It is printed on the page exactly as given.')
            ->schema([
                Textarea::make('html')
                    ->label('Embed code')
                    ->rows(10)
                    ->required()
                    ->helperText('Rendered as raw HTML. Only paste code you trust.'),
            ]);
    }

    /**
     * @param  array<string, mixed>  $config
     * @param  array<string, mixed>  $data
     */
    public static function toHtml(array $config, array $data): ?string
    {
        return $config['html'] ?? null;
    }

    /**
     * @param  array<string, mixed>  $config
     */
    public static function getPreviewLabel(array $config): string
    {
        return match (true) {
            str_contains($config['html'] ?? '', 'instagram.com') => 'Instagram embed',
            str_contains($config['html'] ?? '', 'youtube.com'), str_contains($config['html'] ?? '', 'youtu.be') => 'YouTube embed',
            str_contains($config['html'] ?? '', 'twitter.com'), str_contains($config['html'] ?? '', 'x.com') => 'X embed',
            default => 'Embed',
        };
    }

    /**
     * The card shown inside the editor. Deliberately not the embed itself — the
     * pasted code carries its own CSS and scripts, which would be loose in the
     * admin panel.
     *
     * @param  array<string, mixed>  $config
     */
    public static function toPreviewHtml(array $config): string
    {
        $url = self::firstUrl($config['html'] ?? '');

        return view('filament.embed-block-preview', [
            'label' => self::getPreviewLabel($config),
            'url' => $url,
        ])->render();
    }

    protected static function firstUrl(string $html): ?string
    {
        preg_match('#https?://[^\s"\'<>]+#', $html, $matches);

        return isset($matches[0]) ? Str::limit(html_entity_decode($matches[0]), 70) : null;
    }
}
