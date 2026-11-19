<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(
    basePath: dirname(__DIR__)
)

    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        // Railway (và các nền tảng PaaS) đặt app sau reverse proxy: tin header X-Forwarded-*
        // để Laravel lấy đúng IP thật (cho rate limit) và scheme https (cho URL, form).
        $middleware->trustProxies(at: '*');

        $middleware->alias([

            /*
            |--------------------------------------------------------------------------
            | HOST MIDDLEWARE
            |--------------------------------------------------------------------------
            */

            'host' => \App\Http\Middleware\EnsureUserIsHost::class,

            /*
            |--------------------------------------------------------------------------
            | GUEST ROLE MIDDLEWARE
            |--------------------------------------------------------------------------
            */

            'guest.role' => \App\Http\Middleware\GuestMiddleware::class,

            'guest.user' => \App\Http\Middleware\EnsureUserIsGuest::class,

        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {

        //
    })

    ->create();