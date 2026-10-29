<?php

namespace App\Support;

use Illuminate\Mail\Message;
use Throwable;
use WeakMap;

class MailLogo
{
    public const RELATIVE_PATH = 'brand/images/logo.png';

    /**
     * @var WeakMap<Message, string>|null
     */
    private static ?WeakMap $embedded = null;

    public static function src(?object $message = null): string
    {
        $path = self::path();
        $fallback = self::dataUri() ?? self::publicUrl();

        if (! $message instanceof Message || ! is_file($path)) {
            return $fallback;
        }

        $embedded = self::embedded();

        if (isset($embedded[$message])) {
            return $embedded[$message];
        }

        foreach ($message->getSymfonyMessage()->getAttachments() as $attachment) {
            if ($attachment->getName() === 'byp-health-logo.png' && filled($attachment->getContentId())) {
                return $embedded[$message] = 'cid:'.$attachment->getContentId();
            }
        }

        $contents = file_get_contents($path);

        if ($contents === false || $contents === '') {
            return $fallback;
        }

        try {
            return $embedded[$message] = $message->embedData($contents, 'byp-health-logo.png', 'image/png');
        } catch (Throwable $exception) {
            report($exception);

            return $fallback;
        }
    }

    public static function publicUrl(): string
    {
        $base = rtrim((string) config('app.url'), '/');
        $url = $base.'/'.self::RELATIVE_PATH;

        if (app()->isProduction() && str_starts_with($url, 'http://')) {
            $url = 'https://'.substr($url, strlen('http://'));
        }

        return $url;
    }

    public static function path(): string
    {
        return public_path(self::RELATIVE_PATH);
    }

    public static function dataUri(): ?string
    {
        $path = self::path();

        if (! is_file($path)) {
            return null;
        }

        $contents = file_get_contents($path);

        if ($contents === false || $contents === '') {
            return null;
        }

        return 'data:image/png;base64,'.base64_encode($contents);
    }

    /**
     * @return WeakMap<Message, string>
     */
    private static function embedded(): WeakMap
    {
        return self::$embedded ??= new WeakMap;
    }
}
