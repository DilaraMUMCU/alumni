<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\LoggerMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Run first on all requests to log to terminal
        $middleware->prepend(LoggerMiddleware::class);

        $middleware->validateCsrfTokens(except: [
            'api/*',
            'users',
            'users/*',
            'announcements',
            'announcements/*',
            'job-postings',
            'job-postings/*',
            'applications',
            'applications/*',
            'events',
            'events/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
