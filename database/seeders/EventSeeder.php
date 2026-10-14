<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::factory()->count(5)->create();
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        // Register random users to events
        foreach ($events as $event) {
            $attendees = $users->random(min(rand(3, 8), $users->count()));

            foreach ($attendees as $user) {
                EventRegistration::firstOrCreate(
                    [
                        'user_id'  => $user->id,
                        'event_id' => $event->id,
                    ],
                    [
                        'registered_at' => now()->subDays(rand(1, 14)),
                        'status'        => 'confirmed',
                    ]
                );
            }
        }
    }
}
