<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * 301 for old WordPress URLs. The target comes from the route default:
 *
 *   Route::get('/feed', LegacyRedirectController::class)->defaults('to', '/');
 *
 * Invokable controller (not closures) so `php artisan route:cache` works.
 */
class LegacyRedirectController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $to = $request->route()->defaults['to'] ?? '/';

        return new RedirectResponse($request->getSchemeAndHttpHost() . $request->getBaseUrl() . $to, 301);
    }
}
