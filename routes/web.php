<?php

use App\Http\Controllers\Site\BlogController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\SitemapController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ar', 302);

Route::prefix('{locale}')
    ->whereIn('locale', ['ar', 'en'])
    ->middleware(SetLocale::class)
    ->group(function (): void {
        Route::get('/', HomeController::class)->name('home');
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/{article}', [BlogController::class, 'show'])->name('blog.show');
        Route::post('/contact', [ContactController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('contact.store');
    });

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::get('/robots.txt', function () {
    $settings = \App\Models\Setting::findOrNew();

    $lines = $settings->seo_robots_index
        ? ['User-agent: *', 'Disallow: /admin', 'Allow: /']
        : ['User-agent: *', 'Disallow: /'];

    $lines[] = '';
    $lines[] = 'Sitemap: ' . route('sitemap');

    return response(implode(PHP_EOL, $lines), 200)->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('robots');
