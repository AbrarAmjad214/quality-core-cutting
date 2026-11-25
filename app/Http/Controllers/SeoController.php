<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /** XML sitemap with image entries (helps the photos show in Google Images). */
    public function sitemap(): Response
    {
        $img = function (string $name): array {
            $meta = Content::image($name);

            return ['loc' => asset("assets/images/{$name}-" . end($meta['sizes']) . '.webp'), 'title' => $meta['alt']];
        };
        $viewTime = fn (string $view) => @filemtime(resource_path("views/{$view}.blade.php")) ?: time();
        $dataTime = fn (string $file) => @filemtime(resource_path("data/{$file}.php")) ?: time();

        $pages = [
            ['url' => route('home'), 'time' => max($viewTime('pages/home'), $dataTime('company')), 'priority' => '1.0', 'images' => [$img('core-drilling-wall'), $img('wall-saw-blade-on-site'), $img('concrete-scanning-column')]],
            ['url' => route('services'), 'time' => $viewTime('pages/services'), 'priority' => '0.9', 'images' => [$img('core-drilling-floor')]],
        ];
        foreach (Content::locations() as $key => $l) {
            $pages[] = ['url' => route('location.show', $key), 'time' => max($viewTime('locations/show'), $dataTime('locations')), 'priority' => '0.9', 'images' => [$img($l['image'])]];
        }
        foreach (Content::services() as $s) {
            $pages[] = ['url' => route('service.show', $s['slug']), 'time' => max($viewTime('services/show'), $dataTime('services')), 'priority' => '0.8', 'images' => [$img($s['image'])]];
        }
        $pages[] = ['url' => route('about'), 'time' => $viewTime('pages/about'), 'priority' => '0.6', 'images' => [$img('wall-saw-cutting-indoor')]];
        $pages[] = ['url' => route('projects'), 'time' => $viewTime('pages/projects'), 'priority' => '0.6', 'images' => [$img('wire-saw-cutting-site'), $img('floor-saw-cutting-car-park')]];
        $pages[] = ['url' => route('contact'), 'time' => $viewTime('pages/contact'), 'priority' => '0.7', 'images' => []];

        foreach ($pages as &$p) {
            $p['lastmod'] = date('Y-m-d', $p['time']);
        }

        return response()->view('seo.sitemap', ['pages' => $pages])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $lines = app()->environment('production')
            ? ['User-agent: *', 'Disallow:', '', 'Sitemap: ' . route('sitemap')]
            : ['User-agent: *', 'Disallow: /', '', '# Not production: crawling disabled (APP_ENV=' . app()->environment() . ')'];

        return response(implode("\n", $lines) . "\n", 200)->header('Content-Type', 'text/plain');
    }
}
