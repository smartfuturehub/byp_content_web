<?php

namespace App\Filament\Resources;

use App\Filament\CmsMedia;
use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBars3;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            TextInput::make('location')->required()->helperText('header, footer, legal'),
            Repeater::make('items')->schema([
                TextInput::make('label')->required(),
                TextInput::make('url')->required()->helperText('Solutions “View all” uses this URL.'),
                Textarea::make('summary')->rows(2)->helperText('Shown in the header dropdown intro.'),
                TextInput::make('view_all_label')->label('View all label')->placeholder('View all'),
                Repeater::make('children')->schema([
                    TextInput::make('label')->required(),
                    TextInput::make('url')->required(),
                    Textarea::make('summary')->rows(2)->helperText('One or two sentences under the label.'),
                    CmsMedia::image('image', 'Thumbnail'),
                ])->collapsible()->defaultItems(0)->label('Dropdown items'),
            ])->collapsible()->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('location')->badge(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMenus::route('/'),
        ];
    }
}
