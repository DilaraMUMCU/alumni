<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiUserController;
use App\Http\SwaggerSpec;

// 1. & 5. Adım: Base URL (/) -> Temporary Main Page
Route::get('/', function () {
    return view('welcome');
});

// 2. Adım: Sabit hello rotası
Route::get('/hello', function () {
    return 'Hello, world!';
});

// 3. Adım: Dinamik isim parametreli hello rotası
Route::get('/hello/{name}', function ($name) {
    return 'Hello, ' . ucfirst($name) . '!';
});

// 4. Adım: İki sayıyı toplayan dinamik sum rotası
Route::get('/sum/{number1}/{number2}', function ($number1, $number2) {
    return (string) ($number1 + $number2);
});

// 6. Adım: Temporary About Page
Route::get('/about', function () {
    return view('about');
});

// 7. Adım: JSON Health Check rotası
Route::get('/api/health', function () {
    return response()->json([
        'status' => 'ok',
    ]);
});

/* -------------------------------------------------------------------------- */
/*                 API User Routes (ApiUserController - JSON CRUD)            */
/* -------------------------------------------------------------------------- */
Route::get('/api/users', [ApiUserController::class, 'index']);
Route::post('/api/users', [ApiUserController::class, 'store']);
Route::get('/api/users/{id}', [ApiUserController::class, 'show']);
Route::put('/api/users/{id}', [ApiUserController::class, 'update']);
Route::patch('/api/users/{id}', [ApiUserController::class, 'update']);
Route::delete('/api/users/{id}', [ApiUserController::class, 'destroy']);
Route::post('/api/users/reset', [ApiUserController::class, 'reset']);

/* -------------------------------------------------------------------------- */
/*                 Web User Routes (UserController - Web CRUD)                */
/* -------------------------------------------------------------------------- */
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/create', [UserController::class, 'create']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/{id}/edit', [UserController::class, 'edit']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

/* -------------------------------------------------------------------------- */
/*                       Swagger / OpenAPI Dokümantasyonu                     */
/* -------------------------------------------------------------------------- */
// 13. Adım: GET /api/swagger.json (Saf OpenAPI 3.0 JSON Spesifikasyonu)
Route::get('/api/swagger.json', function () {
    return response()->json(SwaggerSpec::get(), 200, [
        'Content-Type' => 'application/json; charset=utf-8'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
});

// 14. Adım: GET /api/swagger (Tarayıcıda Swagger UI, Postman ve API istemcilerinde OpenAPI JSON)
Route::get('/api/swagger', function (Request $request) {
    $format = $request->query('format');
    $accept = $request->header('Accept', '');

    // Tarayıcı istekleri 'text/html' içerir.
    // Postman ve API araçları ise default olarak '*/*' veya 'application/json' gönderir.
    $isBrowser = str_contains($accept, 'text/html') && $format !== 'json';

    if ($format === 'html' || $isBrowser) {
        return view('swagger', ['spec' => SwaggerSpec::get()]);
    }

    return response()->json(SwaggerSpec::get(), 200, [
        'Content-Type' => 'application/json; charset=utf-8'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
});