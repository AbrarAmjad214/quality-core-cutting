<?php

if (! function_exists('asset_v')) {
    /**
     * asset() with a ?v=filemtime cache-buster, so browsers can cache
     * CSS/JS for a long time and still get changes straight away.
     */
    function asset_v(string $path): string
    {
        $file = public_path($path);

        return asset($path) . (is_file($file) ? '?v=' . filemtime($file) : '');
    }
}

if (! function_exists('tel_link')) {
    function tel_link(): string
    {
        return 'tel:' . config('site.phone_raw');
    }
}

if (! function_exists('whatsapp_link')) {
    function whatsapp_link(string $text = 'Hello, I would like a quote for concrete cutting work.'): string
    {
        return 'https://wa.me/' . config('site.whatsapp') . '?text=' . rawurlencode($text);
    }
}
