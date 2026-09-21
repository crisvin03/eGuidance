<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionNote extends Model
{
    protected $fillable = [
        'appointment_id',
        'concern_id',
        'counselor_id',
        'title',
        'notes',
        'session_type',
        'recommendations',
        'follow_up_date',
        'is_confidential',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
        'is_confidential' => 'boolean',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function concern()
    {
        return $this->belongsTo(Concern::class);
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    /**
     * Get the parent record (appointment or concern)
     */
    public function getParentAttribute()
    {
        return $this->appointment ?: $this->concern;
    }

    /**
     * Scope to get notes for a specific concern
     */
    public function scopeForConcern($query, $concernId)
    {
        return $query->where('concern_id', $concernId)->orderBy('created_at', 'desc');
    }

    /**
     * Scope to get notes for a specific appointment
     */
    public function scopeForAppointment($query, $appointmentId)
    {
        return $query->where('appointment_id', $appointmentId)->orderBy('created_at', 'desc');
    }
}
