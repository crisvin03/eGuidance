<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concern extends Model
{
    protected $fillable = [
        'student_id',
        'category_id',
        'title',
        'description',
        'status',
        'is_anonymous',
        'counselor_id',
        'priority',
        'notes',
        'counseling_date',
        'response',
        'counselor_response',
        'resolved_at'
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'counseling_date' => 'datetime',
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    public function category()
    {
        return $this->belongsTo(ConcernCategory::class, 'category_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
