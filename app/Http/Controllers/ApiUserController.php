<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * ApiUserController (RESTful API Controller)
 * 
 * Handles all /api/users* endpoints with JSON responses and complete CRUD operations.
 */
class ApiUserController extends Controller
{
    /**
     * Display a listing of all users (GET /api/users).
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json([
            'success' => true,
            'count'   => count($users),
            'data'    => array_map(fn($u) => $u->toArray(), $users),
        ], 200);
    }

    /**
     * Store a newly created user (POST /api/users).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $payload = $this->getPayload($request);
        $user = User::create($payload);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully and stored without database (via Cache)!',
            'data'    => $user->toArray(),
        ], 201);
    }

    /**
     * Display the specified user (GET /api/users/{id}).
     *
     * @param int|string $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "User with ID {$id} not found.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $user->toArray(),
        ], 200);
    }

    /**
     * Update the specified user (PUT or PATCH /api/users/{id}).
     *
     * Supports both:
     * - PUT: Full replacement (omitted fields reset to null)
     * - PATCH: Partial update (omitted fields preserved)
     *
     * @param Request $request
     * @param int|string $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "User with ID {$id} not found.",
            ], 404);
        }

        $payload = $this->getPayload($request);
        $isFullReplacement = $request->isMethod('PUT') || $request->header('X-HTTP-Method-Override') === 'PUT';

        $user->update($payload, fullReplacement: $isFullReplacement);

        $message = $isFullReplacement
            ? "User {$id} replaced successfully (PUT: omitted fields reset to null)"
            : "User {$id} partially updated successfully (PATCH, in cache)";

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $user->toArray(),
        ], 200);
    }

    /**
     * Remove the specified user (DELETE /api/users/{id}).
     *
     * @param int|string $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $deletedUser = User::deleteById($id);

        if (!$deletedUser) {
            return response()->json([
                'success' => false,
                'message' => "User with ID {$id} not found.",
            ], 404);
        }

        return response()->json([
            'success'      => true,
            'message'      => "User {$id} deleted successfully.",
            'deleted_user' => $deletedUser->toArray(),
        ], 200);
    }

    /**
     * Reset users back to initial seed data (POST /api/users/reset).
     *
     * @return JsonResponse
     */
    public function reset(): JsonResponse
    {
        $users = User::reset();

        return response()->json([
            'success' => true,
            'message' => 'Users list reset to initial defaults.',
            'data'    => array_map(fn($u) => $u->toArray(), $users),
        ], 200);
    }

    /**
     * Helper to extract request payload reliably across JSON, raw, and form data.
     *
     * @param Request $request
     * @return array
     */
    protected function getPayload(Request $request): array
    {
        $payload = [];

        $raw = $request->getContent();
        if (!empty($raw)) {
            $json = json_decode($raw, true);
            if (is_array($json)) {
                $payload = array_merge($payload, $json);
            } else {
                parse_str($raw, $parsed);
                if (is_array($parsed)) {
                    $payload = array_merge($payload, $parsed);
                }
            }
        }

        if (empty($payload)) {
            $phpInput = file_get_contents('php://input');
            if (!empty($phpInput)) {
                $json = json_decode($phpInput, true);
                if (is_array($json)) {
                    $payload = array_merge($payload, $json);
                } else {
                    parse_str($phpInput, $parsed);
                    if (is_array($parsed)) {
                        $payload = array_merge($payload, $parsed);
                    }
                }
            }
        }

        $all = $request->all();
        if (!empty($all)) {
            $payload = array_merge($payload, $all);
        }

        return $payload;
    }
}
