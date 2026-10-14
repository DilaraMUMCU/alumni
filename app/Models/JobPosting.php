<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobPosting extends Model
{
    use HasFactory;

    protected $table = 'job_postings';

    protected $fillable = [
        'user_id',
        'title',
        'company',
        'location',
        'employment_type',
        'description',
        'application_url',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
