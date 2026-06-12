<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentReferral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_number',
        'teacher_id',
        'student_name',
        'grade_section',
        'reason_for_referral',
        'observed_behavior',
        'actions_taken',
        'preferred_followup',
        'additional_notes',
        'status',
        'assigned_counselor_id',
        'counselor_notes',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'assigned_counselor_id');
    }

    public static function generateReferralNumber(): string
    {
        $prefix = 'REF-' . date('Y') . '-';
        $last = static::where('referral_number', 'like', $prefix . '%')
            ->orderByDesc('id')->first();
        $next = $last ? ((int) substr($last->referral_number, -4)) + 1 : 1;
        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'ongoing' => 'primary',
            'closed'  => 'success',
            default   => 'secondary',
        };
    }
}
