<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * User Model (Eloquent ORM with Two-Tier & Factory Support)
 * 
 * Provides complete CRUD operations mapping to the MySQL 'users' table.
 * Fully compatible with Eloquent Factories, Relationships, and legacy helper methods.
 */
class User extends Model
{
    use HasFactory;

    /**
     * Cache key for backward compatibility.
     */
    public const CACHE_KEY = 'alumni_users';

    /**
     * Database table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'department',
        'graduation_year',
        'current_company',
        'job_title',
        'linkedin_url',
        'skills',
    ];

    /**
     * Type casts for attributes.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'skills'          => 'array',
        'graduation_year' => 'integer',
    ];

    /* -------------------------------------------------------------------------- */
    /*                                 MUTATORS                                   */
    /* -------------------------------------------------------------------------- */

    /**
     * Automatically cast comma-separated strings or arrays into JSON skills.
     */
    public function setSkillsAttribute(mixed $value): void
    {
        if (is_string($value)) {
            $parsed = array_values(array_filter(array_map('trim', explode(',', $value))));
            $this->attributes['skills'] = json_encode($parsed);
        } elseif (is_array($value)) {
            $this->attributes['skills'] = json_encode(array_values($value));
        } else {
            $this->attributes['skills'] = null;
        }
    }

    /**
     * Accessor for skills guaranteeing an array return value.
     */
    public function getSkillsAttribute(mixed $value): array
    {
        if (empty($value)) {
            return [];
        }
        return is_array($value) ? $value : (json_decode($value, true) ?: []);
    }

    /* -------------------------------------------------------------------------- */
    /*                              RELATIONSHIPS                                 */
    /* -------------------------------------------------------------------------- */

    public function jobPostings(): HasMany
    {
        return $this->hasMany(JobPosting::class);
    }

    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_registrations')->withPivot('status', 'registered_at');
    }

    public function mentorRelationships(): HasMany
    {
        return $this->hasMany(MentorshipRelationship::class, 'mentor_id');
    }

    public function menteeRelationships(): HasMany
    {
        return $this->hasMany(MentorshipRelationship::class, 'mentee_id');
    }

    /* -------------------------------------------------------------------------- */
    /*                         CRUD COMPATIBILITY HELPERS                         */
    /* -------------------------------------------------------------------------- */

    /**
     * Update model supporting partial (PATCH) and full replacement (PUT).
     */
    public function update(array $attributes = [], $options = []): bool
    {
        $fullReplacement = is_bool($options) ? $options : (is_array($options) && ($options['fullReplacement'] ?? false));

        if ($fullReplacement) {
            $defaultFields = [
                'name'            => null,
                'email'           => null,
                'role'            => 'alumni',
                'department'      => null,
                'graduation_year' => null,
                'current_company' => null,
                'job_title'       => null,
                'linkedin_url'    => null,
                'skills'          => null,
            ];
            $attributes = array_merge($defaultFields, $attributes);
        }

        return parent::update($attributes, is_array($options) ? $options : []);
    }

    /**
     * Update a user record by ID.
     */
    public static function updateById(int|string $id, array $attributes, bool $fullReplacement = false): ?self
    {
        $user = static::find($id);
        if ($user) {
            $user->update($attributes, $fullReplacement);
            return $user;
        }
        return null;
    }

    /**
     * Delete a user record by ID.
     */
    public static function deleteById(int|string $id): ?self
    {
        $user = static::find($id);
        if ($user) {
            $user->delete();
            return $user;
        }
        return null;
    }

    /**
     * Reset users back to initial default seed data.
     */
    public static function reset(): array
    {
        // Disable foreign key checks for clean truncation
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        static::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        foreach (static::initialUsers() as $data) {
            static::create($data);
        }

        return static::all()->all();
    }

    /**
     * Initial seed users definition.
     */
    public static function initialUsers(): array
    {
        return [
            [
                'name'            => 'Dilara Mumcu',
                'email'           => 'dilara@alumni.edu',
                'role'            => 'alumni',
                'department'      => 'Computer Engineering',
                'graduation_year' => 2024,
                'current_company' => 'Google',
                'job_title'       => 'Software Engineer',
                'linkedin_url'    => 'https://linkedin.com/in/dilaramumcu',
                'skills'          => ['PHP', 'Laravel', 'Docker', 'MySQL'],
            ],
            [
                'name'            => 'Caner Yılmaz',
                'email'           => 'caner@alumni.edu',
                'role'            => 'alumni',
                'department'      => 'Industrial Engineering',
                'graduation_year' => 2023,
                'current_company' => 'Amazon',
                'job_title'       => 'Product Manager',
                'linkedin_url'    => 'https://linkedin.com/in/caneryilmaz',
                'skills'          => ['Agile', 'Scrum', 'Product Strategy', 'Data Analysis'],
            ],
            [
                'name'            => 'Elif Demir',
                'email'           => 'elif@student.edu',
                'role'            => 'student',
                'department'      => 'Computer Engineering',
                'graduation_year' => 2026,
                'current_company' => 'Tech Intern at Microsoft',
                'job_title'       => 'Intern',
                'linkedin_url'    => 'https://linkedin.com/in/elifdemir',
                'skills'          => ['Python', 'Machine Learning', 'Git'],
            ],
        ];
    }
}
