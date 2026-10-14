<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::initialUsers();

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                [
                    'name'            => $user['name'],
                    'role'            => $user['role'],
                    'department'      => $user['department'],
                    'graduation_year' => $user['graduation_year'],
                    'current_company' => $user['current_company'],
                    'job_title'       => $user['job_title'],
                    'linkedin_url'    => $user['linkedin_url'],
                    'skills'          => json_encode($user['skills']),
                    'created_at'      => $user['created_at'] ? date('Y-m-d H:i:s', strtotime($user['created_at'])) : now(),
                    'updated_at'      => $user['updated_at'] ? date('Y-m-d H:i:s', strtotime($user['updated_at'])) : now(),
                ]
            );
        }
    }
}
