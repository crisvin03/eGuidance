<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InterventionGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'content',
        'file_path',
        'file_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'adult_learner'     => 'Adult-to-Learner Protection Protocol',
            'learner_learner'   => 'Learner-to-Learner Protection Protocol',
            'learner_community' => 'Learner-to-Community Concern Protocol',
            'panic_attack'      => 'Panic Attack Classroom Response Guide',
            'referral_guide'    => 'Referral vs Classroom Management Guide',
            'career'            => 'Career Landas Toolkits',
            default             => ucfirst($this->category),
        };
    }

    public function getCategoryIconAttribute(): string
    {
        return match($this->category) {
            'adult_learner'     => 'bi-shield-exclamation',
            'learner_learner'   => 'bi-people',
            'learner_community' => 'bi-house-heart',
            'panic_attack'      => 'bi-heart-pulse',
            'referral_guide'    => 'bi-arrow-left-right',
            'career'            => 'bi-briefcase',
            default             => 'bi-book',
        };
    }
}
