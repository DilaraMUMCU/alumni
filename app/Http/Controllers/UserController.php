<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * UserController (Web Controller with View Layer)
 * 
 * Handles all web-level user CRUD operations and renders Blade templates.
 */
class UserController extends Controller
{
    /**
     * Display a listing of users (GET /users).
     */
    public function index()
    {
        $users = User::all();

        if (view()->exists('users.index')) {
            return view('users.index', compact('users'));
        }

        return response()->json([
            'success' => true,
            'source'  => 'UserController@index',
            'count'   => count($users),
            'data'    => array_map(fn($u) => $u->toArray(), $users),
        ]);
    }

    /**
     * Show the form for creating a new user (GET /users/create).
     */
    public function create()
    {
        if (view()->exists('users.create')) {
            return view('users.create');
        }

        return response()->json([
            'success' => true,
            'source'  => 'UserController@create',
            'message' => 'User create form view placeholder',
            'fields'  => ['name', 'email', 'role', 'department', 'graduation_year', 'current_company', 'job_title', 'skills', 'linkedin_url'],
        ]);
    }

    /**
     * Store a newly created user in storage (POST /users).
     */
    public function store(Request $request)
    {
        $payload = $request->except(['_token', '_method']);
        $user = User::create($payload);

        if ($request->wantsJson() || $request->isJson()) {
            return response()->json([
                'success' => true,
                'source'  => 'UserController@store',
                'message' => 'User created successfully via UserController',
                'data'    => $user->toArray(),
            ], 201);
        }

        return redirect('/users')->with('success', "Kullanıcı '{$user->name}' başarıyla oluşturuldu ve listeye eklendi!");
    }

    /**
     * Display the specified user (GET /users/{id}).
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "User with ID {$id} not found.",
                ], 404);
            }
            return redirect('/users')->with('error', "ID #{$id} ile kayıtlı kullanıcı bulunamadı.");
        }

        if (view()->exists('users.show')) {
            return view('users.show', compact('user'));
        }

        return response()->json([
            'success' => true,
            'source'  => 'UserController@show',
            'data'    => $user->toArray(),
        ]);
    }

    /**
     * Show the form for editing the specified user (GET /users/{id}/edit).
     */
    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "User with ID {$id} not found.",
                ], 404);
            }
            return redirect('/users')->with('error', "Düzenlenecek kullanıcı #{$id} bulunamadı.");
        }

        if (view()->exists('users.edit')) {
            return view('users.edit', compact('user'));
        }

        return response()->json([
            'success' => true,
            'source'  => 'UserController@edit',
            'message' => 'User edit form view placeholder',
            'data'    => $user->toArray(),
        ]);
    }

    /**
     * Update the specified user in storage (PUT/PATCH /users/{id}).
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "User with ID {$id} not found.",
                ], 404);
            }
            return redirect('/users')->with('error', "Güncellenecek kullanıcı #{$id} bulunamadı.");
        }

        $fullReplacement = $request->isMethod('PUT');
        $payload = $request->except(['_token', '_method']);
        $user->update($payload, $fullReplacement);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'source'  => 'UserController@update',
                'message' => "User {$id} updated successfully via UserController",
                'data'    => $user->toArray(),
            ]);
        }

        return redirect("/users/{$id}")->with('success', "Kullanıcı #{$id} ({$user->name}) başarıyla güncellendi!");
    }

    /**
     * Remove the specified user from storage (DELETE /users/{id}).
     */
    public function destroy(Request $request, $id)
    {
        $deletedUser = User::deleteById($id);

        if (!$deletedUser) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "User with ID {$id} not found.",
                ], 404);
            }
            return redirect('/users')->with('error', "Silinecek kullanıcı #{$id} bulunamadı.");
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'source'       => 'UserController@destroy',
                'message'      => "User {$id} deleted successfully via UserController.",
                'deleted_user' => $deletedUser->toArray(),
            ]);
        }

        return redirect('/users')->with('success', "Kullanıcı #{$id} ({$deletedUser->name}) başarıyla sistemden silindi!");
    }
}
