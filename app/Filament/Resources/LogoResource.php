<?php

namespace App\Filament\Resources;

use App\Filament\CmsMedia;
use App\Filament\Resources\LogoResource\Pages;
use App\Models\Logo;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class LogoResource extends Resource
{
    protected static ?string $model = Logo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationLabel = 'Logos & partners';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            Select::make('type')->options([
                'client' => 'Client',
                'partner' => 'Partner',
                'award' => 'Award',
                'acceleration' => 'Acceleration program',
            ])->required(),
            CmsMedia::image('image')->required(),
            TextInput::make('url'),
            TextInput::make('sort_order')->numeric()->default(0),
            Toggle::make('is_published')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->getStateUsing(fn (Logo $record) => media_url($record->image)),
                TextColumn::make('name'),
                TextColumn::make('type')->badge(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ManageLogos::route('/')];
    }
}
