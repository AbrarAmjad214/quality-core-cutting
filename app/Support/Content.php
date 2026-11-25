<?php

namespace App\Support;

/**
 * Loads the content files in resources/data (plain PHP arrays).
 */
class Content
{
    private static array $cache = [];

    public static function get(string $file): array
    {
        return self::$cache[$file] ??= require resource_path("data/{$file}.php");
    }

    /** All services, keyed by slug, in menu order. */
    public static function services(): array
    {
        return self::get('services');
    }

    public static function service(string $slug): ?array
    {
        return self::services()[$slug] ?? null;
    }

    /** Other services to link to from a service page. */
    public static function related(string $slug, int $count = 3): array
    {
        $all = self::services();
        $keys = array_keys($all);
        $i = array_search($slug, $keys, true);
        $out = [];
        for ($n = 1; count($out) < $count && $n < count($keys); $n++) {
            $out[] = $all[$keys[($i + $n) % count($keys)]];
        }

        return $out;
    }

    public static function image(string $name): ?array
    {
        return self::get('images')[$name] ?? null;
    }

    /** City landing pages, keyed by city key (dubai, abu-dhabi, sharjah). */
    public static function locations(): array
    {
        return self::get('locations');
    }

    public static function location(string $key): ?array
    {
        return self::locations()[$key] ?? null;
    }

    public static function company(): array
    {
        return self::get('company');
    }
}
