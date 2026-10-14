<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $events = [
            '2026 Annual Alumni Networking Dinner & Gala',
            'Tech Keynote: Architecting High-Traffic Distributed Systems',
            'Startups & Angels: Alumni Pitching & Investment Night',
            'Engineering Mentorship Speed-Networking Workshop',
            'Spring Alumni Reunion Picnic & Campus Tour',
            'Women Leaders in STEM: Alumni Career Panel',
            'Global Opportunities: Working & Relocating to Europe',
        ];

        $locations = [
            'Grand Ballroom, University Cultural & Convention Center',
            'Faculty of Engineering Amphitheater A-101',
            'Online via Zoom & YouTube Live Stream',
            'Alumni Association Social Clubhouse, Levent',
            'Campus Main Lawn & Botanical Gardens',
        ];

        return [
            'title'       => fake()->randomElement($events),
            'description' => fake()->paragraphs(2, true),
            'event_date'  => fake()->dateTimeBetween('+1 week', '+3 months'),
            'location'    => fake()->randomElement($locations),
            'capacity'    => fake()->randomElement([50, 100, 150, 250, 500]),
        ];
    }
}
