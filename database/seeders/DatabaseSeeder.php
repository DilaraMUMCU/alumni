<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AnnouncementSeeder::class,
            JobPostingSeeder::class,
            EventSeeder::class,
            MentorshipSeeder::class,
        ]);
    }
}
