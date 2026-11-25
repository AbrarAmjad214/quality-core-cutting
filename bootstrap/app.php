<?php

use App\Http\Middleware\AddTrailingSlash;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Canonical URLs end with "/" (web routes only; API/MCP routes are untouched).
        $middleware->prependToGroup('web', AddTrailingSlash::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
