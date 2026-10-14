<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Fixed Core Seed Announcements
        foreach (Announcement::initialAnnouncements() as $announcementData) {
            Announcement::updateOrCreate(
                ['title' => $announcementData['title']],
                $announcementData
            );
        }

        // 2. Additional Generated Announcements via Factory
        Announcement::factory()->count(3)->career()->create();
        Announcement::factory()->count(3)->event()->create();
        Announcement::factory()->count(2)->mentorship()->create();
        Announcement::factory()->count(2)->urgent()->create();
    }
}
