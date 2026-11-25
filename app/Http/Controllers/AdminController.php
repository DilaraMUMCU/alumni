<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Application;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * AdminController
 *
 * Protected by AuthMiddleware ('role:admin').
 * Provides centralized administrative oversight and direct data manipulation
 * across users/roles, job postings, candidate applications, and announcements.
 */
class AdminController extends Controller
{
    /**
     * Display the Admin Control Panel dashboard (GET /admin).
     */
    public function index(Request $request)
    {
        $roleFilter = $request->query('role');
        $search = trim((string) $request->query('search', ''));

        $usersQuery = User::query()->orderByDesc('id');

        if (!empty($roleFilter) && in_array($roleFilter, ['unverified', 'student', 'alumni', 'academics', 'admin'], true)) {
            if ($roleFilter === 'academics') {
                $usersQuery->whereIn('role', ['academics', 'academician']);
            } else {
                $usersQuery->where('role', $roleFilter);
            }
        }

        if ($search !== '') {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        $users = $usersQuery->get();
        $jobPostings = JobPosting::with(['user', 'applications'])->orderByDesc('id')->get();
        $applications = Application::with(['user', 'jobPosting'])->orderByDesc('id')->get();
        $announcements = Announcement::orderByDesc('pinned')->orderByDesc('id')->get();

        $stats = [
            'total_users'         => User::count(),
            'unverified_users'    => User::where('role', User::ROLE_UNVERIFIED)->count(),
            'students_count'      => User::where('role', User::ROLE_STUDENT)->count(),
            'alumni_count'        => User::where('role', User::ROLE_ALUMNI)->count(),
            'academics_count'     => User::whereIn('role', [User::ROLE_ACADEMICS, 'academician'])->count(),
            'admins_count'        => User::where('role', User::ROLE_ADMIN)->count(),
            'jobs_count'          => $jobPostings->count(),
            'applications_count'  => $applications->count(),
            'announcements_count' => $announcements->count(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'users',
            'jobPostings',
            'applications',
            'announcements',
            'roleFilter',
            'search'
        ));
    }

    /**
     * Update any user's role from the Admin Panel (PATCH /admin/users/{id}/role).
     */
    public function updateUserRole(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => ['required', 'in:unverified,student,alumni,academics,admin'],
        ]);

        $user = User::find($id);
        if (!$user) {
            return $this->respond($request, false, "ID #{$id} ile kullanıcı bulunamadı.", 404);
        }

        $oldRole = $user->role;
        $user->role = $validated['role'];
        $user->save();

        $newLabel = User::formatRoleLabel($user->role);
        $message = "Kullanıcı '{$user->name}' rolü '{$oldRole}' -> '{$newLabel}' ({$user->role}) olarak güncellendi.";

        return $this->respond($request, true, $message, 200, ['user' => $user->toArray()]);
    }

    /**
     * Delete a user from the Admin Panel (DELETE /admin/users/{id}).
     */
    public function deleteUser(Request $request, $id)
    {
        if ((int) $id === (int) Auth::id()) {
            return $this->respond($request, false, 'Kendi aktif yönetici hesabınızı silemezsiniz.', 422);
        }

        $user = User::find($id);
        if (!$user) {
            return $this->respond($request, false, "Silinecek kullanıcı #{$id} bulunamadı.", 404);
        }

        $name = $user->name;
        $user->delete();

        return $this->respond($request, true, "Kullanıcı '{$name}' (#{$id}) sistemden silindi.");
    }

    /**
     * Update a candidate's job application status (PATCH /admin/applications/{id}/status).
     */
    public function updateApplicationStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,reviewing,shortlisted,accepted,rejected'],
        ]);

        $application = Application::find($id);
        if (!$application) {
            return $this->respond($request, false, "Başvuru #{$id} bulunamadı.", 404);
        }

        $application->update(['status' => $validated['status']]);

        return $this->respond(
            $request,
            true,
            "Başvuru #{$id} durumu '{$validated['status']}' olarak güncellendi.",
            200,
            ['application' => $application->toArray()]
        );
    }

    /**
     * Toggle an announcement's active or pinned flag (PATCH /admin/announcements/{id}/toggle).
     */
    public function toggleAnnouncement(Request $request, $id)
    {
        $validated = $request->validate([
            'field' => ['required', 'in:is_active,pinned'],
        ]);

        $announcement = Announcement::find($id);
        if (!$announcement) {
            return $this->respond($request, false, "Duyuru #{$id} bulunamadı.", 404);
        }

        $field = $validated['field'];
        $announcement->{$field} = !$announcement->{$field};
        $announcement->save();

        $label = $field === 'pinned' ? 'Sabitleme' : 'Yayın';
        $state = $announcement->{$field} ? 'Aktif' : 'Pasif';

        return $this->respond(
            $request,
            true,
            "Duyuru #{$id} {$label} durumu '{$state}' olarak güncellendi.",
            200,
            ['announcement' => $announcement->toArray()]
        );
    }

    /**
     * Delete a job posting from the Admin Panel (DELETE /admin/job-postings/{id}).
     */
    public function deleteJobPosting(Request $request, $id)
    {
        $job = JobPosting::find($id);
        if (!$job) {
            return $this->respond($request, false, "İlan #{$id} bulunamadı.", 404);
        }

        $title = $job->title;
        $job->delete();

        return $this->respond($request, true, "İş ilanı '{$title}' (#{$id}) kaldırıldı.");
    }

    /**
     * Delete an announcement from the Admin Panel (DELETE /admin/announcements/{id}).
     */
    public function deleteAnnouncement(Request $request, $id)
    {
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return $this->respond($request, false, "Duyuru #{$id} bulunamadı.", 404);
        }

        $title = $announcement->title;
        $announcement->delete();

        return $this->respond($request, true, "Duyuru '{$title}' (#{$id}) silindi.");
    }

    /**
     * Return either a JSON response (API/AJAX) or a redirect with flash message (Web).
     */
    protected function respond(Request $request, bool $success, string $message, int $status = 200, array $extra = [])
    {
        if ($request->wantsJson() || $request->isJson()) {
            return response()->json(array_merge([
                'success' => $success,
                'message' => $message,
            ], $extra), $status);
        }

        return redirect('/admin')->with($success ? 'success' : 'error', $message);
    }
}
