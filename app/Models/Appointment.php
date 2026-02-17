<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'student_id',
        'counselor_id',
        'concern_id',
        'appointment_date',
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

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    public function concern()
    {
        return $this->belongsTo(Concern::class, 'concern_id');
    }
}
