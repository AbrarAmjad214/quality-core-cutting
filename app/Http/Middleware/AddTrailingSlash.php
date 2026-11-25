<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LegacyRedirectController;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Canonical URLs end with a slash: /about-us/ (web routes, GET/HEAD only).
 *
 *  - /index.php/some/path  → 301 /some/path/
 *  - /some/path            → 301 /some/path/
 *  - skipped: "/", file-like paths (/sitemap.xml), /up, legacy-redirect routes
 *
 * Redirects are built with RedirectResponse directly: redirect()/url() would
 * normalise the URL and drop the trailing slash. The query string is kept.
 */
class AddTrailingSlash
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->getMethod(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        // Old WordPress URLs redirect straight to their new home in one hop.
        $route = $request->route();
        if ($route && $route->getControllerClass() === LegacyRedirectController::class) {
            return $next($request);
        }

        // raw query string, exactly as sent (getQueryString() would re-order the parameters)
        $query = (string) $request->server->get('QUERY_STRING', '');
        $query = $query !== '' ? '?' . $query : '';
        $path = $request->getPathInfo();

        // /index.php/about → /about/
        $base = $request->getBaseUrl();
        if (str_ends_with($base, '/index.php')) {
            $target = $this->withSlash($path);

            return new RedirectResponse($request->getSchemeAndHttpHost() . substr($base, 0, -10) . $target . $query, 301);
        }

        if ($path === '/' || $path === '/up' || str_ends_with($path, '/') || preg_match('/\.[a-z0-9]{2,5}$/i', $path)) {
            return $next($request);
        }

        return new RedirectResponse($request->getSchemeAndHttpHost() . $base . $path . '/' . $query, 301);
    }

    private function withSlash(string $path): string
    {
        $path = '/' . trim($path, '/');
        if ($path === '/' || preg_match('/\.[a-z0-9]{2,5}$/i', $path)) {
            return $path;
        }

        return $path . '/';
    }
}
