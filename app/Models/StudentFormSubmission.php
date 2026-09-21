<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentFormSubmission extends Model
{
    protected $fillable = [
        'student_id',
        'form_type',
        'form_title',
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

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'submitted' => 'warning',
            'reviewed' => 'info',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }

    public function getFormTypeNameAttribute(): string
    {
        return match($this->form_type) {
            'exit_survey' => 'Curriculum Exit Survey (Annex B)',
            'personal_inventory' => 'Personal Inventory Form (Annex C)',
            'clearance_return' => 'Clearance to Return (Annex D)',
            default => 'Unknown Form',
        };
    }
}
