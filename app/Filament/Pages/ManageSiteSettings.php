<?php

namespace App\Filament\Pages;

use App\Filament\CmsMedia;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class ManageSiteSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'Site settings';

    protected static ?string $navigationLabel = 'Site settings';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $data = SiteSetting::current()->data ?? [];
        $data['cookie_banner_enabled'] = ! in_array($data['cookie_banner_enabled'] ?? true, [false, 0, '0', 'false'], true);
        $data['first_party_analytics_enabled'] = ! in_array($data['first_party_analytics_enabled'] ?? true, [false, 0, '0', 'false'], true);

        $this->form->fill($data);
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data')->operation('edit');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Settings')->tabs([
                Tab::make('Brand')->schema([
                    TextInput::make('site_name')->required(),
                    TextInput::make('tagline'),
                    CmsMedia::image('logo', 'Logo'),
                    CmsMedia::image('favicon', 'Favicon'),
                    Textarea::make('about_blurb')->rows(4),
                    Textarea::make('footer_cta')->label('Footer text under logo')->rows(3),
                ]),
                Tab::make('Contact')->schema([
                    TextInput::make('email')->email(),
                    TextInput::make('topbar_line')->label('Top bar line')->helperText('Optional left-side text in the navy bar. Leave blank to hide it.'),
                    Textarea::make('coverage_line')->label('Coverage line')->rows(2)->columnSpanFull(),
                    TextInput::make('phone_ae')->label('UAE phone'),
                    TextInput::make('whatsapp_url')->label('WhatsApp URL')->helperText('e.g. https://wa.me/971557356736'),
                    TextInput::make('phone_sg')->label('Singapore phone'),
                    TextInput::make('phone_us')->label('United States phone'),
                    Textarea::make('address_ae')->label('UAE address')->rows(2),
                    Textarea::make('address_sg')->label('Singapore address')->rows(2),
                    Textarea::make('address_us')->label('United States address')->rows(2),
                    TextInput::make('twitter_url'),
                    TextInput::make('linkedin_url'),
                ])->columns(2),
                Tab::make('Header / CTA')->schema([
                    TextInput::make('header_cta_label')->default('Contact Us'),
                    TextInput::make('header_cta_url')->default('/contact-us'),
                    TextInput::make('newsletter_headline'),
                    Textarea::make('newsletter_body')->rows(2),
                ]),
                Tab::make('SEO')->schema([
                    TextInput::make('default_meta_title')
                        ->helperText('Fallback title when a page does not have its own meta title.'),
                    Textarea::make('default_meta_description')->rows(3)
                        ->helperText('Fallback description for pages without their own meta description.'),
                    Textarea::make('robots_extra')->label('Extra robots.txt rules')->rows(3),
                ]),
                Tab::make('Cookies & analytics')->schema([
                    Toggle::make('cookie_banner_enabled')
                        ->label('Show cookie banner')
                        ->helperText('Turn this off only if you will load analytics without asking. Public pages keep the banner on by default.'),
                    TextInput::make('cookie_banner_title')->label('Banner heading'),
                    Textarea::make('cookie_banner_body')->label('Banner text')->rows(3)
                        ->helperText('A Privacy Policy link is added after this text.'),
                    TextInput::make('google_analytics_id')
                        ->label('Google Analytics 4 ID')
                        ->placeholder('G-5MWJ5HDFMZ')
                        ->helperText('Confirmed measurement ID for this site: G-5MWJ5HDFMZ. Leave blank if Tag Manager already sends page views.'),
                    TextInput::make('google_tag_manager_id')
                        ->label('Google Tag Manager ID')
                        ->placeholder('GTM-KCDG6B9B')
                        ->helperText('Confirmed container ID for this site: GTM-KCDG6B9B. Tags load only after a visitor accepts cookies.'),
                    TextInput::make('google_ads_id')
                        ->label('Google Ads ID')
                        ->placeholder('AW-000000000')
                        ->helperText('Optional. Loads only after consent.'),
                    Toggle::make('first_party_analytics_enabled')
                        ->label('Store site visits in this CMS')
                        ->helperText('Records page views after cookie Accept so the Analytics page can show graphs without waiting on Google. Default is on.')
                        ->default(true),
                    TextInput::make('ga4_property_id')
                        ->label('GA4 property ID')
                        ->placeholder('123456789')
                        ->helperText('Numeric property ID for the Google Analytics Data API (not the G- measurement ID). Service account JSON path stays in GOOGLE_ANALYTICS_CREDENTIALS in .env.'),
                ]),
            ]),
        ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([
                        Action::make('save')->label('Save settings')->submit('save'),
                    ]),
                ]),
        ]);
    }

    public function save(): void
    {
        $settings = SiteSetting::current();
        $settings->data = $this->form->getState();
        $settings->save();

        Notification::make()->title('Settings saved')->success()->send();
    }
}
