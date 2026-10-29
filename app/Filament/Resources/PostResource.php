<?php

namespace App\Filament\Resources;

use App\Filament\CmsMedia;
use App\Filament\Forms\CmsRichEditor;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\SeoFields;
use App\Filament\ViewOnSiteAction;
use App\Models\Post;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Post')->columnSpanFull()->tabs([
                Tab::make('Content')->schema([
                    TextInput::make('title')->required()->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set, $get) => filled($get('slug')) ? null : $set('slug', str($state)->slug())),
                    TextInput::make('slug')->required()->unique(ignoreRecord: true),
                    Select::make('status')->options(['draft' => 'Draft', 'published' => 'Published'])->default('draft')->required(),
                    DateTimePicker::make('published_at')->default(now()),
                    Select::make('category_id')->relationship('category', 'name', fn ($query) => $query->where('type', 'post'))->searchable()->preload(),
                    TextInput::make('author_name')->label('Author name'),
                    CmsMedia::image('featured_image', 'Featured image')->columnSpanFull(),
                    Textarea::make('excerpt')->rows(3)->columnSpanFull(),
                    CmsRichEditor::make('body')->columnSpanFull(),
                ])->columns(2),
                Tab::make('SEO')->schema([SeoFields::make()]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable()->limit(50),
                TextColumn::make('category.name')->label('Category'),
                TextColumn::make('status')->badge()->color(fn (string $state) => $state === 'published' ? 'success' : 'gray'),
                TextColumn::make('published_at')->date()->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->recordActions([
                ViewOnSiteAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
