<?php

namespace App\View\Compilers;

use ErrorException;
use Illuminate\View\Compilers\BladeCompiler as BaseBladeCompiler;

class BladeCompiler extends BaseBladeCompiler
{
    /**
     * Compile the view at the given path.
     *
     * Laravel updates the compiled view mtime with touch() when the output hash
     * is unchanged. That fails when Apache (nobody) does not own files created
     * by Artisan (root), so recreate the compiled view as the current user.
     */
    public function compile($path = null): void
    {
        try {
            parent::compile($path);
        } catch (ErrorException $exception) {
            if (! str_contains($exception->getMessage(), 'Utime failed')) {
                throw $exception;
            }

            $compiledPath = $this->getCompiledPath($this->getPath());

            if (! $this->files->exists($compiledPath) || ! $this->files->delete($compiledPath)) {
                throw $exception;
            }

            parent::compile($path);
        }
    }
}
