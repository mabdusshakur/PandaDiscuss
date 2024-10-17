<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);

        /*
        It is important to exclude the broadcasting/auth route from CSRF token validation
        because it is used by Laravel Echo Server to authenticate users
        */
        $middleware->validateCsrfTokens(except: [
            '/broadcasting/auth',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();