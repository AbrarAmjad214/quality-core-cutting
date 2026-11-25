<?php

namespace App\Routing;

use Illuminate\Routing\UrlGenerator;

/**
 * Generates every page URL with a trailing slash (https://example.com/about-us/),
 * so route(), url(), url()->current() (canonical) and the sitemap all match the
 * URLs the AddTrailingSlash middleware enforces — no redirect hop on internal links.
 *
 * File-like paths (/sitemap.xml, /robots.txt) are left alone, and asset() is not
 * affected because it does not go through format().
 */
class TrailingSlashUrlGenerator extends UrlGenerator
{
    public function format($root, $path, $route = null)
    {
        $url = parent::format($root, $path, $route);   // parent trims the trailing "/"

        $path = '/' . trim($path, '/');
        if (preg_match('/\.[a-z0-9]{2,5}$/i', $path) || $path === '/up') {
            return $url;
        }

        return $url . '/';
    }
}
