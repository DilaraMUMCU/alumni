<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\LoggerMiddleware;
use App\Http\Middleware\Guardian404Middleware;
use App\Http\Middleware\Guardian5xxMiddleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
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

        // 2. 5xx Guardian Middleware (intercepts and guards against 5xx server errors)
        $middleware->append(Guardian5xxMiddleware::class);

        // 3. 404 Guardian Middleware (intercepts and guards against 404 not found errors)
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
        // Ensure uncaught NotFoundHttpException is caught by 404 Guardian
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            $reason = $e->getMessage() ?: "The requested route '{$request->method()} /" . ltrim($request->path(), '/') . "' does not exist on this system.";
            return Guardian404Middleware::render404($request, $reason);
        });

        // Ensure uncaught 5xx Server Errors & Throwables are caught by 5xx Guardian
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($e instanceof NotFoundHttpException || ($e instanceof HttpExceptionInterface && $e->getStatusCode() < 500)) {
                return null; // Let 404 Guardian or client HTTP error handlers process 4xx errors
            }

            $statusCode = ($e instanceof HttpExceptionInterface) ? $e->getStatusCode() : 500;
            $guardian = new Guardian5xxMiddleware();
            $reason = $guardian->resolveExceptionReason($e);

            return Guardian5xxMiddleware::render5xx($request, $reason, $statusCode, $e);
        });
    })->create();
