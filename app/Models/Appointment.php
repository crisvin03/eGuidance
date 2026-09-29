<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'student_id',
        'client_name',
        'counselor_id',
        'concern_id',
        'requester_type',
        'appointment_date',
        'purpose',
        'status',
        'notes',
        'cancellation_reason'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Display name for the client of this appointment.
     * Falls back to client_name when no student account is linked (walk-in clients).
     */
    public function getClientDisplayNameAttribute(): string
    {
        return $this->student?->name
            ?? $this->client_name
            ?? 'Unknown Client';
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    public function concern()
    {
        return $this->belongsTo(Concern::class, 'concern_id');
    }

    public function sessionNotes()
    {
        return $this->hasMany(SessionNote::class);
    }
}
