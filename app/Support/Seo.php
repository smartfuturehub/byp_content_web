<?php

namespace App\Support;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Collection;

class Seo
{
    public static function jsonLd(array $graph): string
    {
        return json_encode([
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function organization(): array
    {
        return [
            '@type' => ['Organization', 'MedicalOrganization'],
            '@id' => url('/').'#organization',
            'name' => setting('site_name', 'BYP Health'),
            'url' => url('/'),
            'logo' => media_url(setting('logo', '/brand/images/logo.png')),
            'email' => setting('email', 'sales@byphealthtek.com'),
            'telephone' => setting('phone_ae') ?: setting('phone_sg', '+65 8836 0984'),
            'areaServed' => [
                '@type' => 'Place',
                'name' => 'Worldwide',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'sales',
                'email' => setting('email', 'sales@byphealthtek.com'),
                'areaServed' => 'Worldwide',
                'availableLanguage' => 'English',
            ],
            'sameAs' => array_values(array_filter([
                setting('twitter_url'),
                setting('linkedin_url'),
            ])),
            'address' => array_values(array_filter([
                setting('address_ae') ? [
                    '@type' => 'PostalAddress',
                    'streetAddress' => setting('address_ae'),
                    'addressCountry' => 'AE',
                ] : null,
                [
                    '@type' => 'PostalAddress',
                    'streetAddress' => '246 Macpherson Road, #03-01 Betime Building',
                    'addressLocality' => 'Singapore',
                    'postalCode' => '348578',
                    'addressCountry' => 'SG',
                ],
                [
                    '@type' => 'PostalAddress',
                    'streetAddress' => '651 N Broad St, Suite 201',
                    'addressLocality' => 'Middletown',
                    'addressRegion' => 'Delaware',
                    'postalCode' => '19709',
                    'addressCountry' => 'US',
                ],
            ])),
        ];
    }

    public static function website(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => url('/').'#website',
            'url' => url('/'),
            'name' => setting('site_name', 'BYP Health'),
            'publisher' => ['@id' => url('/').'#organization'],
        ];
    }

    public static function breadcrumbs(array $crumbs): array
    {
        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($crumbs)->values()->map(fn ($crumb, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $crumb['name'],
                'item' => $crumb['url'],
            ])->all(),
        ];
    }

    public static function article(Post $post): array
    {
        return [
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => $post->excerpt,
            'image' => $post->featured_image ? media_url($post->featured_image) : null,
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => $post->updated_at?->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->displayAuthor(),
            ],
            'publisher' => ['@id' => url('/').'#organization'],
            'mainEntityOfPage' => $post->url(),
        ];
    }

    /**
     * @param  Collection<int, array{question?: string, answer?: string}|object>  $faqs
     * @return array<string, mixed>
     */
    public static function faqPage(Collection $faqs): array
    {
        return [
            '@type' => 'FAQPage',
            'mainEntity' => $faqs->map(function (array|object $faq): array {
                $question = is_array($faq) ? ($faq['question'] ?? '') : $faq->question;
                $answer = is_array($faq) ? ($faq['answer'] ?? '') : $faq->answer;

                return [
                    '@type' => 'Question',
                    'name' => $question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => strip_tags((string) $answer),
                    ],
                ];
            })->all(),
        ];
    }

    public static function webPage(Page $page): array
    {
        return [
            '@type' => $page->schema_type ?: 'WebPage',
            'name' => $page->seoTitle(),
            'description' => $page->seoDescription(),
            'url' => $page->url(),
            'image' => media_url($page->socialImage()),
            'isPartOf' => ['@id' => url('/').'#website'],
        ];
    }

    public static function twitterHandle(): ?string
    {
        $url = trim((string) setting('twitter_url', ''));

        if ($url === '') {
            return null;
        }

        if (str_starts_with($url, '@')) {
            return $url;
        }

        $path = trim((string) parse_url($url, PHP_URL_PATH), '/');
        $handle = explode('/', $path)[0] ?? '';

        return $handle !== '' ? '@'.$handle : null;
    }

    public static function robots(string $robots = 'index,follow'): string
    {
        $robots = trim($robots) !== '' ? trim($robots) : 'index,follow';

        if (! str_contains($robots, 'max-image-preview')) {
            $robots .= ',max-image-preview:large';
        }

        return $robots;
    }
}
