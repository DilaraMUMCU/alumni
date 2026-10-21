<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * ApiJobPostingController
 * 
 * Provides Direct and Nested RESTful API endpoints for JobPostings.
 */
class ApiJobPostingController extends Controller
{
    /**
     * Direct: Display a listing of job postings (GET /api/job-postings).
     */
    public function index(Request $request): JsonResponse
    {
        $query = JobPosting::with(['user', 'applications']);

        if ($request->has('employment_type')) {
            $query->where('employment_type', $request->query('employment_type'));
        }

        if ($request->has('company')) {
            $query->where('company', 'like', '%' . $request->query('company') . '%');
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->query('user_id'));
        }

        $jobs = $query->latest()->get();

        return response()->json([
            'success' => true,
            'count'   => $jobs->count(),
            'data'    => $jobs,
        ], 200);
    }

    /**
     * Direct: Store a newly created job posting (POST /api/job-postings).
     */
    public function store(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'title'           => 'required|string|max:255',
            'company'         => 'required|string|max:255',
            'location'        => 'required|string|max:255',
            'employment_type' => 'nullable|in:full-time,part-time,internship',
            'description'     => 'required|string',
            'application_url' => 'nullable|url|max:255',
            'deadline'        => 'nullable|date',
        ]);

        $job = JobPosting::create($payload);

        return response()->json([
            'success' => true,
            'message' => 'Job posting created successfully.',
            'data'    => $job->load('user'),
        ], 201);
    }

    /**
     * Direct: Display the specified job posting (GET /api/job-postings/{id}).
     */
    public function show($id): JsonResponse
    {
        $job = JobPosting::with(['user', 'applications.user'])->find($id);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => "Job posting with ID {$id} not found.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $job,
        ], 200);
    }

    /**
     * Direct: Update the specified job posting (PUT/PATCH /api/job-postings/{id}).
     */
    public function update(Request $request, $id): JsonResponse
    {
        $job = JobPosting::find($id);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => "Job posting with ID {$id} not found.",
            ], 404);
        }

        $payload = $request->validate([
            'user_id'         => 'sometimes|exists:users,id',
            'title'           => 'sometimes|string|max:255',
            'company'         => 'sometimes|string|max:255',
            'location'        => 'sometimes|string|max:255',
            'employment_type' => 'sometimes|in:full-time,part-time,internship',
            'description'     => 'sometimes|string',
            'application_url' => 'nullable|url|max:255',
            'deadline'        => 'nullable|date',
        ]);

        $job->update($payload);

        return response()->json([
            'success' => true,
            'message' => 'Job posting updated successfully.',
            'data'    => $job->fresh(['user']),
        ], 200);
    }

    /**
     * Direct: Delete a job posting (DELETE /api/job-postings/{id}).
     */
    public function destroy($id): JsonResponse
    {
        $job = JobPosting::find($id);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => "Job posting with ID {$id} not found.",
            ], 404);
        }

        $job->delete();

        return response()->json([
            'success' => true,
            'message' => "Job posting {$id} deleted successfully.",
        ], 200);
    }

    /* -------------------------------------------------------------------------- */
    /*                              NESTED ENDPOINTS                              */
    /* -------------------------------------------------------------------------- */

    /**
     * Nested: List all job postings published by a specific user (GET /api/users/{user}/job-postings).
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

        $jobs = $user->jobPostings()->withCount('applications')->latest()->get();

        return response()->json([
            'success'   => true,
            'user_id'   => (int) $userId,
            'user_name' => $user->name,
            'count'     => $jobs->count(),
            'data'      => $jobs,
        ], 200);
    }

    /**
     * Nested: Create a job posting under a specific user (POST /api/users/{user}/job-postings).
     */
    public function storeForUser(Request $request, $userId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "User with ID {$userId} not found.",
            ], 404);
        }

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'company'         => 'required|string|max:255',
            'location'        => 'required|string|max:255',
            'employment_type' => 'nullable|in:full-time,part-time,internship',
            'description'     => 'required|string',
            'application_url' => 'nullable|url|max:255',
            'deadline'        => 'nullable|date',
        ]);

        $job = $user->jobPostings()->create($validated);

        return response()->json([
            'success' => true,
            'message' => "Job posting published under user {$userId} ({$user->name}).",
            'data'    => $job,
        ], 201);
    }
}
