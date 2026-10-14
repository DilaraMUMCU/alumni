<?php

namespace Database\Factories;

use App\Models\MentorshipRelationship;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MentorshipRelationship>
 */
class MentorshipRelationshipFactory extends Factory
{
    protected $model = MentorshipRelationship::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $focusAreas = [
            'Software Engineering Career Navigation',
            'Full Stack Web Development & System Design',
            'Cloud Architecture & DevOps Best Practices',
            'Data Science, AI & Machine Learning Specialization',
            'Product Management & Startup Strategy',
            'Technical Interview Preparation & LeetCode Coaching',
            'Academic Graduate School Applications in Europe & USA',
        ];

        $status = fake()->randomElement(['pending', 'active', 'active', 'completed']);

        return [
            'mentor_id'   => User::factory()->alumni(),
            'mentee_id'   => User::factory()->student(),
            'focus_area'  => fake()->randomElement($focusAreas),
            'status'      => $status,
            'start_date'  => fake()->dateTimeBetween('-4 months', '-1 month'),
            'end_date'    => ($status === 'completed') ? fake()->dateTimeBetween('-1 month', 'now') : fake()->dateTimeBetween('+1 month', '+6 months'),
            'notes'       => fake()->paragraph(),
        ];
    }

    /**
     * Active state.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'     => 'active',
            'start_date' => now()->subMonth(),
            'end_date'   => now()->addMonths(5),
        ]);
    }
}
