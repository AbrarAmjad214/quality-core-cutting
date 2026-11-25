<?php

namespace App\Providers;

use App\Routing\TrailingSlashUrlGenerator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Swap Laravel's URL generator for one that adds trailing slashes to page URLs.
        // Runs after the framework's own extend(), so we copy its resolvers across.
        $this->app->extend('url', function (UrlGenerator $url, $app) {
            $generator = new TrailingSlashUrlGenerator(
                $app['router']->getRoutes(),
                $url->getRequest(),
                $app['config']['app.asset_url']
            );
            $generator->setSessionResolver(fn () => $app['session'] ?? null);
            $generator->setKeyResolver(function () use ($app) {
                $config = $app->make('config');

                return [$config->get('app.key'), ...($config->get('app.previous_keys') ?? [])];
            });

            return $generator;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
