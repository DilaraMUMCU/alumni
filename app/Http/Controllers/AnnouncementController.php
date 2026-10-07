<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

/**
 * AnnouncementController (Web Controller with View Layer)
 * 
 * Handles all web-level announcement CRUD operations and renders Blade templates.
 */
class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements (GET /announcements).
     */
    public function index()
    {
        $announcements = Announcement::all();

        if (view()->exists('announcements.index')) {
            return view('announcements.index', compact('announcements'));
        }

        return response()->json([
            'success' => true,
            'source'  => 'AnnouncementController@index',
            'count'   => count($announcements),
            'data'    => array_map(fn($a) => $a->toArray(), $announcements),
        ]);
    }

    /**
     * Show the form for creating a new announcement (GET /announcements/create).
     */
    public function create()
    {
        if (view()->exists('announcements.create')) {
            return view('announcements.create');
        }

        return response()->json([
            'success' => true,
            'source'  => 'AnnouncementController@create',
            'message' => 'Announcement create form view placeholder',
            'fields'  => ['title', 'content', 'category', 'author', 'target_audience', 'priority', 'is_active', 'pinned'],
        ]);
    }

    /**
     * Store a newly created announcement in storage (POST /announcements).
     */
    public function store(Request $request)
    {
        $payload = $request->except(['_token', '_method']);
        $announcement = Announcement::create($payload);

        if ($request->wantsJson() || $request->isJson()) {
            return response()->json([
                'success' => true,
                'source'  => 'AnnouncementController@store',
                'message' => 'Duyuru başarıyla oluşturuldu!',
                'data'    => $announcement->toArray(),
            ], 201);
        }

        return redirect('/announcements')->with('success', "Duyuru '{$announcement->title}' başarıyla yayınlandı!");
    }

    /**
     * Display the specified announcement (GET /announcements/{id}).
     */
    public function show($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Announcement with ID {$id} not found.",
                ], 404);
            }
            return redirect('/announcements')->with('error', "ID #{$id} ile kayıtlı duyuru bulunamadı.");
        }

        if (view()->exists('announcements.show')) {
            return view('announcements.show', compact('announcement'));
        }

        return response()->json([
            'success' => true,
            'source'  => 'AnnouncementController@show',
            'data'    => $announcement->toArray(),
        ]);
    }

    /**
     * Show the form for editing the specified announcement (GET /announcements/{id}/edit).
     */
    public function edit($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Announcement with ID {$id} not found.",
                ], 404);
            }
            return redirect('/announcements')->with('error', "Düzenlenecek duyuru #{$id} bulunamadı.");
        }

        if (view()->exists('announcements.edit')) {
            return view('announcements.edit', compact('announcement'));
        }

        return response()->json([
            'success' => true,
            'source'  => 'AnnouncementController@edit',
            'message' => 'Announcement edit form view placeholder',
            'data'    => $announcement->toArray(),
        ]);
    }

    /**
     * Update the specified announcement in storage (PUT/PATCH /announcements/{id}).
     */
    public function update(Request $request, $id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Announcement with ID {$id} not found.",
                ], 404);
            }
            return redirect('/announcements')->with('error', "Güncellenecek duyuru #{$id} bulunamadı.");
        }

        $fullReplacement = $request->isMethod('PUT');
        $payload = $request->except(['_token', '_method']);
        $announcement->update($payload, $fullReplacement);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'source'  => 'AnnouncementController@update',
                'message' => "Announcement {$id} updated successfully via AnnouncementController",
                'data'    => $announcement->toArray(),
            ]);
        }

        return redirect("/announcements/{$id}")->with('success', "Duyuru #{$id} ({$announcement->title}) başarıyla güncellendi!");
    }

    /**
     * Remove the specified announcement from storage (DELETE /announcements/{id}).
     */
    public function destroy(Request $request, $id)
    {
        $deleted = Announcement::deleteById($id);

        if (!$deleted) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Announcement with ID {$id} not found.",
                ], 404);
            }
            return redirect('/announcements')->with('error', "Silinecek duyuru #{$id} bulunamadı.");
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'source'       => 'AnnouncementController@destroy',
                'message'      => "Announcement {$id} deleted successfully.",
                'deleted_data' => $deleted->toArray(),
            ]);
        }

        return redirect('/announcements')->with('success', "Duyuru #{$id} ({$deleted->title}) sistemden silindi!");
    }
}
