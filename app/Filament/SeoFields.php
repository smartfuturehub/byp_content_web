<?php

namespace App\Filament;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class SeoFields
{
    public static function make(): Section
    {
        return Section::make('SEO')
            ->collapsed()
            ->schema([
                TextInput::make('seo_title')->label('Meta title')->maxLength(70)
                    ->helperText('Shown in the browser tab and search results. Keep it unique to this page.'),
                Textarea::make('seo_description')->label('Meta description')->rows(3)->maxLength(180)
                    ->helperText('One or two sentences. Used for search snippets, Open Graph and Twitter.'),
                TextInput::make('seo_canonical')->label('Canonical URL')
                    ->helperText('Leave blank to use this page’s public URL.'),
                CmsMedia::image('og_image', 'Open Graph image'),
                Select::make('robots')->options([
                    'index,follow' => 'Index, follow',
                    'noindex,follow' => 'Noindex, follow',
                    'index,nofollow' => 'Index, nofollow',
                    'noindex,nofollow' => 'Noindex, nofollow',
                ])->default('index,follow'),
            ])
            ->columns(2);
    }
}
