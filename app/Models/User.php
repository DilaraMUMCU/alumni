<?php

namespace App\Models;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Cache;
use JsonSerializable;

/**
 * User Model (Database-independent / In-Memory & Cache-backed)
 * 
 * Provides complete CRUD operations without requiring an active database connection.
 * Persists state via Laravel Cache subsystem.
 */
class User implements ArrayAccess, Arrayable, Jsonable, JsonSerializable
{
    /**
     * Cache key used for storing users.
     */
    public const CACHE_KEY = 'alumni_users';

    /**
     * Model attributes array.
     */
    protected array $attributes = [
        'id'              => null,
        'name'            => null,
        'email'           => null,
        'role'            => null,
        'department'      => null,
        'graduation_year' => null,
        'current_company' => null,
        'job_title'       => null,
        'linkedin_url'    => null,
        'skills'          => null,
        'created_at'      => null,
        'updated_at'      => null,
    ];

    /**
     * Create a new User instance.
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Fill attributes into the model.
     */
    public function fill(array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            if (array_key_exists($key, $this->attributes)) {
                if ($key === 'id' && $value !== null) {
                    $this->attributes['id'] = (int) $value;
                } elseif ($key === 'graduation_year' && $value !== null && $value !== '') {
                    $this->attributes['graduation_year'] = (int) $value;
                } elseif ($key === 'skills' && is_string($value)) {
                    $this->attributes['skills'] = array_map('trim', explode(',', $value));
                } else {
                    $this->attributes[$key] = $value;
                }
            }
        }

        return $this;
    }

    /* -------------------------------------------------------------------------- */
    /*                             CRUD: CREATE                                   */
    /* -------------------------------------------------------------------------- */

    /**
     * Create and persist a new user without a database connection.
     *
     * @param array $attributes
     * @return self
     */
    public static function create(array $attributes): self
    {
        $rawUsers = static::getStoredUsers();

        // Calculate next auto-increment ID
        $nextId = count($rawUsers) > 0 ? (max(array_column($rawUsers, 'id')) + 1) : 1;

        $now = now()->toIso8601String();

        $userData = [
            'id'              => $nextId,
            'name'            => $attributes['name'] ?? 'Dilara Mumcu',
            'email'           => $attributes['email'] ?? 'dilara@alumni.edu',
            'role'            => $attributes['role'] ?? 'alumni',
            'department'      => $attributes['department'] ?? 'Computer Engineering',
            'graduation_year' => isset($attributes['graduation_year']) && $attributes['graduation_year'] !== ''
                ? (int) $attributes['graduation_year']
                : 2024,
            'current_company' => $attributes['current_company'] ?? 'Google',
            'job_title'       => $attributes['job_title'] ?? 'Software Engineer',
            'linkedin_url'    => $attributes['linkedin_url'] ?? 'https://linkedin.com/in/dilaramumcu',
            'skills'          => isset($attributes['skills']) && is_array($attributes['skills'])
                ? $attributes['skills']
                : ['PHP', 'Laravel', 'Docker', 'MySQL'],
            'created_at'      => $now,
            'updated_at'      => $now,
        ];

        $rawUsers[] = $userData;
        static::saveStoredUsers($rawUsers);

        return new static($userData);
    }

    /* -------------------------------------------------------------------------- */
    /*                              CRUD: READ                                    */
    /* -------------------------------------------------------------------------- */

    /**
     * Get all users as User model instances.
     *
     * @return array<self>
     */
    public static function all(): array
    {
        $rawUsers = static::getStoredUsers();

        return array_map(fn($item) => new static($item), $rawUsers);
    }

    /**
     * Find a user by their ID.
     *
     * @param int|string $id
     * @return self|null
     */
    public static function find(int|string $id): ?self
    {
        $rawUsers = static::getStoredUsers();

        foreach ($rawUsers as $item) {
            if ((string) $item['id'] === (string) $id) {
                return new static($item);
            }
        }

        return null;
    }

    /**
     * Count total stored users.
     */
    public static function count(): int
    {
        return count(static::getStoredUsers());
    }

    /**
     * Check if a user with the given ID exists.
     */
    public static function exists(int|string $id): bool
    {
        return static::find($id) !== null;
    }

    /**
     * Filter users matching a given key-value condition.
     *
     * @return array<self>
     */
    public static function where(string $key, mixed $value): array
    {
        $results = [];
        foreach (static::all() as $user) {
            if ($user->{$key} == $value) {
                $results[] = $user;
            }
        }

        return $results;
    }

    /* -------------------------------------------------------------------------- */
    /*                             CRUD: UPDATE                                   */
    /* -------------------------------------------------------------------------- */

    /**
     * Update the user model and persist to cache store.
     *
     * @param array $attributes Data attributes to update
     * @param bool $fullReplacement If true (PUT), omitted fields are reset to null. If false (PATCH), preserved.
     * @return self
     */
    public function update(array $attributes, bool $fullReplacement = false): self
    {
        $rawUsers = static::getStoredUsers();
        $targetId = $this->id;
        $foundIndex = null;

        foreach ($rawUsers as $index => $item) {
            if ((string) $item['id'] === (string) $targetId) {
                $foundIndex = $index;
                break;
            }
        }

        if ($foundIndex === null) {
            return $this;
        }

        $now = now()->toIso8601String();

        if ($fullReplacement) {
            // PUT: Full Replacement (Omitted fields reset to null)
            $newRecord = [
                'id'              => (int) $targetId,
                'name'            => $attributes['name'] ?? null,
                'email'           => $attributes['email'] ?? null,
                'role'            => $attributes['role'] ?? null,
                'department'      => $attributes['department'] ?? null,
                'graduation_year' => isset($attributes['graduation_year']) && $attributes['graduation_year'] !== ''
                    ? (int) $attributes['graduation_year']
                    : null,
                'current_company' => $attributes['current_company'] ?? null,
                'job_title'       => $attributes['job_title'] ?? null,
                'linkedin_url'    => $attributes['linkedin_url'] ?? null,
                'skills'          => isset($attributes['skills']) && is_array($attributes['skills'])
                    ? $attributes['skills']
                    : null,
                'created_at'      => $this->created_at ?? $now,
                'updated_at'      => $now,
            ];
        } else {
            // PATCH: Partial Update (Only provided fields change, omitted fields preserved)
            $newRecord = $rawUsers[$foundIndex];

            foreach ($attributes as $key => $val) {
                if (in_array($key, ['id', 'created_at', '_method', '_token'])) {
                    continue;
                }
                if ($key === 'graduation_year' && $val !== null && $val !== '') {
                    $val = (int) $val;
                }
                $newRecord[$key] = $val;
            }
            $newRecord['updated_at'] = $now;
        }

        $rawUsers[$foundIndex] = $newRecord;
        static::saveStoredUsers($rawUsers);

        $this->fill($newRecord);

        return $this;
    }

    /**
     * Static update by user ID.
     */
    public static function updateById(int|string $id, array $attributes, bool $fullReplacement = false): ?self
    {
        $user = static::find($id);
        if (!$user) {
            return null;
        }

        return $user->update($attributes, $fullReplacement);
    }

    /**
     * Save current state to the persistent cache store.
     */
    public function save(): self
    {
        $rawUsers = static::getStoredUsers();
        $found = false;

        $this->attributes['updated_at'] = now()->toIso8601String();

        foreach ($rawUsers as $index => $item) {
            if ((string) $item['id'] === (string) $this->id) {
                $rawUsers[$index] = $this->attributes;
                $found = true;
                break;
            }
        }

        if (!$found) {
            if ($this->id === null) {
                $this->id = count($rawUsers) > 0 ? (max(array_column($rawUsers, 'id')) + 1) : 1;
            }
            $this->attributes['created_at'] = $this->attributes['created_at'] ?? now()->toIso8601String();
            $rawUsers[] = $this->attributes;
        }

        static::saveStoredUsers($rawUsers);

        return $this;
    }

    /* -------------------------------------------------------------------------- */
    /*                             CRUD: DELETE                                   */
    /* -------------------------------------------------------------------------- */

    /**
     * Delete the user instance from cache store.
     */
    public function delete(): bool
    {
        return static::deleteById($this->id) !== null;
    }

    /**
     * Delete a user by ID and return the deleted instance.
     */
    public static function deleteById(int|string $id): ?self
    {
        $rawUsers = static::getStoredUsers();
        $foundIndex = null;

        foreach ($rawUsers as $index => $item) {
            if ((string) $item['id'] === (string) $id) {
                $foundIndex = $index;
                break;
            }
        }

        if ($foundIndex === null) {
            return null;
        }

        $deletedItem = $rawUsers[$foundIndex];
        array_splice($rawUsers, $foundIndex, 1);
        static::saveStoredUsers($rawUsers);

        return new static($deletedItem);
    }

    /* -------------------------------------------------------------------------- */
    /*                           STORAGE & SEED DATA                              */
    /* -------------------------------------------------------------------------- */

    /**
     * Get raw users stored in cache, initialized with seed data if empty.
     *
     * @return array
     */
    public static function getStoredUsers(): array
    {
        return Cache::get(static::CACHE_KEY, static::initialUsers());
    }

    /**
     * Persist raw users to cache store.
     */
    public static function saveStoredUsers(array $users): void
    {
        Cache::forever(static::CACHE_KEY, array_values($users));
    }

    /**
     * Reset users back to initial default seed data.
     *
     * @return array<self>
     */
    public static function reset(): array
    {
        $initial = static::initialUsers();
        static::saveStoredUsers($initial);

        return array_map(fn($item) => new static($item), $initial);
    }

    /**
     * Initial seed users definition.
     */
    public static function initialUsers(): array
    {
        return [
            [
                'id'              => 1,
                'name'            => 'Dilara Mumcu',
                'email'           => 'dilara@alumni.edu',
                'role'            => 'alumni',
                'department'      => 'Computer Engineering',
                'graduation_year' => 2024,
                'current_company' => 'Google',
                'job_title'       => 'Software Engineer',
                'linkedin_url'    => 'https://linkedin.com/in/dilaramumcu',
                'skills'          => ['PHP', 'Laravel', 'Docker', 'MySQL'],
                'created_at'      => '2024-06-15T10:00:00Z',
                'updated_at'      => '2024-06-15T10:00:00Z',
            ],
            [
                'id'              => 2,
                'name'            => 'Caner Yılmaz',
                'email'           => 'caner@alumni.edu',
                'role'            => 'alumni',
                'department'      => 'Industrial Engineering',
                'graduation_year' => 2023,
                'current_company' => 'Amazon',
                'job_title'       => 'Product Manager',
                'linkedin_url'    => 'https://linkedin.com/in/caneryilmaz',
                'skills'          => ['Agile', 'Scrum', 'Product Strategy', 'Data Analysis'],
                'created_at'      => '2023-07-20T14:30:00Z',
                'updated_at'      => '2023-07-20T14:30:00Z',
            ],
            [
                'id'              => 3,
                'name'            => 'Elif Demir',
                'email'           => 'elif@student.edu',
                'role'            => 'student',
                'department'      => 'Computer Engineering',
                'graduation_year' => 2026,
                'current_company' => 'Tech Intern at Microsoft',
                'job_title'       => 'Intern',
                'linkedin_url'    => 'https://linkedin.com/in/elifdemir',
                'skills'          => ['Python', 'Machine Learning', 'Git'],
                'created_at'      => '2025-09-01T09:15:00Z',
                'updated_at'      => '2025-09-01T09:15:00Z',
            ],
        ];
    }

    /* -------------------------------------------------------------------------- */
    /*                         CONVERSIONS & MAGIC ACCESS                         */
    /* -------------------------------------------------------------------------- */

    public function toArray(): array
    {
        return $this->attributes;
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function __get(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        if (array_key_exists($name, $this->attributes)) {
            $this->attributes[$name] = $value;
        }
    }

    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    // ArrayAccess Implementation
    public function offsetExists($offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->attributes[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if ($offset !== null && array_key_exists($offset, $this->attributes)) {
            $this->attributes[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        if (array_key_exists($offset, $this->attributes)) {
            $this->attributes[$offset] = null;
        }
    }
}
