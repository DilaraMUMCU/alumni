<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\LoggerMiddleware;
use App\Http\Middleware\Guardian404Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 1. Logger Middleware (runs first on all requests to log to terminal)
        $middleware->prepend(LoggerMiddleware::class);

        // 2. 404 Guardian Middleware (intercepts and returns 404 errors with reasons)
        $middleware->append(Guardian404Middleware::class);

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
        // Ensure any uncaught NotFoundHttpException is also caught by 404 Guardian
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            $reason = $e->getMessage() ?: "The requested route '{$request->method()} /" . ltrim($request->path(), '/') . "' does not exist on this system.";
            return Guardian404Middleware::render404($request, $reason);
        });
    })->create();
