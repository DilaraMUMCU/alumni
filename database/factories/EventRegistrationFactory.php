<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventRegistration>
 */
class EventRegistrationFactory extends Factory
{
    protected $model = EventRegistration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'       => User::factory(),
            'event_id'      => Event::factory(),
            'registered_at' => fake()->dateTimeBetween('-2 weeks', 'now'),
            'status'        => fake()->randomElement(['confirmed', 'confirmed', 'confirmed', 'waitlist', 'cancelled']),
        ];
    }

    /**
     * Confirmed status state.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }
}
