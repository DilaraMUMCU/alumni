<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * ApplicationController (Web Controller with Blade Views)
 * 
 * Handles web-level candidate job applications.
 */
class ApplicationController extends Controller
{
    /**
     * Display a listing of all applications (GET /applications).
     */
    public function index(Request $request)
    {
        $query = Application::with(['jobPosting', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('job_posting_id')) {
            $query->where('job_posting_id', $request->job_posting_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $applications = $query->latest('applied_at')->get();
        $jobPostings = JobPosting::all();
        $users = User::all();

        return view('applications.index', compact('applications', 'jobPostings', 'users'));
    }

    /**
     * Show form for submitting an application (GET /applications/create).
     */
    public function create(Request $request)
    {
        $selectedJobId = $request->query('job_posting_id');
        $jobPostings = JobPosting::all();
        $users = User::all();

        return view('applications.create', compact('jobPostings', 'users', 'selectedJobId'));
    }

    /**
     * Store a newly created application (POST /applications).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_posting_id' => 'required|exists:job_postings,id',
            'user_id'        => 'required|exists:users,id',
            'resume_url'     => 'nullable|url|max:255',
            'cover_letter'   => 'nullable|string',
        ]);

        // Duplicate check
        $exists = Application::where('job_posting_id', $validated['job_posting_id'])
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Seçilen kullanıcı bu ilana daha önce başvuru yapmıştır (Mükerrer başvuru engellendi).');
        }

        $validated['status'] = 'pending';
        $validated['applied_at'] = now();

        $app = Application::create($validated);

        $redirectUrl = $request->input('redirect_to', '/applications');
        return redirect($redirectUrl)->with('success', 'İş başvurunuz başarıyla sisteme kaydedildi!');
    }

    /**
     * Display the specified application details (GET /applications/{id}).
     */
    public function show($id)
    {
        $application = Application::with(['jobPosting.user', 'user'])->find($id);

        if (!$application) {
            return redirect('/applications')->with('error', "ID #{$id} ile kayıtlı başvuru bulunamadı.");
        }

        return view('applications.show', compact('application'));
    }

    /**
     * Quick update review status of an application (PATCH /applications/{id}/status).
     */
    public function updateStatus(Request $request, $id)
    {
        $application = Application::find($id);

        if (!$application) {
            return back()->with('error', "Başvuru bulunamadı.");
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewing,shortlisted,accepted,rejected',
        ]);

        $application->update(['status' => $validated['status']]);

        $labels = [
            'pending'     => 'Beklemede',
            'reviewing'   => 'İnceleniyor',
            'shortlisted' => 'Kısa Listeye Alındı',
            'accepted'    => 'Kabul Edildi',
            'rejected'    => 'Reddedildi',
        ];

        $statusLabel = $labels[$validated['status']] ?? $validated['status'];

        return back()->with('success', "Adayın başvuru durumu '{$statusLabel}' olarak güncellendi.");
    }

    /**
     * Delete an application (DELETE /applications/{id}).
     */
    public function destroy($id)
    {
        $application = Application::find($id);

        if ($application) {
            $application->delete();
            return back()->with('success', "Başvuru kaydı başarıyla silindi.");
        }

        return back()->with('error', "Başvuru bulunamadı.");
    }
}
