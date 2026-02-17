<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'student_id',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function concerns()
    {
        return $this->hasMany(Concern::class, 'student_id');
    }

    public function counselorAppointments()
    {
        return $this->hasMany(Appointment::class, 'counselor_id');
    }

    public function studentAppointments()
    {
        return $this->hasMany(Appointment::class, 'student_id');
    }

    public function sessionNotes()
    {
        return $this->hasMany(SessionNote::class, 'counselor_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function isStudent()
    {
        return $this->role_id === 1;
    }

    public function isCounselor()
    {
        return $this->role_id === 2;
    }

    public function isAdmin()
    {
        return $this->role_id === 3;
    }
}
