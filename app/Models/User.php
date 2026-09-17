<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'birth_date',
        'address',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    // Relasi ke Kehadiran
    public function attendances() 
    {
        return $this->hasMany(Attendance::class, 'athlete_id');
    }

    // Relasi ke Raport (Sebagai Atlet)
    public function reports()
    {
        return $this->hasMany(Report::class, 'athlete_id');
    }

    // Relasi ke Pembayaran SPP (Sebagai Atlet)
    public function payments()
    {
        return $this->hasMany(Payment::class, 'athlete_id');
    }
}