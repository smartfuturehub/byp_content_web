<?php

namespace App\Filament\Resources;

use App\Blocks\BlockRegistry;
use App\Filament\CmsMedia;
use App\Filament\Resources\PageResource\Pages;
use App\Filament\SeoFields;
use App\Filament\ViewOnSiteAction;
use App\Models\Page;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Page')
                ->columnSpanFull()
                ->tabs([
                    Tab::make('Content')->schema([
                        TextInput::make('title')->required()->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, $get) => filled($get('slug')) ? null : $set('slug', str($state)->slug())),
                        TextInput::make('slug')->required()->unique(ignoreRecord: true),
                        Select::make('status')->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                        ])->default('draft')->required(),
                        DateTimePicker::make('published_at'),
                        Toggle::make('is_homepage')->label('Set as homepage'),
                        CmsMedia::image('featured_image', 'Featured image'),
                        Select::make('schema_type')->options([
                            'WebPage' => 'WebPage',
                            'AboutPage' => 'AboutPage',
                            'ContactPage' => 'ContactPage',
                            'MedicalWebPage' => 'MedicalWebPage',
                            'FAQPage' => 'FAQPage',
                        ])->default('WebPage'),
                    ])->columns(2),
                    Tab::make('Sections')->schema([
                        BlockRegistry::builder(),
                    ]),
                    Tab::make('SEO')->schema([
                        SeoFields::make(),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('slug')->searchable()->toggleable(),
                TextColumn::make('status')->badge()->color(fn (string $state) => $state === 'published' ? 'success' : 'gray'),
                IconColumn::make('is_homepage')->boolean()->label('Home'),
                TextColumn::make('updated_at')->dateTime()->since()->sortable(),
            ])
            ->recordActions([
                ViewOnSiteAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
