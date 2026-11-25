<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User Model (Eloquent ORM & Authenticatable with Role-Based Helpers)
 *
 * Provides complete CRUD operations mapping to the MySQL 'users' table,
 * authentication contracts, and RBAC helper predicates.
 */
class User extends Authenticatable
{
    use HasFactory;

    public const ROLE_UNVERIFIED = 'unverified';
    public const ROLE_STUDENT    = 'student';
    public const ROLE_ALUMNI     = 'alumni';
    public const ROLE_ACADEMICS  = 'academics';
    public const ROLE_ADMIN      = 'admin';

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
        'password',
        'role',
        'department',
        'graduation_year',
        'current_company',
        'job_title',
        'linkedin_url',
        'skills',
    ];

    /**
     * Attributes hidden from array and JSON serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
    /*                          ROLE & RBAC PREDICATES                            */
    /* -------------------------------------------------------------------------- */

    public function isUnverified(): bool
    {
        return $this->role === self::ROLE_UNVERIFIED;
    }

    public function isVerified(): bool
    {
        return $this->role !== self::ROLE_UNVERIFIED;
    }

    public function isStudent(): bool
    {
        return $this->role === self::ROLE_STUDENT;
    }

    public function isAlumni(): bool
    {
        return $this->role === self::ROLE_ALUMNI;
    }

    public function isAcademics(): bool
    {
        return in_array($this->role, [self::ROLE_ACADEMICS, 'academician'], true);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function canApplyToJobs(): bool
    {
        return in_array($this->role, [self::ROLE_STUDENT, self::ROLE_ALUMNI], true);
    }

    public function canCreateEvents(): bool
    {
        return in_array($this->role, [self::ROLE_ACADEMICS, 'academician', self::ROLE_ADMIN], true);
    }

    public function canPublishJobs(): bool
    {
        return in_array($this->role, [self::ROLE_ALUMNI, self::ROLE_ADMIN], true);
    }

    /**
     * Resolve human-readable Turkish role label.
     */
    public static function formatRoleLabel(?string $role): string
    {
        return match ($role) {
            self::ROLE_UNVERIFIED => 'Doğrulanmamış',
            self::ROLE_STUDENT    => 'Öğrenci',
            self::ROLE_ALUMNI     => 'Mezun',
            self::ROLE_ACADEMICS, 'academician' => 'Akademisyen',
            self::ROLE_ADMIN      => 'Yönetici',
            default               => 'Doğrulanmamış',
        };
    }

    /**
     * Resolve CSS badge class for a given role.
     */
    public static function formatRoleBadgeClass(?string $role): string
    {
        return match ($role) {
            self::ROLE_UNVERIFIED => 'badge-neutral',
            self::ROLE_STUDENT    => 'badge-amber',
            self::ROLE_ALUMNI     => 'badge-crimson',
            self::ROLE_ACADEMICS, 'academician' => 'badge-gold',
            self::ROLE_ADMIN      => 'badge-navy',
            default               => 'badge-neutral',
        };
    }

    /**
     * Dynamically build navigation menu items based on the current user's role.
     *
     * @return array<int, array{label: string, url: string, pattern: string}>
     */
    public static function navigationItems(?self $user = null): array
    {
        // Guests (Unauthenticated visitors)
        if (!$user) {
            return [
                ['label' => 'Ana Sayfa', 'url' => '/', 'pattern' => '/'],
                ['label' => 'İş & Staj İlanları', 'url' => '/job-postings', 'pattern' => 'job-postings*'],
                ['label' => 'Duyurular', 'url' => '/announcements', 'pattern' => 'announcements*'],
                ['label' => 'Hakkımızda', 'url' => '/about', 'pattern' => 'about'],
            ];
        }

        $role = $user->role === 'academician' ? self::ROLE_ACADEMICS : $user->role;

        return match ($role) {
            self::ROLE_ADMIN => [
                ['label' => 'Ana Sayfa', 'url' => '/', 'pattern' => '/'],
                ['label' => 'Admin Paneli', 'url' => '/admin', 'pattern' => 'admin*'],
                ['label' => 'Mezunlar & Öğrenciler', 'url' => '/users', 'pattern' => 'users*'],
                ['label' => 'İş & Staj İlanları', 'url' => '/job-postings', 'pattern' => 'job-postings*'],
                ['label' => 'Başvurular', 'url' => '/applications', 'pattern' => 'applications*'],
                ['label' => 'Duyurular', 'url' => '/announcements', 'pattern' => 'announcements*'],
            ],
            self::ROLE_ACADEMICS => [
                ['label' => 'Ana Sayfa', 'url' => '/', 'pattern' => '/'],
                ['label' => 'Mezunlar & Öğrenciler', 'url' => '/users', 'pattern' => 'users*'],
                ['label' => 'Duyurular & Etkinlikler', 'url' => '/announcements', 'pattern' => 'announcements*'],
                ['label' => 'Hakkımızda', 'url' => '/about', 'pattern' => 'about'],
            ],
            self::ROLE_ALUMNI => [
                ['label' => 'Ana Sayfa', 'url' => '/', 'pattern' => '/'],
                ['label' => 'Mezunlar & Öğrenciler', 'url' => '/users', 'pattern' => 'users*'],
                ['label' => 'İş & Staj İlanları', 'url' => '/job-postings', 'pattern' => 'job-postings*'],
                ['label' => 'Başvurular', 'url' => '/applications', 'pattern' => 'applications*'],
                ['label' => 'Duyurular', 'url' => '/announcements', 'pattern' => 'announcements*'],
            ],
            self::ROLE_STUDENT => [
                ['label' => 'Ana Sayfa', 'url' => '/', 'pattern' => '/'],
                ['label' => 'Mezunlar & Öğrenciler', 'url' => '/users', 'pattern' => 'users*'],
                ['label' => 'İş & Staj İlanları', 'url' => '/job-postings', 'pattern' => 'job-postings*'],
                ['label' => 'Başvurularım', 'url' => '/applications?user_id=' . $user->id, 'pattern' => 'applications*'],
                ['label' => 'Duyurular', 'url' => '/announcements', 'pattern' => 'announcements*'],
            ],
            // Default / Unverified new users
            default => [
                ['label' => 'Ana Sayfa', 'url' => '/', 'pattern' => '/'],
                ['label' => 'Profilim', 'url' => '/users/' . $user->id, 'pattern' => 'users/' . $user->id . '*'],
                ['label' => 'İş & Staj İlanları', 'url' => '/job-postings', 'pattern' => 'job-postings*'],
                ['label' => 'Duyurular', 'url' => '/announcements', 'pattern' => 'announcements*'],
                ['label' => 'Hakkımızda', 'url' => '/about', 'pattern' => 'about'],
            ],
        };
    }

    /**
     * Dynamically resolve the primary CTA button in the navbar based on user role.
     *
     * @return array{label: string, url: string, class: string}|null
     */
    public static function primaryNavAction(?self $user = null): ?array
    {
        if (!$user) {
            return ['label' => 'Kayıt Ol', 'url' => '/register', 'class' => 'btn btn-primary btn-sm'];
        }

        $role = $user->role === 'academician' ? self::ROLE_ACADEMICS : $user->role;

        return match ($role) {
            self::ROLE_ADMIN     => ['label' => 'İlan Yayınla', 'url' => '/job-postings/create', 'class' => 'btn btn-primary btn-sm'],
            self::ROLE_ALUMNI    => ['label' => 'İlan Yayınla', 'url' => '/job-postings/create', 'class' => 'btn btn-primary btn-sm'],
            self::ROLE_ACADEMICS => ['label' => 'Duyuru Yayınla', 'url' => '/announcements/create', 'class' => 'btn btn-primary btn-sm'],
            self::ROLE_STUDENT   => ['label' => 'Başvuru Yap', 'url' => '/applications/create', 'class' => 'btn btn-primary btn-sm'],
            default              => null, // 'unverified' users have no privileged creation CTA
        };
    }

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

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function appliedJobs(): BelongsToMany
    {
        return $this->belongsToMany(JobPosting::class, 'applications')
            ->withPivot('status', 'resume_url', 'cover_letter', 'applied_at')
            ->withTimestamps();
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
    public function update(array $attributes = [], mixed $options = [], bool $fullReplacement = false): bool
    {
        $isFull = $fullReplacement || (is_bool($options) ? $options : (is_array($options) && ($options['fullReplacement'] ?? false)));

        if ($isFull) {
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
