<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // Field yang boleh diisi secara massal
    protected $fillable = [
        'coach_id',
        'athlete_id',
        'tanggal',
        'tempat',
        'materi',
        'evaluation',
    ];

    // Relasi ke User (Pelatih)
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    // Relasi ke User (Atlet)
    public function athlete()
    {
        return $this->belongsTo(User::class, 'athlete_id');
    }
}