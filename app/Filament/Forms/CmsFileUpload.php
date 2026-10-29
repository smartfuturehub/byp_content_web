<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Arr;

class CmsFileUpload extends FileUpload
{
    public function hydrateFiles(): void
    {
        $normalized = [];

        foreach (Arr::wrap($this->getRawState()) as $key => $file) {
            if (is_string($file) && $this->isLocalMediaPath($file)) {
                $file = ltrim($file, '/');
            }

            $normalized[$key] = $file;
        }

        $this->rawState($normalized);

        parent::hydrateFiles();
    }

    protected function isLocalMediaPath(string $file): bool
    {
        return ! str_starts_with($file, 'http://')
            && ! str_starts_with($file, 'https://')
            && ! str_starts_with($file, '//')
            && ! str_starts_with($file, 'data:');
    }
}
