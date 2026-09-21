<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentSubmission extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'content',
        'student_id',
        'status',
        'counselor_notes',
        'reviewed_by',
        'reviewed_at',
        'is_featured',
        'is_anonymous',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_anonymous' => 'boolean',
    ];

    /**
     * Get the student who made this submission
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the counselor who reviewed this submission
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get the type label
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'poetry' => 'Poetry & Stories',
            'artwork' => 'Artwork',
            'photography' => 'Photography',
            default => $this->type
        };
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) return 'N/A';
        
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'modern-badge-warning',
            'approved' => 'modern-badge-success',
            'rejected' => 'modern-badge-danger',
            default => 'modern-badge-secondary'
        };
    }

    /**
     * Check if submission has file attachment
     */
    public function hasFile(): bool
    {
        return !empty($this->file_path);
    }

    /**
     * Scope for specific type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for specific status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for featured submissions
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
