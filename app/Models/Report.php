<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_id',
        'coach_id',
        'bulan_tahun',
        'catatan_evaluasi',
    ];

    // Relasi ke User (Atlet)
    public function athlete()
    {
        return $this->belongsTo(User::class, 'athlete_id');
    }

    // Relasi ke User (Pelatih)
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}