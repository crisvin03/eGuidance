<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncidentReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_number',
        'teacher_id',
        'student_name',
        'student_address',
        'student_age',
        'grade_section',
        'date_of_referral',
        'time_of_incident',
        'incident_category',
        'concern_type',
        'incident_description',
        'initial_intervention',
        'parent_guardian_name',
        'parent_guardian_contact',
        'referred_by_name',
        'referred_by_designation',
        'urgency_level',
        'attachment_path',
        'attachment_name',
        'status',
        'assigned_counselor_id',
        'counselor_notes',
    ];

    protected $casts = [
        'date_of_referral' => 'date',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'assigned_counselor_id');
    }

    public static function generateCaseNumber(): string
    {
        $prefix = 'IR-' . date('Y') . '-';
        $lastCase = static::where('case_number', 'like', $prefix . '%')
            ->orderByDesc('id')->first();
        $next = $lastCase ? ((int) substr($lastCase->case_number, -4)) + 1 : 1;
        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function getIncidentCategoryLabelAttribute(): string
    {
        return match($this->incident_category) {
            'bullying'          => 'Bullying',
            'behavioral_concern'=> 'Behavioral Concern',
            'mental_health'     => 'Mental Health Concern',
            'academic_risk'     => 'Academic Risk',
            'child_protection'  => 'Child Protection Concern',
            'classroom_incident'=> 'Classroom Incident',
            default             => ucfirst($this->incident_category),
        };
    }

    public function getConcernTypeLabelAttribute(): string
    {
        return match($this->concern_type) {
            'academic'              => 'Academic',
            'emotional_mental'      => 'Emotional and Mental Wellness',
            'social_peer'           => 'Social and Peer',
            'family'                => 'Family',
            'behavioral'            => 'Behavioral',
            'personal_relationship' => 'Personal and Relationship',
            'bullying_safety'       => 'Bullying/Safety',
            'career_future'         => 'Career and Future',
            'counseling_support'    => 'Counseling and Support',
            default                 => ucfirst(str_replace('_', ' ', $this->concern_type)),
        };
    }

    public function getUrgencyBadgeAttribute(): string
    {
        return match($this->urgency_level) {
            'high'     => 'danger',
            'moderate' => 'warning',
            default    => 'success',
        };
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
