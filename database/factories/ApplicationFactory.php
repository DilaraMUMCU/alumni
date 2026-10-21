<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_posting_id' => JobPosting::factory(),
            'user_id'        => User::factory(),
            'resume_url'     => fake()->optional(0.7)->url(),
            'cover_letter'   => fake()->optional(0.6)->paragraph(),
            'status'         => fake()->randomElement(['pending', 'reviewing', 'shortlisted', 'accepted', 'rejected']),
            'applied_at'     => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Set the application state to pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Set the application state to accepted.
     */
    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'accepted',
        ]);
    }
}
