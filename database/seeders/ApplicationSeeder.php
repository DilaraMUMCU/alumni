<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $jobPostings = JobPosting::all();

        if ($users->isEmpty() || $jobPostings->isEmpty()) {
            return;
        }

        $existingPairs = [];

        foreach ($jobPostings as $job) {
            // Pick candidate users who are not the creator of the job
            $candidates = $users->where('id', '!=', $job->user_id);
            if ($candidates->isEmpty()) {
                continue;
            }

            $count = min(rand(1, 3), $candidates->count());
            $selected = $candidates->random($count);

            foreach ($selected as $candidate) {
                $pairKey = "{$job->id}-{$candidate->id}";
                if (isset($existingPairs[$pairKey])) {
                    continue;
                }
                $existingPairs[$pairKey] = true;

                Application::factory()->create([
                    'job_posting_id' => $job->id,
                    'user_id'        => $candidate->id,
                ]);
            }
        }
    }
}
