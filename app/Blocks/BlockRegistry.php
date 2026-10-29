<?php

namespace App\Blocks;

use App\Filament\CmsMedia;
use App\Models\Faq;
use App\Models\Logo;
use App\Models\MedicalDevice;
use App\Models\Post;
use App\Models\Testimonial;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\HtmlString;

class BlockRegistry
{
    public static function builder(string $name = 'blocks'): Builder
    {
        return Builder::make($name)
            ->blocks(self::filamentBlocks())
            ->collapsible()
            ->cloneable()
            ->blockNumbers(false)
            ->addActionLabel('Add section')
            ->columnSpanFull();
    }

    /**
     * @return array<int, Block>
     */
    public static function filamentBlocks(): array
    {
        return [
            Block::make('hero_slider')
                ->label('Hero slider')
                ->schema([
                    Repeater::make('slides')->schema([
                        TextInput::make('eyebrow'),
                        TextInput::make('headline')->required()->helperText('Use **word** for blue highlight and __word__ for orange.'),
                        Textarea::make('body')->rows(3),
                        CmsMedia::image('image'),
                        TextInput::make('image_alt')->label('Image alt text'),
                        TextInput::make('cta_label')->default('View More'),
                        TextInput::make('cta_url')->default('/contact-us'),
                    ])->defaultItems(3)->collapsible(),
                ]),
            Block::make('hero')
                ->label('Hero')
                ->schema([
                    Select::make('layout')->options(['home' => 'Homepage cinematic', 'studio' => 'Studio split', 'overlay' => 'Full-bleed photo', 'split' => 'Text + image'])->default('studio'),
                    TextInput::make('eyebrow')->label('Eyebrow'),
                    TextInput::make('subhead')->label('Blue subhead'),
                    TextInput::make('headline')->required()->helperText('Use **word** for blue highlight and __word__ for orange.'),
                    Textarea::make('body')->rows(3),
                    CmsMedia::image('image'),
                    TextInput::make('image_alt')->label('Image alt text'),
                    TextInput::make('caption')->label('Image caption'),
                    Select::make('fit')->options(['cover' => 'Crop to fill', 'contain' => 'Show full image'])->default('cover'),
                    Toggle::make('show_form')->label('Show email capture form')->default(true),
                    TextInput::make('form_placeholder')->default('Work email'),
                    TextInput::make('form_button')->default('Book a demo'),
                    TextInput::make('cta_label')->label('Button label'),
                    TextInput::make('cta_url')->label('Button URL'),
                    TextInput::make('secondary_label'),
                    TextInput::make('secondary_url'),
                ]),
            Block::make('cta_band')
                ->label('CTA band')
                ->schema([
                    TextInput::make('headline')->required(),
                    Textarea::make('body')->rows(2),
                    TextInput::make('button_label')->default('Book a Demo'),
                    TextInput::make('button_url')->default('/contact-us'),
                    Select::make('style')->options(['navy' => 'Navy', 'blue' => 'Blue', 'light' => 'Light'])->default('navy'),
                ]),
            Block::make('rich_text')
                ->label('Rich text')
                ->schema([
                    TextInput::make('headline'),
                    RichEditor::make('body')->columnSpanFull(),
                    Select::make('align')->options(['left' => 'Left', 'center' => 'Center'])->default('left'),
                ]),
            Block::make('split')
                ->label('Image + text')
                ->schema([
                    TextInput::make('eyebrow'),
                    TextInput::make('headline')->required(),
                    RichEditor::make('body'),
                    CmsMedia::image('image'),
                    TextInput::make('image_alt'),
                    Select::make('fit')->options(['cover' => 'Crop to fill', 'contain' => 'Show full image'])->default('cover'),
                    Select::make('layout')->options([
                        'split' => 'Text beside image',
                        'stack' => 'Text above image',
                        'integrations' => 'EHR integrations band',
                    ])->default('split'),
                    Toggle::make('image_right')->label('Image on the right')->default(true)->visible(fn ($get) => ($get('layout') ?? 'split') === 'split'),
                    Select::make('tone')->options(['white' => 'White', 'surface' => 'Light grey', 'soft' => 'Brand wash', 'navy' => 'Navy'])->default('white')->visible(fn ($get) => ($get('layout') ?? 'split') !== 'integrations'),
                    Repeater::make('systems')
                        ->label('System chips')
                        ->schema([
                            TextInput::make('label')->required(),
                        ])
                        ->defaultItems(0)
                        ->visible(fn ($get) => ($get('layout') ?? 'split') === 'integrations'),
                    TextInput::make('button_label'),
                    TextInput::make('button_url'),
                ]),
            Block::make('video')
                ->label('Video')
                ->schema([
                    TextInput::make('headline'),
                    CmsMedia::video('src')->required(),
                    CmsMedia::image('poster', 'Poster image'),
                    Toggle::make('autoplay')->default(true),
                ]),
            Block::make('gallery')
                ->label('Image gallery')
                ->schema([
                    TextInput::make('headline'),
                    Textarea::make('intro')->rows(2),
                    Select::make('variant')->options(['scene' => 'Photos / kits', 'product' => 'Devices / screens'])->default('scene'),
                    Repeater::make('images')->schema([
                        CmsMedia::image('src')->required(),
                        TextInput::make('alt')->label('Alt text'),
                        TextInput::make('caption'),
                    ])->grid(3)->defaultItems(3),
                ]),
            Block::make('cards')
                ->label('Cards grid')
                ->schema([
                    TextInput::make('headline'),
                    TextInput::make('anchor')->label('Section id')->helperText('e.g. solutions'),
                    Textarea::make('intro')->rows(3),
                    Select::make('variant')->options(['photo' => 'Photo cards', 'feature' => 'Numbered pillars', 'tile' => 'Small photo tiles', 'bento' => 'Bento mosaic'])->default('photo'),
                    Select::make('tone')->options(['white' => 'White', 'surface' => 'Light grey', 'soft' => 'Brand wash', 'navy' => 'Navy'])->default('white'),
                    Select::make('fit')->options(['cover' => 'Crop to fill', 'contain' => 'Show full image'])->default('cover'),
                    Select::make('columns')->options(['1' => '1', '2' => '2', '3' => '3', '4' => '4'])->default('3'),
                    Repeater::make('items')->schema([
                        CmsMedia::image('image'),
                        TextInput::make('badge')->label('Pill / badge'),
                        Select::make('badge_tone')->options([
                            'blue' => 'Blue',
                            'red' => 'Red',
                            'green' => 'Green',
                            'purple' => 'Purple',
                            'pink' => 'Pink',
                            'amber' => 'Amber',
                            'gray' => 'Gray',
                        ])->visible(fn ($get) => filled($get('badge'))),
                        TextInput::make('title')->required(),
                        Textarea::make('body')->rows(3),
                        Repeater::make('sections')->label('Labeled paragraphs')->schema([
                            TextInput::make('label'),
                            Textarea::make('body')->rows(3),
                        ])->defaultItems(0)->helperText('Optional. Use for The challenge / What we deployed / The outcome.'),
                        Repeater::make('pills')->label('Capsules')->schema([
                            TextInput::make('label')->required(),
                        ])->defaultItems(0),
                        TextInput::make('url'),
                    ])->collapsible()->defaultItems(3),
                ]),
            Block::make('stats')
                ->label('Stats / traction')
                ->schema([
                    Select::make('variant')->options(['strip' => 'Full-width strip', 'panel' => 'Panel with copy'])->default('strip'),
                    TextInput::make('headline')->default('Traction'),
                    Textarea::make('body')->rows(3),
                    Repeater::make('items')->schema([
                        TextInput::make('value')->required()->helperText('e.g. 440'),
                        TextInput::make('suffix')->default('+'),
                        TextInput::make('label')->required(),
                    ])->defaultItems(4)->grid(2),
                ]),
            Block::make('logo_cloud')
                ->label('Logo cloud')
                ->schema([
                    TextInput::make('headline')->default('Our Clients'),
                    Select::make('source')->options([
                        'manual' => 'Manual logos',
                        'client' => 'Clients from library',
                        'partner' => 'Partners from library',
                        'award' => 'Awards from library',
                        'acceleration' => 'Acceleration from library',
                    ])->default('manual'),
                    Repeater::make('items')->schema([
                        TextInput::make('name'),
                        CmsMedia::image('image')->required(),
                        TextInput::make('url'),
                    ])->visible(fn ($get) => $get('source') === 'manual'),
                ]),
            Block::make('trust_wall')
                ->label('Trust wall')
                ->schema([
                    TextInput::make('headline')->default('Trusted across healthcare'),
                    Textarea::make('intro')->rows(2),
                    Toggle::make('show_marquee')->label('Show scrolling logo strip')->default(true),
                    Select::make('sources')
                        ->multiple()
                        ->options([
                            'client' => 'Clients',
                            'partner' => 'Partners',
                            'acceleration' => 'Acceleration',
                            'award' => 'Awards',
                        ])
                        ->default(['client', 'partner', 'award']),
                ]),
            Block::make('devices')
                ->label('Device showcase')
                ->schema([
                    TextInput::make('headline')->default('Medical Devices'),
                    TextInput::make('eyebrow')->label('Blue subhead'),
                    Textarea::make('intro')->rows(2),
                    TextInput::make('closing')->label('Line under devices'),
                    Toggle::make('show_pills')->label('Show name capsules')->default(true),
                    Toggle::make('from_library')->label('Use devices from CMS library')->default(true),
                    Repeater::make('tags')->label('Name capsules')->schema([
                        TextInput::make('label')->required(),
                        Select::make('tone')->options([
                            'red' => 'Red',
                            'blue' => 'Blue',
                            'amber' => 'Amber',
                            'pink' => 'Pink',
                            'purple' => 'Purple',
                            'green' => 'Green',
                            'gray' => 'Gray',
                        ])->default('blue'),
                    ])->defaultItems(0),
                    Repeater::make('items')->schema([
                        TextInput::make('name')->required(),
                        CmsMedia::image('image'),
                        TextInput::make('url'),
                    ])->visible(fn ($get) => ! $get('from_library')),
                ]),
            Block::make('testimonials')
                ->label('Testimonials')
                ->schema([
                    TextInput::make('headline')->default('What our clients said about us'),
                    Toggle::make('from_library')->default(true),
                    Repeater::make('items')->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('organization'),
                        Textarea::make('quote')->required()->rows(3),
                    ])->visible(fn ($get) => ! $get('from_library')),
                ]),
            Block::make('faq')
                ->label('FAQ')
                ->schema([
                    TextInput::make('headline')->default('Frequently asked questions'),
                    Toggle::make('from_library')->default(true),
                    Repeater::make('items')->schema([
                        TextInput::make('question')->required(),
                        Textarea::make('answer')->required()->rows(3),
                    ])->visible(fn ($get) => ! $get('from_library')),
                ]),
            Block::make('detail_list')
                ->label('Choose this / what they receive')
                ->schema([
                    TextInput::make('headline'),
                    Textarea::make('intro')->rows(2),
                    Select::make('tone')->options(['surface' => 'Light grey', 'white' => 'White', 'navy' => 'Navy'])->default('surface'),
                    Repeater::make('columns')->schema([
                        TextInput::make('title')->required(),
                        Repeater::make('items')->schema([
                            TextInput::make('label')->required(),
                            Textarea::make('body')->rows(2),
                        ])->defaultItems(3),
                    ])->defaultItems(2)->maxItems(2),
                ]),
            Block::make('process')
                ->label('Process / timeline')
                ->schema([
                    TextInput::make('headline'),
                    TextInput::make('anchor')->label('Section id')->helperText('e.g. how-it-works'),
                    Textarea::make('intro')->rows(2),
                    Repeater::make('steps')->schema([
                        CmsMedia::image('image', 'Step image'),
                        TextInput::make('title')->required(),
                        Textarea::make('body')->rows(2),
                    ])->defaultItems(4),
                ]),
            Block::make('blog_latest')
                ->label('Latest blog posts')
                ->schema([
                    TextInput::make('headline')->default('Latest News'),
                    TextInput::make('count')->numeric()->default(4),
                    TextInput::make('button_label')->default('See more'),
                    TextInput::make('button_url')->default('/blog'),
                ]),
            Block::make('contact')
                ->label('Contact / locations')
                ->schema([
                    TextInput::make('headline')->default('Send a message'),
                    Textarea::make('intro')->rows(2),
                    Toggle::make('show_form')->default(true),
                    Toggle::make('show_details')->default(true),
                ]),
            Block::make('newsletter')
                ->label('Newsletter')
                ->schema([
                    TextInput::make('headline')->default('Follow our newsletter'),
                    Textarea::make('body')->rows(2),
                    TextInput::make('button_label')->default("Let's Talk"),
                ]),
            Block::make('form')
                ->label('Lead form')
                ->schema([
                    TextInput::make('headline')->default('Book a demo'),
                    Textarea::make('intro')->rows(2),
                    Select::make('type')->options([
                        'demo' => 'Book a demo',
                        'contact' => 'Contact',
                        'quote' => 'Request a quote',
                        'newsletter' => 'Newsletter',
                    ])->default('demo'),
                    Toggle::make('show_phone')->default(true),
                    Toggle::make('show_company')->default(true),
                    Toggle::make('show_message')->default(true),
                    TextInput::make('button_label')->default('Submit'),
                    Select::make('style')->options(['light' => 'Light card', 'navy' => 'Navy conversion band'])->default('light'),
                ]),
            Block::make('html')
                ->label('Custom HTML')
                ->schema([
                    Textarea::make('html')->rows(8)->helperText('Use carefully. Rendered as HTML.'),
                ]),
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>|null  $blocks
     * @param  array<string, mixed>  $shared
     */
    public static function render(?array $blocks, array $shared = [], ?string $preferFolder = null): HtmlString
    {
        $html = '';
        $first = true;

        foreach ($blocks ?? [] as $block) {
            $type = $block['type'] ?? null;
            $data = $block['data'] ?? [];

            if (! $type) {
                continue;
            }

            $view = ($preferFolder !== null && view()->exists($preferFolder.'.'.$type))
                ? $preferFolder.'.'.$type
                : 'blocks.'.$type;

            if (! view()->exists($view)) {
                continue;
            }

            $data = self::viewData($type, $data);

            if ($first && $shared !== []) {
                $data = array_merge($data, $shared);
            }

            $first = false;
            $html .= view($view, $data)->render();
        }

        return new HtmlString($html);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function viewData(string $type, array $data): array
    {
        $data['headline_html'] = self::accentHeadline($data['headline'] ?? '');

        if ($type === 'hero_slider') {
            $data['slides'] = collect($data['slides'] ?? [])->map(function (array $slide): array {
                $slide['headline_html'] = self::accentHeadline($slide['headline'] ?? '');

                return $slide;
            })->all();
        }

        return match ($type) {
            'logo_cloud' => self::withLogos($data),
            'trust_wall' => self::withTrustWall($data),
            'devices' => self::withDevices($data),
            'testimonials' => self::withTestimonials($data),
            'faq' => self::withFaqs($data),
            'blog_latest' => array_merge($data, [
                'posts' => Post::query()->published()->latest('published_at')->limit((int) ($data['count'] ?? 4))->get(),
            ]),
            default => $data,
        };
    }

    public static function accentHeadline(?string $text): string
    {
        $safe = e($text ?? '');
        $safe = preg_replace('/\*\*(.+?)\*\*/', '<span class="text-brand">$1</span>', $safe);
        $safe = preg_replace('/__(.+?)__/', '<span class="text-accent">$1</span>', $safe);

        return $safe;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected static function withLogos(array $data): array
    {
        $source = $data['source'] ?? 'manual';

        if ($source !== 'manual') {
            $data['items'] = Logo::query()->published()->ofType($source)->get()->map(fn (Logo $logo) => self::logoItem($logo))->all();
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected static function withTrustWall(array $data): array
    {
        $labels = [
            'client' => 'Clients',
            'partner' => 'Partners',
            'acceleration' => 'Acceleration Programs',
            'award' => 'Awards',
        ];
        $sources = $data['sources'] ?? array_keys($labels);
        $groups = [];
        $marquee = [];

        foreach ($sources as $source) {
            if (! isset($labels[$source])) {
                continue;
            }

            $items = Logo::query()->published()->ofType($source)->get()->map(fn (Logo $logo) => self::logoItem($logo))->all();

            if ($items === []) {
                continue;
            }

            $groups[] = [
                'key' => $source,
                'label' => $labels[$source],
                'items' => $items,
            ];
            $marquee = array_merge($marquee, $items);
        }

        $data['groups'] = $groups;
        $data['marquee'] = $marquee;

        return $data;
    }

    /**
     * @return array{name: string, image: ?string, url: ?string}
     */
    protected static function logoItem(Logo $logo): array
    {
        return [
            'name' => $logo->name,
            'image' => $logo->image,
            'url' => $logo->url,
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected static function withDevices(array $data): array
    {
        if (! empty($data['from_library'])) {
            $data['items'] = MedicalDevice::query()->published()->get()->map(fn (MedicalDevice $device) => [
                'name' => $device->name,
                'image' => $device->image,
                'url' => $device->url,
            ])->all();
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected static function withTestimonials(array $data): array
    {
        if (! empty($data['from_library'])) {
            $data['items'] = Testimonial::query()->published()->get()->map(fn (Testimonial $item) => [
                'name' => $item->name,
                'organization' => $item->organization,
                'quote' => $item->quote,
            ])->all();
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected static function withFaqs(array $data): array
    {
        if (! empty($data['from_library'])) {
            $data['items'] = Faq::query()->published()->get()->map(fn (Faq $faq) => [
                'question' => $faq->question,
                'answer' => $faq->answer,
            ])->all();
        }

        return $data;
    }
}
