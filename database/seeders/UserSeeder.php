<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Fixed Core Seed Users
        foreach (User::initialUsers() as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // 2. Additional Generated Users via Factory
        // 10 Alumni users
        User::factory()->count(10)->alumni()->create();

        // 5 Student users
        User::factory()->count(5)->student()->create();

        // 1 Administrator user
        User::factory()->admin()->create([
            'email' => 'admin@alumni.edu',
            'name'  => 'Alumni System Admin',
        ]);
    }
}
