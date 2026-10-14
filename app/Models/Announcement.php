<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Announcement Model (Eloquent ORM with Two-Tier & Factory Support)
 * 
 * Provides complete CRUD operations mapping to the MySQL 'announcements' table.
 * Fully compatible with Eloquent Factories and legacy helper methods.
 */
class Announcement extends Model
{
    use HasFactory;

    /**
     * Cache key for backward compatibility.
     */
    public const CACHE_KEY = 'alumni_announcements';

    /**
     * Database table associated with the model.
     *
     * @var string
     */
    protected $table = 'announcements';

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'category',
        'author',
        'target_audience',
        'priority',
        'is_active',
        'pinned',
    ];

    /**
     * Type casts for attributes.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'pinned'    => 'boolean',
    ];

    /* -------------------------------------------------------------------------- */
    /*                                 MUTATORS                                   */
    /* -------------------------------------------------------------------------- */

    public function setPinnedAttribute(mixed $value): void
    {
        $this->attributes['pinned'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function setIsActiveAttribute(mixed $value): void
    {
        $this->attributes['is_active'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
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
                'title'           => null,
                'content'         => null,
                'category'        => 'general',
                'author'          => null,
                'target_audience' => 'all',
                'priority'        => 'normal',
                'is_active'       => true,
                'pinned'          => false,
            ];
            $attributes = array_merge($defaultFields, $attributes);
        }

        return parent::update($attributes, is_array($options) ? $options : []);
    }

    /**
     * Update an announcement by ID.
     */
    public static function updateById(int|string $id, array $attributes, bool $fullReplacement = false): ?self
    {
        $announcement = static::find($id);
        if ($announcement) {
            $announcement->update($attributes, $fullReplacement);
            return $announcement;
        }
        return null;
    }

    /**
     * Delete an announcement by ID.
     */
    public static function deleteById(int|string $id): ?self
    {
        $announcement = static::find($id);
        if ($announcement) {
            $announcement->delete();
            return $announcement;
        }
        return null;
    }

    /**
     * Reset announcements back to initial default seed data.
     */
    public static function reset(): array
    {
        static::truncate();

        foreach (static::initialAnnouncements() as $data) {
            static::create($data);
        }

        return static::all()->all();
    }

    /**
     * Initial seed announcements definition.
     */
    public static function initialAnnouncements(): array
    {
        return [
            [
                'title'           => '2026 Yıllık Mezunlar Buluşması ve Kariyer Zirvesi',
                'content'         => 'Değerli mezunlarımız ve öğrencilerimiz; bu yıl 15 Mayıs\'ta ana kampüs kongre merkezinde gerçekleştireceğimiz Mezunlar Buluşması\'na davetlisiniz. Teknoloji, finans ve mühendislik alanında lider mezunlarımızla networking oturumları ve panel tartışmaları düzenlenecektir.',
                'category'        => 'event',
                'author'          => 'Mezunlar Koordinatörlüğü',
                'target_audience' => 'all',
                'priority'        => 'urgent',
                'is_active'       => true,
                'pinned'          => true,
            ],
            [
                'title'           => 'Google & Amazon Mezun Ağı Üzerinden Referanslı Staj Programı',
                'content'         => 'Bilgisayar ve Endüstri Mühendisliği son sınıf öğrencileri ve yeni mezunlar için global teknoloji şirketlerinde mezun referanslı staj ve iş imkanları açılmıştır. Alumni portalından profilinizi güncelleyerek özgeçmişinizi iletebilirsiniz.',
                'category'        => 'career',
                'author'          => 'Kariyer Merkezi & Mezunlar Derneği',
                'target_audience' => 'students',
                'priority'        => 'important',
                'is_active'       => true,
                'pinned'          => false,
            ],
            [
                'title'           => 'Alumni 2026-2027 Dönemi Mezun-Öğrenci Mentorluk Başvuruları Başladı',
                'content'         => 'Sektörde en az 2 yıl deneyimi olan mezunlarımız ile kariyerine yön vermek isteyen 3. ve 4. sınıf öğrencilerimizi bir araya getiren birebir mentorluk programımızın yeni dönem kayıtları başlamıştır.',
                'category'        => 'mentorship',
                'author'          => 'Öğrenci Dekanlığı',
                'target_audience' => 'alumni',
                'priority'        => 'normal',
                'is_active'       => true,
                'pinned'          => false,
            ],
        ];
    }
}
