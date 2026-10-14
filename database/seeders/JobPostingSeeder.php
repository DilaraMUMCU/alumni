<?php

namespace Database\Seeders;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobPostingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alumni = User::where('role', 'alumni')->get();

        if ($alumni->isEmpty()) {
            return;
        }

        // Create 8 job postings associated with existing alumni
        foreach (range(1, 8) as $index) {
            JobPosting::factory()->create([
                'user_id' => $alumni->random()->id,
            ]);
        }
    }
}
