<?php

namespace Database\Factories;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPosting>
 */
class JobPostingFactory extends Factory
{
    protected $model = JobPosting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jobTitles = [
            'Senior Backend Engineer (PHP / Go)',
            'Full Stack Web Developer (Laravel & React)',
            'DevOps & Cloud Infrastructure Engineer',
            'Data Engineer / ETL Specialist',
            'Associate Product Manager',
            'AI / NLP Research Engineer',
            'Summer 2026 Software Engineering Intern',
            'Mobile App Developer (Flutter / iOS)',
            'Cybersecurity Operations Analyst',
        ];

        $companies = [
            'Google', 'Amazon Web Services', 'Trendyol Group', 'Getir Tech',
            'Peak Games', 'Hepsiburada', 'Dream Games', 'Insider',
            'Garanti BBVA Technology', 'Aselsan',
        ];

        $locations = [
            'Istanbul (Hybrid)',
            'Istanbul (On-site, Maslak)',
            'Ankara (On-site, ODTÜ Teknokent)',
            'Izmir (Remote)',
            'Remote (Worldwide / Europe)',
            'Berlin, Germany (Relocation Provided)',
            'London, UK (Hybrid)',
        ];

        return [
            'user_id'         => User::factory()->alumni(),
            'title'           => fake()->randomElement($jobTitles),
            'company'         => fake()->randomElement($companies),
            'location'        => fake()->randomElement($locations),
            'employment_type' => fake()->randomElement(['full-time', 'full-time', 'part-time', 'internship']),
            'description'     => fake()->paragraphs(3, true),
            'application_url' => 'https://careers.' . fake()->domainName() . '/apply/' . fake()->slug(),
            'deadline'        => fake()->dateTimeBetween('+2 weeks', '+3 months'),
        ];
    }

    /**
     * Internship state.
     */
    public function internship(): static
    {
        return $this->state(fn (array $attributes) => [
            'employment_type' => 'internship',
            'title'           => 'Software Engineering Summer Intern',
        ]);
    }
}
