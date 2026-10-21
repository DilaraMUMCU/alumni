<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * ApiApplicationController
 * 
 * Provides Direct and Nested RESTful API endpoints for Job Applications.
 */
class ApiApplicationController extends Controller
{
    /**
     * Direct: Display a listing of all applications (GET /api/applications).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Application::with(['jobPosting', 'user']);

        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->has('job_posting_id')) {
            $query->where('job_posting_id', $request->query('job_posting_id'));
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->query('user_id'));
        }

        $applications = $query->latest('applied_at')->get();

        return response()->json([
            'success' => true,
            'count'   => $applications->count(),
            'data'    => $applications,
        ], 200);
    }

    /**
     * Direct: Store a newly created application (POST /api/applications).
     */
    public function store(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'job_posting_id' => 'required|exists:job_postings,id',
            'user_id'        => 'required|exists:users,id',
            'resume_url'     => 'nullable|url|max:255',
            'cover_letter'   => 'nullable|string',
            'status'         => 'nullable|in:pending,reviewing,shortlisted,accepted,rejected',
        ]);

        // Prevent duplicate application
        $exists = Application::where('job_posting_id', $payload['job_posting_id'])
            ->where('user_id', $payload['user_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'User has already submitted an application to this job posting.',
            ], 422);
        }

        $application = Application::create($payload);

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully.',
            'data'    => $application->load(['jobPosting', 'user']),
        ], 201);
    }

    /**
     * Direct: Display the specified application (GET /api/applications/{id}).
     */
    public function show($id): JsonResponse
    {
        $application = Application::with(['jobPosting', 'user'])->find($id);

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => "Application with ID {$id} not found.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $application,
        ], 200);
    }

    /**
     * Direct: Update application details or status (PUT/PATCH /api/applications/{id}).
     */
    public function update(Request $request, $id): JsonResponse
    {
        $application = Application::find($id);

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => "Application with ID {$id} not found.",
            ], 404);
        }

        $payload = $request->validate([
            'resume_url'   => 'nullable|url|max:255',
            'cover_letter' => 'nullable|string',
            'status'       => 'sometimes|in:pending,reviewing,shortlisted,accepted,rejected',
        ]);

        $application->update($payload);

        return response()->json([
            'success' => true,
            'message' => 'Application updated successfully.',
            'data'    => $application->fresh(['jobPosting', 'user']),
        ], 200);
    }

    /**
     * Direct: Withdraw or delete an application (DELETE /api/applications/{id}).
     */
    public function destroy($id): JsonResponse
    {
        $application = Application::find($id);

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => "Application with ID {$id} not found.",
            ], 404);
        }

        $application->delete();

        return response()->json([
            'success' => true,
            'message' => "Application {$id} deleted successfully.",
        ], 200);
    }

    /* -------------------------------------------------------------------------- */
    /*                              NESTED ENDPOINTS                              */
    /* -------------------------------------------------------------------------- */

    /**
     * Nested: List all applications for a specific job posting (GET /api/job-postings/{job_posting}/applications).
     */
    public function byJobPosting($jobPostingId): JsonResponse
    {
        $job = JobPosting::find($jobPostingId);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => "Job posting with ID {$jobPostingId} not found.",
            ], 404);
        }

        $applications = $job->applications()->with('user')->latest('applied_at')->get();

        return response()->json([
            'success'          => true,
            'job_posting_id'   => (int) $jobPostingId,
            'job_title'        => $job->title,
            'job_company'      => $job->company,
            'applicant_count'  => $applications->count(),
            'data'             => $applications,
        ], 200);
    }

    /**
     * Nested: Submit application to a specific job posting (POST /api/job-postings/{job_posting}/applications).
     */
    public function storeForJobPosting(Request $request, $jobPostingId): JsonResponse
    {
        $job = JobPosting::find($jobPostingId);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => "Job posting with ID {$jobPostingId} not found.",
            ], 404);
        }

        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'resume_url'   => 'nullable|url|max:255',
            'cover_letter' => 'nullable|string',
        ]);

        // Prevent duplicate application
        $exists = $job->applications()->where('user_id', $validated['user_id'])->exists();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => "User {$validated['user_id']} has already applied to this job posting.",
            ], 422);
        }

        $application = $job->applications()->create([
            'user_id'      => $validated['user_id'],
            'resume_url'   => $validated['resume_url'] ?? null,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status'       => 'pending',
            'applied_at'   => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Successfully applied to job posting '{$job->title}'.",
            'data'    => $application->load('user'),
        ], 201);
    }

    /**
     * Nested: View specific application under a job posting (GET /api/job-postings/{job_posting}/applications/{application}).
     */
    public function showNested($jobPostingId, $applicationId): JsonResponse
    {
        $application = Application::where('job_posting_id', $jobPostingId)
            ->with(['user', 'jobPosting'])
            ->find($applicationId);

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => "Application {$applicationId} not found under job posting {$jobPostingId}.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $application,
        ], 200);
    }

    /**
     * Nested: Update application review status under a job posting (PATCH /api/job-postings/{job_posting}/applications/{application}/status).
     */
    public function updateStatus(Request $request, $jobPostingId, $applicationId): JsonResponse
    {
        $application = Application::where('job_posting_id', $jobPostingId)->find($applicationId);

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => "Application {$applicationId} not found under job posting {$jobPostingId}.",
            ], 404);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewing,shortlisted,accepted,rejected',
        ]);

        $application->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => "Status of application {$applicationId} updated to '{$validated['status']}'.",
            'data'    => $application->fresh('user'),
        ], 200);
    }

    /**
     * Nested: List all applications submitted by a user (GET /api/users/{user}/applications).
     */
    public function byUser($userId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "User with ID {$userId} not found.",
            ], 404);
        }

        $applications = $user->applications()->with('jobPosting')->latest('applied_at')->get();

        return response()->json([
            'success'   => true,
            'user_id'   => (int) $userId,
            'user_name' => $user->name,
            'count'     => $applications->count(),
            'data'      => $applications,
        ], 200);
    }

    /**
     * Nested: List all jobs applied to by a user via M:N relationship (GET /api/users/{user}/applied-jobs).
     */
    public function appliedJobsByUser($userId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "User with ID {$userId} not found.",
            ], 404);
        }

        $jobs = $user->appliedJobs()->with('user')->get();

        return response()->json([
            'success'   => true,
            'user_id'   => (int) $userId,
            'user_name' => $user->name,
            'count'     => $jobs->count(),
            'data'      => $jobs,
        ], 200);
    }
}
