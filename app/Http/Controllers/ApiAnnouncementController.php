<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * ApiAnnouncementController (RESTful API Controller)
 * 
 * Handles all /api/announcements* endpoints with JSON responses and complete CRUD operations.
 */
class ApiAnnouncementController extends Controller
{
    /**
     * Display a listing of all announcements (GET /api/announcements).
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $announcements = Announcement::all();

        return response()->json([
            'success' => true,
            'count'   => count($announcements),
            'data'    => array_map(fn($a) => $a->toArray(), $announcements),
        ], 200);
    }

    /**
     * Store a newly created announcement (POST /api/announcements).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $payload = $this->getPayload($request);
        $announcement = Announcement::create($payload);

        return response()->json([
            'success' => true,
            'message' => 'Announcement created successfully and stored without database (via Cache)!',
            'data'    => $announcement->toArray(),
        ], 201);
    }

    /**
     * Display the specified announcement (GET /api/announcements/{id}).
     *
     * @param int|string $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json([
                'success' => false,
                'message' => "Announcement with ID {$id} not found.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $announcement->toArray(),
        ], 200);
    }

    /**
     * Update the specified announcement (PUT or PATCH /api/announcements/{id}).
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
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json([
                'success' => false,
                'message' => "Announcement with ID {$id} not found.",
            ], 404);
        }

        $payload = $this->getPayload($request);
        $isFullReplacement = $request->isMethod('PUT') || $request->header('X-HTTP-Method-Override') === 'PUT';

        $announcement->update($payload, fullReplacement: $isFullReplacement);

        $message = $isFullReplacement
            ? "Announcement {$id} replaced successfully (PUT: omitted fields reset to defaults/null)"
            : "Announcement {$id} partially updated successfully (PATCH, in cache)";

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $announcement->toArray(),
        ], 200);
    }

    /**
     * Remove the specified announcement (DELETE /api/announcements/{id}).
     *
     * @param int|string $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $deleted = Announcement::deleteById($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => "Announcement with ID {$id} not found.",
            ], 404);
        }

        return response()->json([
            'success'              => true,
            'message'              => "Announcement {$id} deleted successfully.",
            'deleted_announcement' => $deleted->toArray(),
        ], 200);
    }

    /**
     * Reset announcements back to initial seed data (POST /api/announcements/reset).
     *
     * @return JsonResponse
     */
    public function reset(): JsonResponse
    {
        $announcements = Announcement::reset();

        return response()->json([
            'success' => true,
            'message' => 'Announcements list reset to initial defaults.',
            'count'   => count($announcements),
            'data'    => array_map(fn($a) => $a->toArray(), $announcements),
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
