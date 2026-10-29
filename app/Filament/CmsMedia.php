<?php

namespace App\Filament;

use App\Filament\Forms\CmsFileUpload;

class CmsMedia
{
    public static function image(string $name, string $label = 'Image'): CmsFileUpload
    {
        return self::upload($name, $label)
            ->image()
            ->imagePreviewHeight('140')
            ->acceptedFileTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'image/svg+xml',
            ]);
    }

    public static function video(string $name, string $label = 'Video'): CmsFileUpload
    {
        return self::upload($name, $label, 'uploads/videos')
            ->acceptedFileTypes([
                'video/mp4',
                'video/webm',
                'video/quicktime',
            ])
            ->maxSize(51200)
            ->helperText('Upload an MP4, or keep the current brand video.');
    }

    public static function file(string $name, string $label = 'File'): CmsFileUpload
    {
        return self::upload($name, $label);
    }

    public static function upload(string $name, string $label, string $directory = 'uploads'): CmsFileUpload
    {
        return CmsFileUpload::make($name)
            ->label($label)
            ->disk('public_web')
            ->directory($directory)
            ->visibility('public')
            ->downloadable()
            ->openable()
            ->maxSize(12288)
            ->helperText('Upload a file here. Current brand assets stay until you replace them.');
    }
}
