<?php

use App\Http\Controllers\AnalyticsCollectController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::post('/analytics/collect', [AnalyticsCollectController::class, 'store'])
    ->middleware('throttle:60,1')
    ->name('analytics.collect');
Route::redirect('/newsletter', '/blog', 301);
Route::redirect('/newsletter/{slug}', '/blog/{slug}', 301);
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/search', [SeoController::class, 'search'])->name('search');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '^(?!admin|livewire|storage).+')->name('page.show');
