<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherFormSubmission extends Model
{
    protected $fillable = [
        'teacher_id',
        'form_type',
        'form_title',
        'student_name',
        'grade_section',
        'form_data',
        'status',
        'counselor_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'form_data' => 'array',
        'reviewed_at' => 'datetime',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'submitted'    => 'warning',
            'reviewed'     => 'info',
            'acknowledged' => 'success',
            default        => 'secondary',
        };
    }
}
