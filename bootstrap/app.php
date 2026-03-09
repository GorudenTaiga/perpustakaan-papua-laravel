<?php

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\CacheHeaders;
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
        // Trust all proxies for Render.com
        $middleware->trustProxies(at: '*');

        // Add Cache-Control headers for public pages
        $middleware->append(CacheHeaders::class);

        $middleware->alias([
            'auth' => AuthMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();