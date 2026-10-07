<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiAnnouncementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider or bootstrap/app.php
| and assigned to the "api" middleware group (prefixed with /api).
|
*/

// Health Check Endpoint (GET /api/health)
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
    ]);
});

/* -------------------------------------------------------------------------- */
/*                  API User CRUD Routes -> ApiUserController                 */
/* -------------------------------------------------------------------------- */
Route::get('/users', [ApiUserController::class, 'index']);
Route::post('/users', [ApiUserController::class, 'store']);
Route::get('/users/{id}', [ApiUserController::class, 'show']);
Route::put('/users/{id}', [ApiUserController::class, 'update']);
Route::patch('/users/{id}', [ApiUserController::class, 'update']);
Route::delete('/users/{id}', [ApiUserController::class, 'destroy']);
Route::post('/users/reset', [ApiUserController::class, 'reset']);

/* -------------------------------------------------------------------------- */
/*          API Announcement CRUD Routes -> ApiAnnouncementController         */
/* -------------------------------------------------------------------------- */
Route::get('/announcements', [ApiAnnouncementController::class, 'index']);
Route::post('/announcements', [ApiAnnouncementController::class, 'store']);
Route::get('/announcements/{id}', [ApiAnnouncementController::class, 'show']);
Route::put('/announcements/{id}', [ApiAnnouncementController::class, 'update']);
Route::patch('/announcements/{id}', [ApiAnnouncementController::class, 'update']);
Route::delete('/announcements/{id}', [ApiAnnouncementController::class, 'destroy']);
Route::post('/announcements/reset', [ApiAnnouncementController::class, 'reset']);
