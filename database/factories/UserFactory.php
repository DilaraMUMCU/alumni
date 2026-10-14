<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = fake()->randomElement(['student', 'alumni']);
        $departments = [
            'Computer Engineering',
            'Industrial Engineering',
            'Software Engineering',
            'Electrical & Electronics Engineering',
            'Mechanical Engineering',
            'Civil Engineering',
            'Business Administration',
            'Data Science & Analytics',
        ];

        $companies = [
            'Google', 'Amazon', 'Microsoft', 'Trendyol', 'Getir',
            'Hepsiburada', 'Peak Games', 'Aselsan', 'Havelsan',
            'Garanti BBVA Technology', 'Turkcell', 'Vodafone',
        ];

        $titles = [
            'Software Engineer', 'Senior Backend Developer', 'Frontend Developer',
            'Data Engineer', 'DevOps Specialist', 'Product Manager',
            'QA Automation Engineer', 'Solutions Architect', 'Cybersecurity Analyst',
        ];

        $allSkills = [
            'PHP', 'Laravel', 'Docker', 'MySQL', 'PostgreSQL', 'Redis',
            'Python', 'FastAPI', 'Django', 'React', 'Vue.js', 'Next.js',
            'TypeScript', 'JavaScript', 'AWS', 'Kubernetes', 'CI/CD',
            'Machine Learning', 'Git', 'Agile / Scrum', 'GraphQL',
        ];

        $isStudent = ($role === 'student');

        return [
            'name'            => fake()->name(),
            'email'           => fake()->unique()->safeEmail(),
            'role'            => $role,
            'department'      => fake()->randomElement($departments),
            'graduation_year' => $isStudent ? fake()->numberBetween(2025, 2028) : fake()->numberBetween(2014, 2024),
            'current_company' => $isStudent ? 'Intern at ' . fake()->randomElement($companies) : fake()->randomElement($companies),
            'job_title'       => $isStudent ? 'Intern' : fake()->randomElement($titles),
            'linkedin_url'    => 'https://linkedin.com/in/' . fake()->slug(),
            'skills'          => fake()->randomElements($allSkills, fake()->numberBetween(3, 6)),
        ];
    }

    /**
     * Indicate that the user is an alumnus.
     */
    public function alumni(): static
    {
        return $this->state(fn (array $attributes) => [
            'role'            => 'alumni',
            'graduation_year' => fake()->numberBetween(2012, 2024),
        ]);
    }

    /**
     * Indicate that the user is a current student.
     */
    public function student(): static
    {
        return $this->state(fn (array $attributes) => [
            'role'            => 'student',
            'graduation_year' => fake()->numberBetween(2025, 2028),
            'job_title'       => 'Student / Intern',
        ]);
    }

    /**
     * Indicate that the user is a system administrator.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role'            => 'admin',
            'department'      => 'IT & Alumni Coordination',
            'job_title'       => 'System Administrator',
            'current_company' => 'University Alumni Office',
            'skills'          => ['Server Administration', 'Security', 'Laravel', 'Docker', 'Database Management'],
        ]);
    }
}
