<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\SiteSetting;
use App\View\Compilers\BladeCompiler;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\DynamicComponent;
use Livewire\Mechanisms\FrontendAssets\FrontendAssets;
use Livewire\Mechanisms\HandleRequests\EndpointResolver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('blade.compiler', function ($app) {
            return tap(new BladeCompiler(
                $app['files'],
                $app['config']['view.compiled'],
                $app['config']->get('view.relative_hash', false) ? $app->basePath() : '',
                $app['config']->get('view.cache', true),
                $app['config']->get('view.compiled_extension', 'php'),
                $app['config']->get('view.check_cache_timestamps', true),
            ), function (BladeCompiler $blade): void {
                $blade->component('dynamic-component', DynamicComponent::class);
            });
        });

        $this->app->forgetInstance('blade.compiler');
    }

    public function boot(): void
    {
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        $this->ensureLivewireScriptRoutes();
        $this->embedMailLogo();

        View::composer('layouts.public', function ($view): void {
            $view->with('site', Schema::hasTable('site_settings') ? SiteSetting::current() : null);
            $view->with('headerMenu', Schema::hasTable('menus') ? Menu::location('header') : []);
            $view->with('footerMenu', Schema::hasTable('menus') ? Menu::location('footer') : []);
            $view->with('legalMenu', Schema::hasTable('menus') ? Menu::location('legal') : []);
        });
    }

    /**
     * The mail header may reference the logo as cid:logo.png, so attach it to
     * the message itself. A URL would break wherever APP_URL is not publicly
     * reachable (local dev, Mailtrap) and in clients that block remote images.
     */
    private function embedMailLogo(): void
    {
        Event::listen(function (MessageSending $event): void {
            if (str_contains((string) $event->message->getHtmlBody(), 'cid:logo.png')) {
                $event->message->embedFromPath(public_path('brand/images/logo.png'), 'logo.png', 'image/png');
            }
        });
    }

    /**
     * Livewire 4 registers only livewire.js or livewire.min.js based on APP_DEBUG.
     * Production HTML requests the minified file; if that route is missing the
     * script 404s and forms fall back to a GET submit that reloads with "?".
     */
    private function ensureLivewireScriptRoutes(): void
    {
        $registered = [];

        foreach (Route::getRoutes() as $route) {
            if (in_array('GET', $route->methods(), true)) {
                $registered['/'.ltrim($route->uri(), '/')] = true;
            }
        }

        foreach ([true, false] as $minified) {
            $path = EndpointResolver::scriptPath(minified: $minified);
            $key = '/'.ltrim($path, '/');

            if (isset($registered[$key])) {
                continue;
            }

            Route::get($path, [FrontendAssets::class, 'returnJavaScriptAsFile']);
        }
    }
}
