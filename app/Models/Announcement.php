<?php

namespace App\Models;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Cache;
use JsonSerializable;

/**
 * Announcement Model (Database-independent / In-Memory & Cache-backed)
 * 
 * Provides complete CRUD operations without requiring an active database connection.
 * Persists state via Laravel Cache subsystem.
 */
class Announcement implements ArrayAccess, Arrayable, Jsonable, JsonSerializable
{
    /**
     * Cache key used for storing announcements.
     */
    public const CACHE_KEY = 'alumni_announcements';

    /**
     * Model attributes array.
     */
    protected array $attributes = [
        'id'              => null,
        'title'           => null,
        'content'         => null,
        'category'        => null,
        'author'          => null,
        'target_audience' => null,
        'priority'        => null,
        'is_active'       => true,
        'pinned'          => false,
        'created_at'      => null,
        'updated_at'      => null,
    ];

    /**
     * Create a new Announcement instance.
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
                } elseif ($key === 'is_active') {
                    $this->attributes['is_active'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                } elseif ($key === 'pinned') {
                    $this->attributes['pinned'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
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
     * Create and persist a new announcement without a database connection.
     *
     * @param array $attributes
     * @return self
     */
    public static function create(array $attributes): self
    {
        $rawAnnouncements = static::getStoredAnnouncements();

        // Calculate next auto-increment ID
        $nextId = count($rawAnnouncements) > 0 ? (max(array_column($rawAnnouncements, 'id')) + 1) : 1;

        $now = now()->toIso8601String();

        $announcementData = [
            'id'              => $nextId,
            'title'           => $attributes['title'] ?? 'Yeni Duyuru Başlığı',
            'content'         => $attributes['content'] ?? 'Duyuru içerik detayları...',
            'category'        => $attributes['category'] ?? 'general',
            'author'          => $attributes['author'] ?? 'Mezunlar Koordinatörlüğü',
            'target_audience' => $attributes['target_audience'] ?? 'all',
            'priority'        => $attributes['priority'] ?? 'normal',
            'is_active'       => isset($attributes['is_active']) ? filter_var($attributes['is_active'], FILTER_VALIDATE_BOOLEAN) : true,
            'pinned'          => isset($attributes['pinned']) ? filter_var($attributes['pinned'], FILTER_VALIDATE_BOOLEAN) : false,
            'created_at'      => $now,
            'updated_at'      => $now,
        ];

        $rawAnnouncements[] = $announcementData;
        static::saveStoredAnnouncements($rawAnnouncements);

        return new static($announcementData);
    }

    /* -------------------------------------------------------------------------- */
    /*                              CRUD: READ                                    */
    /* -------------------------------------------------------------------------- */

    /**
     * Retrieve all announcements.
     *
     * @return array<self>
     */
    public static function all(): array
    {
        $raw = static::getStoredAnnouncements();

        // Sort: pinned first, then newest created_at
        usort($raw, function ($a, $b) {
            $pinnedA = !empty($a['pinned']) ? 1 : 0;
            $pinnedB = !empty($b['pinned']) ? 1 : 0;
            if ($pinnedA !== $pinnedB) {
                return $pinnedB <=> $pinnedA;
            }
            return strcmp($b['created_at'] ?? '', $a['created_at'] ?? '');
        });

        return array_map(fn($item) => new static($item), $raw);
    }

    /**
     * Find a specific announcement by its ID.
     *
     * @param int|string $id
     * @return self|null
     */
    public static function find(int|string $id): ?self
    {
        $raw = static::getStoredAnnouncements();

        foreach ($raw as $item) {
            if ((string) $item['id'] === (string) $id) {
                return new static($item);
            }
        }

        return null;
    }

    /**
     * Count total stored announcements.
     */
    public static function count(): int
    {
        return count(static::getStoredAnnouncements());
    }

    /**
     * Check if an announcement with the given ID exists.
     */
    public static function exists(int|string $id): bool
    {
        return static::find($id) !== null;
    }

    /**
     * Filter announcements matching a given key-value condition.
     *
     * @return array<self>
     */
    public static function where(string $key, mixed $value): array
    {
        $results = [];
        foreach (static::all() as $announcement) {
            if ($announcement->{$key} == $value) {
                $results[] = $announcement;
            }
        }

        return $results;
    }

    /* -------------------------------------------------------------------------- */
    /*                             CRUD: UPDATE                                   */
    /* -------------------------------------------------------------------------- */

    /**
     * Update the announcement model and persist to cache store.
     *
     * @param array $attributes Data attributes to update
     * @param bool $fullReplacement If true (PUT), omitted fields are reset to null. If false (PATCH), preserved.
     * @return self
     */
    public function update(array $attributes, bool $fullReplacement = false): self
    {
        $rawAnnouncements = static::getStoredAnnouncements();
        $targetId = $this->id;
        $foundIndex = null;

        foreach ($rawAnnouncements as $index => $item) {
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
            // PUT: Full Replacement (Omitted fields reset to defaults or null)
            $newRecord = [
                'id'              => (int) $targetId,
                'title'           => $attributes['title'] ?? null,
                'content'         => $attributes['content'] ?? null,
                'category'        => $attributes['category'] ?? 'general',
                'author'          => $attributes['author'] ?? null,
                'target_audience' => $attributes['target_audience'] ?? 'all',
                'priority'        => $attributes['priority'] ?? 'normal',
                'is_active'       => isset($attributes['is_active']) ? filter_var($attributes['is_active'], FILTER_VALIDATE_BOOLEAN) : true,
                'pinned'          => isset($attributes['pinned']) ? filter_var($attributes['pinned'], FILTER_VALIDATE_BOOLEAN) : false,
                'created_at'      => $this->created_at ?? $now,
                'updated_at'      => $now,
            ];
        } else {
            // PATCH: Partial Update (Only provided fields change, omitted fields preserved)
            $newRecord = $rawAnnouncements[$foundIndex];

            foreach ($attributes as $key => $val) {
                if (in_array($key, ['id', 'created_at', '_method', '_token'])) {
                    continue;
                }
                if ($key === 'is_active' || $key === 'pinned') {
                    $val = filter_var($val, FILTER_VALIDATE_BOOLEAN);
                }
                $newRecord[$key] = $val;
            }
            $newRecord['updated_at'] = $now;
        }

        $rawAnnouncements[$foundIndex] = $newRecord;
        static::saveStoredAnnouncements($rawAnnouncements);

        $this->fill($newRecord);

        return $this;
    }

    /**
     * Static update by announcement ID.
     */
    public static function updateById(int|string $id, array $attributes, bool $fullReplacement = false): ?self
    {
        $announcement = static::find($id);
        if (!$announcement) {
            return null;
        }

        return $announcement->update($attributes, $fullReplacement);
    }

    /* -------------------------------------------------------------------------- */
    /*                             CRUD: DELETE                                   */
    /* -------------------------------------------------------------------------- */

    /**
     * Delete this announcement from storage.
     *
     * @return bool
     */
    public function delete(): bool
    {
        return static::deleteById($this->id) !== null;
    }

    /**
     * Delete an announcement by its ID.
     *
     * @param int|string $id
     * @return self|null Returns deleted Announcement instance on success, null if not found
     */
    public static function deleteById(int|string $id): ?self
    {
        $rawAnnouncements = static::getStoredAnnouncements();
        $foundIndex = null;
        $deletedRecord = null;

        foreach ($rawAnnouncements as $index => $item) {
            if ((string) $item['id'] === (string) $id) {
                $foundIndex = $index;
                $deletedRecord = $item;
                break;
            }
        }

        if ($foundIndex === null) {
            return null;
        }

        array_splice($rawAnnouncements, $foundIndex, 1);
        static::saveStoredAnnouncements($rawAnnouncements);

        return new static($deletedRecord);
    }

    /* -------------------------------------------------------------------------- */
    /*                           STORAGE & SEED DATA                              */
    /* -------------------------------------------------------------------------- */

    /**
     * Get raw announcements stored in cache, initialized with seed data if empty.
     *
     * @return array
     */
    public static function getStoredAnnouncements(): array
    {
        return Cache::get(static::CACHE_KEY, static::initialAnnouncements());
    }

    /**
     * Persist raw announcements to cache store.
     */
    public static function saveStoredAnnouncements(array $announcements): void
    {
        Cache::forever(static::CACHE_KEY, array_values($announcements));
    }

    /**
     * Reset announcements back to initial default seed data.
     *
     * @return array<self>
     */
    public static function reset(): array
    {
        $initial = static::initialAnnouncements();
        static::saveStoredAnnouncements($initial);

        return array_map(fn($item) => new static($item), $initial);
    }

    /**
     * Initial seed announcements definition.
     */
    public static function initialAnnouncements(): array
    {
        return [
            [
                'id'              => 1,
                'title'           => '2026 Yıllık Mezunlar Buluşması ve Kariyer Zirvesi',
                'content'         => 'Değerli mezunlarımız ve öğrencilerimiz; bu yıl 15 Mayıs\'ta ana kampüs kongre merkezinde gerçekleştireceğimiz Mezunlar Buluşması\'na davetlisiniz. Teknoloji, finans ve mühendislik alanında lider mezunlarımızla networking oturumları ve panel tartışmaları düzenlenecektir.',
                'category'        => 'event',
                'author'          => 'Mezunlar Koordinatörlüğü',
                'target_audience' => 'all',
                'priority'        => 'urgent',
                'is_active'       => true,
                'pinned'          => true,
                'created_at'      => '2026-04-01T09:00:00Z',
                'updated_at'      => '2026-04-01T09:00:00Z',
            ],
            [
                'id'              => 2,
                'title'           => 'Google & Amazon Mezun Ağı Üzerinden Referanslı Staj Programı',
                'content'         => 'Bilgisayar ve Endüstri Mühendisliği son sınıf öğrencileri ve yeni mezunlar için global teknoloji şirketlerinde mezun referanslı staj ve iş imkanları açılmıştır. Alumni portalından profilinizi güncelleyerek özgeçmişinizi iletebilirsiniz.',
                'category'        => 'career',
                'author'          => 'Kariyer Merkezi & Mezunlar Derneği',
                'target_audience' => 'students',
                'priority'        => 'important',
                'is_active'       => true,
                'pinned'          => false,
                'created_at'      => '2026-04-10T14:30:00Z',
                'updated_at'      => '2026-04-10T14:30:00Z',
            ],
            [
                'id'              => 3,
                'title'           => 'Alumni 2026-2027 Dönemi Mezun-Öğrenci Mentorluk Başvuruları Başladı',
                'content'         => 'Sektörde en az 2 yıl deneyimi olan mezunlarımız ile kariyerine yön vermek isteyen 3. ve 4. sınıf öğrencilerimizi bir araya getiren birebir mentorluk programımızın yeni dönem kayıtları başlamıştır.',
                'category'        => 'mentorship',
                'author'          => 'Öğrenci Dekanlığı',
                'target_audience' => 'alumni',
                'priority'        => 'normal',
                'is_active'       => true,
                'pinned'          => false,
                'created_at'      => '2026-04-15T11:00:00Z',
                'updated_at'      => '2026-04-15T11:00:00Z',
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

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->attributes[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->attributes[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->attributes[$offset]);
    }

    public function __get(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->fill([$name => $value]);
    }

    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }
}
