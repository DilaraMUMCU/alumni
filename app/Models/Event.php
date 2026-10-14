<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'capacity',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'capacity'   => 'integer',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_registrations')->withPivot('status', 'registered_at');
    }
}
