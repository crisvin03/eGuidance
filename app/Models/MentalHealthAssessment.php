<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MentalHealthAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assessment_type',
        'responses',
        'score',
        'risk_level',
        'counselor_notified',
        'follow_up_scheduled',
        'follow_up_date',
        'counselor_notes',
    ];

    protected $casts = [
        'responses' => 'array',
        'counselor_notified' => 'boolean',
        'follow_up_scheduled' => 'boolean',
        'follow_up_date' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getAssessmentNameAttribute()
    {
        return match($this->assessment_type) {
            'headss' => 'HEADSS Assessment',
            'gad7' => 'GAD-7 (Anxiety)',
            'phq9' => 'PHQ-9 (Depression)',
            default => 'Unknown Assessment'
        };
    }

    public function getRiskLevelColorAttribute()
    {
        return match($this->risk_level) {
            'low' => 'success',
            'mild' => 'info',
            'moderate' => 'warning',
            'moderately-high' => 'orange',
            'high' => 'danger',
            default => 'secondary'
        };
    }

    public function getRiskLevelTextAttribute()
    {
        return match($this->risk_level) {
            'low' => 'Low Risk',
            'mild' => 'Mild',
            'moderate' => 'Moderate',
            'moderately-high' => 'Moderately High',
            'high' => 'High Risk',
            default => 'Unknown'
        };
    }
}
