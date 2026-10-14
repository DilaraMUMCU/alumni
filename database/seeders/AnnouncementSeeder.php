<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $announcements = Announcement::initialAnnouncements();

        foreach ($announcements as $announcement) {
            DB::table('announcements')->updateOrInsert(
                ['title' => $announcement['title']],
                [
                    'content'         => $announcement['content'],
                    'category'        => $announcement['category'],
                    'author'          => $announcement['author'],
                    'target_audience' => $announcement['target_audience'],
                    'priority'        => $announcement['priority'],
                    'is_active'       => $announcement['is_active'],
                    'pinned'          => $announcement['pinned'],
                    'created_at'      => $announcement['created_at'] ? date('Y-m-d H:i:s', strtotime($announcement['created_at'])) : now(),
                    'updated_at'      => $announcement['updated_at'] ? date('Y-m-d H:i:s', strtotime($announcement['updated_at'])) : now(),
                ]
            );
        }
    }
}
