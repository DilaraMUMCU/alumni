<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * JobPostingController (Web Controller with Blade Views)
 * 
 * Handles web-level CRUD operations for Job Postings.
 */
class JobPostingController extends Controller
{
    /**
     * Display a listing of job postings (GET /job-postings).
     */
    public function index(Request $request)
    {
        $query = JobPosting::with(['user', 'applications']);

        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $jobs = $query->latest()->get();
        $users = User::all();

        return view('job_postings.index', compact('jobs', 'users'));
    }

    /**
     * Show form for creating a new job posting (GET /job-postings/create).
     */
    public function create()
    {
        $users = User::all();
        return view('job_postings.create', compact('users'));
    }

    /**
     * Store a newly created job posting in database (POST /job-postings).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'title'           => 'required|string|max:255',
            'company'         => 'required|string|max:255',
            'location'        => 'required|string|max:255',
            'employment_type' => 'required|in:full-time,part-time,internship',
            'description'     => 'required|string',
            'application_url' => 'nullable|url|max:255',
            'deadline'        => 'nullable|date',
        ]);

        $job = JobPosting::create($validated);

        return redirect('/job-postings')->with('success', "İş ilanı '{$job->title}' başarıyla yayınlandı!");
    }

    /**
     * Display the specified job posting and its applicant submissions (GET /job-postings/{id}).
     */
    public function show($id)
    {
        $job = JobPosting::with(['user', 'applications.user'])->find($id);

        if (!$job) {
            return redirect('/job-postings')->with('error', "ID #{$id} ile kayıtlı iş ilanı bulunamadı.");
        }

        $users = User::all();

        return view('job_postings.show', compact('job', 'users'));
    }

    /**
     * Show form for editing the job posting (GET /job-postings/{id}/edit).
     */
    public function edit($id)
    {
        $job = JobPosting::find($id);

        if (!$job) {
            return redirect('/job-postings')->with('error', "ID #{$id} ile kayıtlı iş ilanı bulunamadı.");
        }

        $users = User::all();

        return view('job_postings.edit', compact('job', 'users'));
    }

    /**
     * Update the specified job posting (PUT /job-postings/{id}).
     */
    public function update(Request $request, $id)
    {
        $job = JobPosting::find($id);

        if (!$job) {
            return redirect('/job-postings')->with('error', "ID #{$id} ile kayıtlı iş ilanı bulunamadı.");
        }

        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'title'           => 'required|string|max:255',
            'company'         => 'required|string|max:255',
            'location'        => 'required|string|max:255',
            'employment_type' => 'required|in:full-time,part-time,internship',
            'description'     => 'required|string',
            'application_url' => 'nullable|url|max:255',
            'deadline'        => 'nullable|date',
        ]);

        $job->update($validated);

        return redirect("/job-postings/{$id}")->with('success', "İş ilanı başarıyla güncellendi!");
    }

    /**
     * Delete the specified job posting (DELETE /job-postings/{id}).
     */
    public function destroy($id)
    {
        $job = JobPosting::find($id);

        if ($job) {
            $title = $job->title;
            $job->delete();
            return redirect('/job-postings')->with('success', "İş ilanı '{$title}' başarıyla silindi.");
        }

        return redirect('/job-postings')->with('error', "İlan bulunamadı.");
    }
}
