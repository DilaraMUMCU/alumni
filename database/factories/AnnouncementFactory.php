<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = fake()->randomElement(['event', 'career', 'mentorship', 'academic', 'general']);

        $authors = [
            'Alumni Coordination Office',
            'Career & Internship Center',
            'Alumni Association Executive Board',
            'Dean of Students Office',
            'Faculty of Engineering & Natural Sciences',
            'Entrepreneurship & Innovation Hub',
        ];

        $titlesByCategory = [
            'event' => [
                'Annual Alumni Homecoming & Networking Gala 2026',
                'Tech Pioneers Panel: Future of Artificial Intelligence',
                'Global Alumni Chapter Meetup - European Edition',
                'Spring Campus Run & Alumni Sports Festival',
            ],
            'career' => [
                'Exclusive Tech Internship & New Grad Openings via Alumni Network',
                'Amazon & Google Alumni Referral Portal Now Active',
                'Fintech & Banking Fast-Track Career Program Applications Open',
                'Remote Software Engineering Positions for Class of 2024-2025',
            ],
            'mentorship' => [
                'Alumni Mentorship Program 2026-2027 Cohort Call for Mentors',
                'One-on-One Engineering Career Guidance Sessions',
                'Executive Mentorship Opportunities with Alumni Founders',
            ],
            'academic' => [
                'Graduate Study & Scholarship Opportunities in Germany & USA',
                'Joint Industry-Academia Research Grant Applications',
                'Alumni Guest Lecture Series: Cloud Infrastructure at Scale',
            ],
            'general' => [
                'New Alumni Portal Features: Digital Directory & Job Board',
                'Campus Library & Sports Facilities Access Guide for Alumni',
                'Alumni Association General Assembly Notice',
            ],
        ];

        $title = fake()->randomElement($titlesByCategory[$category]);

        return [
            'title'           => $title,
            'content'         => fake()->paragraphs(3, true),
            'category'        => $category,
            'author'          => fake()->randomElement($authors),
            'target_audience' => fake()->randomElement(['all', 'alumni', 'students']),
            'priority'        => fake()->randomElement(['normal', 'normal', 'important', 'urgent']),
            'is_active'       => true,
            'pinned'          => fake()->boolean(20),
        ];
    }

    /**
     * Indicate that the announcement is pinned to top.
     */
    public function pinned(): static
    {
        return $this->state(fn (array $attributes) => [
            'pinned' => true,
        ]);
    }

    /**
     * Indicate that the announcement has urgent priority.
     */
    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'urgent',
        ]);
    }

    /**
     * Career-specific announcement state.
     */
    public function career(): static
    {
        return $this->state(fn (array $attributes) => [
            'category'        => 'career',
            'target_audience' => 'students',
        ]);
    }

    /**
     * Event-specific announcement state.
     */
    public function event(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'event',
        ]);
    }

    /**
     * Mentorship-specific announcement state.
     */
    public function mentorship(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'mentorship',
        ]);
    }
}
