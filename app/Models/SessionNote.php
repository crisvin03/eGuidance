<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionNote extends Model
{
    protected $fillable = [
        'appointment_id',
        'counselor_id',
        'notes',
        'session_type',
        'recommendations',
        'is_confidential',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }
}
