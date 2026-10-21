<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPosting extends Model
{
    use HasFactory;

    /**
     * Database table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_postings';

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
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

    /**
     * Attribute type casting.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * The alumni member who created/published this job posting.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Applications submitted to this job posting.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Candidate users who applied to this job posting.
     */
    public function applicants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'applications')
            ->withPivot('status', 'resume_url', 'cover_letter', 'applied_at')
            ->withTimestamps();
    }
}
