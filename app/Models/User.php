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
        'phone_number', // WAJIB PERBAIKAN: Mengganti 'phone' menjadi 'phone_number' agar sesuai Controller/Form
        'birth_date',   // WAJIB DITAMBAH: Untuk menyimpan tanggal lahir atlet
        'address',      // WAJIB DITAMBAH: Untuk menyimpan alamat atlet
        'role',         // WAJIB: Kolom Role (admin, pelatih, atlet)
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
            'birth_date' => 'date', // DITAMBAH: Agar birth_date otomatis diubah menjadi objek Carbon
        ];
    }

    public function attendances() {
    return $this->hasMany(Attendance::class, 'athlete_id');
    }
}
