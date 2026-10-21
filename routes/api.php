<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiAnnouncementController;
use App\Http\Controllers\ApiJobPostingController;
use App\Http\Controllers\ApiApplicationController;
use App\Models\Event;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by bootstrap/app.php and prefixed with /api.
|
*/

// Health Check Endpoint (GET /api/health)
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
    ]);
});

/* ========================================================================== */
/*                                DIRECT ROUTES                               */
/* ========================================================================== */

/* -------------------------------------------------------------------------- */
/*  1. Direct User Routes (ApiUserController)                                 */
/* -------------------------------------------------------------------------- */
Route::get('/users', [ApiUserController::class, 'index'])->name('api.users.index');
Route::post('/users', [ApiUserController::class, 'store'])->name('api.users.store');
Route::get('/users/{id}', [ApiUserController::class, 'show'])->name('api.users.show');
Route::put('/users/{id}', [ApiUserController::class, 'update'])->name('api.users.update');
Route::patch('/users/{id}', [ApiUserController::class, 'update'])->name('api.users.patch');
Route::delete('/users/{id}', [ApiUserController::class, 'destroy'])->name('api.users.destroy');
Route::post('/users/reset', [ApiUserController::class, 'reset'])->name('api.users.reset');

/* -------------------------------------------------------------------------- */
/*  2. Direct Announcement Routes (ApiAnnouncementController)                 */
/* -------------------------------------------------------------------------- */
Route::get('/announcements', [ApiAnnouncementController::class, 'index'])->name('api.announcements.index');
Route::post('/announcements', [ApiAnnouncementController::class, 'store'])->name('api.announcements.store');
Route::get('/announcements/{id}', [ApiAnnouncementController::class, 'show'])->name('api.announcements.show');
Route::put('/announcements/{id}', [ApiAnnouncementController::class, 'update'])->name('api.announcements.update');
Route::patch('/announcements/{id}', [ApiAnnouncementController::class, 'update'])->name('api.announcements.patch');
Route::delete('/announcements/{id}', [ApiAnnouncementController::class, 'destroy'])->name('api.announcements.destroy');
Route::post('/announcements/reset', [ApiAnnouncementController::class, 'reset'])->name('api.announcements.reset');

/* -------------------------------------------------------------------------- */
/*  3. Direct Job Posting Routes (ApiJobPostingController)                    */
/* -------------------------------------------------------------------------- */
Route::get('/job-postings', [ApiJobPostingController::class, 'index'])->name('api.job-postings.index');
Route::post('/job-postings', [ApiJobPostingController::class, 'store'])->name('api.job-postings.store');
Route::get('/job-postings/{id}', [ApiJobPostingController::class, 'show'])->name('api.job-postings.show');
Route::put('/job-postings/{id}', [ApiJobPostingController::class, 'update'])->name('api.job-postings.update');
Route::patch('/job-postings/{id}', [ApiJobPostingController::class, 'update'])->name('api.job-postings.patch');
Route::delete('/job-postings/{id}', [ApiJobPostingController::class, 'destroy'])->name('api.job-postings.destroy');

/* -------------------------------------------------------------------------- */
/*  4. Direct Application Routes (ApiApplicationController)                   */
/* -------------------------------------------------------------------------- */
Route::get('/applications', [ApiApplicationController::class, 'index'])->name('api.applications.index');
Route::post('/applications', [ApiApplicationController::class, 'store'])->name('api.applications.store');
Route::get('/applications/{id}', [ApiApplicationController::class, 'show'])->name('api.applications.show');
Route::put('/applications/{id}', [ApiApplicationController::class, 'update'])->name('api.applications.update');
Route::patch('/applications/{id}', [ApiApplicationController::class, 'update'])->name('api.applications.patch');
Route::delete('/applications/{id}', [ApiApplicationController::class, 'destroy'])->name('api.applications.destroy');

/* ========================================================================== */
/*                                NESTED ROUTES                               */
/* ========================================================================== */

/* -------------------------------------------------------------------------- */
/*  A. Nested: JobPosting -> Applications (Applications under a Job)           */
/* -------------------------------------------------------------------------- */
Route::prefix('/job-postings/{job_posting}')->group(function () {
    // List all applications received for this job posting
    Route::get('/applications', [ApiApplicationController::class, 'byJobPosting'])->name('api.job-postings.applications.index');
    // Submit an application specifically to this job posting
    Route::post('/applications', [ApiApplicationController::class, 'storeForJobPosting'])->name('api.job-postings.applications.store');
    // View a specific candidate application under this job posting
    Route::get('/applications/{application}', [ApiApplicationController::class, 'showNested'])->name('api.job-postings.applications.show');
    // Update candidate hiring/review status (e.g. pending -> reviewing -> accepted)
    Route::patch('/applications/{application}/status', [ApiApplicationController::class, 'updateStatus'])->name('api.job-postings.applications.status');
});

/* -------------------------------------------------------------------------- */
/*  B. Nested: User -> Sub-resources (Job Postings, Applications, Events)      */
/* -------------------------------------------------------------------------- */
Route::prefix('/users/{user}')->group(function () {
    // Job Postings published by this user
    Route::get('/job-postings', [ApiJobPostingController::class, 'byUser'])->name('api.users.job-postings.index');
    Route::post('/job-postings', [ApiJobPostingController::class, 'storeForUser'])->name('api.users.job-postings.store');

    // Applications submitted by this user
    Route::get('/applications', [ApiApplicationController::class, 'byUser'])->name('api.users.applications.index');

    // Jobs the user applied to (Many-to-Many)
    Route::get('/applied-jobs', [ApiApplicationController::class, 'appliedJobsByUser'])->name('api.users.applied-jobs.index');

    // Events the user registered for
    Route::get('/events', [ApiUserController::class, 'events'])->name('api.users.events.index');

    // Mentorship: mentees guided by this user
    Route::get('/mentees', [ApiUserController::class, 'mentees'])->name('api.users.mentees.index');

    // Mentorship: mentors guiding this user
    Route::get('/mentors', [ApiUserController::class, 'mentors'])->name('api.users.mentors.index');
});

/* -------------------------------------------------------------------------- */
/*  C. Nested: Event -> Registrations (Attendees of an Event)                 */
/* -------------------------------------------------------------------------- */
Route::prefix('/events/{event}')->group(function () {
    Route::get('/registrations', function ($eventId) {
        $event = Event::with('users')->find($eventId);
        if (!$event) {
            return response()->json(['success' => false, 'message' => "Event {$eventId} not found."], 404);
        }
        return response()->json([
            'success'        => true,
            'event_id'       => (int) $eventId,
            'event_title'    => $event->title,
            'attendee_count' => $event->registrations()->count(),
            'data'           => $event->registrations()->with('user')->get(),
        ], 200);
    })->name('api.events.registrations.index');
});
