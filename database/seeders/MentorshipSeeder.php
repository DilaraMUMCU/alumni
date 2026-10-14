<?php

namespace Database\Seeders;

use App\Models\MentorshipRelationship;
use App\Models\User;
use Illuminate\Database\Seeder;

class MentorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alumni = User::where('role', 'alumni')->get();
        $students = User::where('role', 'student')->get();

        if ($alumni->isEmpty() || $students->isEmpty()) {
            return;
        }

        $pairCount = min(5, $alumni->count(), $students->count());
        $shuffledAlumni = $alumni->shuffle();
        $shuffledStudents = $students->shuffle();

        for ($i = 0; $i < $pairCount; $i++) {
            MentorshipRelationship::firstOrCreate(
                [
                    'mentor_id' => $shuffledAlumni[$i]->id,
                    'mentee_id' => $shuffledStudents[$i]->id,
                ],
                [
                    'focus_area' => 'Career Guidance & Technical Mentorship',
                    'status'     => 'active',
                    'start_date' => now()->subMonth(),
                    'end_date'   => now()->addMonths(5),
                    'notes'      => 'Bi-weekly 1-on-1 virtual mentoring meetings on software engineering career advancement.',
                ]
            );
        }
    }
}
