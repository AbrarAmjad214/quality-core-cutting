<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\LegacyRedirectController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

/*
| Pages — the URLs match the old WordPress site so rankings are kept.
| Canonical form has a trailing slash (/about-us/): the AddTrailingSlash
| middleware 301s /about-us → /about-us/, and App\Routing\TrailingSlashUrlGenerator
| makes route()/url() produce the slashed form.
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/our-services', [PageController::class, 'services'])->name('services');
Route::get('/our-projects', [PageController::class, 'projects'])->name('projects');
Route::get('/contact-us', [PageController::class, 'contact'])->name('contact');
Route::get('/service/{slug}', [ServiceController::class, 'show'])->name('service.show');

// City landing pages (local SEO): /core-cutting-dubai/, /core-cutting-abu-dhabi/, /core-cutting-sharjah/
Route::get('/core-cutting-{city}', [LocationController::class, 'show'])
    ->whereIn('city', ['dubai', 'abu-dhabi', 'sharjah'])
    ->name('location.show');

Route::post('/contact-us', [ContactController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('contact.store');

// SEO files
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots']);

/*
|--------------------------------------------------------------------------
| 301s for old WordPress URLs
|--------------------------------------------------------------------------
| One hop, straight to the final (trailing-slash) URL. Invokable controller +
| ->defaults('to', ...) instead of closures, so `php artisan route:cache` works.
*/
$legacy = [
    // removed pages
    '/our-team' => '/about-us/',
    '/team-details/{any?}' => '/about-us/',
    '/services' => '/our-services/',
    '/our-services/page/{any?}' => '/our-services/',
    '/home' => '/',
    '/portfolio/{any?}' => '/our-projects/',
    '/pxl-template/{any?}' => '/',
    '/author/{any?}' => '/about-us/',
    // old short service URLs
    '/core-cutting' => '/service/core-cutting/',
    '/wall-saw-cutting' => '/service/wall-saw-cutting/',
    '/wire-saw-cutting' => '/service/wire-saw-cutting/',
    '/floor-saw-cutting' => '/service/floor-saw-cutting/',
    '/concrete-scanning' => '/service/concrete-scanning/',
    // WordPress system URLs
    '/feed/{any?}' => '/',
    '/comments/feed/{any?}' => '/',
    '/blog/{any?}' => '/',
    '/category/{any?}' => '/',
    '/tag/{any?}' => '/',
    '/wp-sitemap.xml' => '/sitemap.xml',
    '/wp-sitemap-{any}.xml' => '/sitemap.xml',
    '/sitemap_index.xml' => '/sitemap.xml',
];
foreach ($legacy as $uri => $to) {
    Route::get($uri, LegacyRedirectController::class)->where('any', '.*')->defaults('to', $to);
}

// Old upload images (incl. WordPress size variants like -300x213) → the new optimised WebP.
$oldImages = [
    'WhatsApp-Image-2026-03-26-at-6.54.18-PM-1' => 'core-drilling-wall-1200',
    'WhatsApp-Image-2026-03-26-at-6.54.18-PM-2' => 'core-drilling-floor-1200',
    'WhatsApp-Image-2026-03-26-at-6.54.18-PM' => 'gpr-scan-results-640',
    'WhatsApp-Image-2026-03-26-at-6.54.17-PM-1' => 'gpr-floor-scanning-620',
    'WhatsApp-Image-2026-03-26-at-6.54.17-PM-2' => 'concrete-scanning-column-1200',
    'WhatsApp-Image-2026-03-26-at-6.54.17-PM-3' => 'concrete-scanning-tablet-971',
    'WhatsApp-Image-2026-03-26-at-6.54.17-PM' => 'concrete-scanning-wall-641',
    'WhatsApp-Image-2026-03-26-at-6.36.08-PM-1' => 'core-cutting-pipe-opening-800',
    'WhatsApp-Image-2026-03-26-at-6.36.08-PM' => 'wall-saw-cutting-indoor-600',
    'conncrete-slab-wall-cutting' => 'wall-saw-cutting-slab-960',
    'wall-saw-cutting' => 'wall-saw-blade-on-site-720',
    'Screenshot_2016-08-02-12-13-48' => 'wire-saw-cutting-site-1200',
    'vlcsnap-2025-02-01-19h32m58s984' => 'floor-saw-cutting-car-park-1080',
];
foreach ($oldImages as $stem => $new) {
    Route::get("/wp-content/uploads/{year}/{month}/{$stem}{variant}", LegacyRedirectController::class)
        ->where(['year' => '\d{4}', 'month' => '\d{2}', 'variant' => '(-\d+x\d+)?\.(jpe?g|png|webp)'])
        ->defaults('to', "/assets/images/{$new}.webp");
}
// Anything else under /wp-content or /wp-includes (themes, plugins, other uploads)
Route::get('/wp-content/{any}', LegacyRedirectController::class)->where('any', '.*')->defaults('to', '/our-projects/');
Route::get('/wp-includes/{any}', LegacyRedirectController::class)->where('any', '.*')->defaults('to', '/');
