<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_id',
        'bulan_tahun',
        'tanggal_bayar',
        'jumlah',
        'metode_pembayaran',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'jumlah' => 'decimal:2',
    ];

    // Relasi ke User (Atlet)
    public function athlete()
    {
        return $this->belongsTo(User::class, 'athlete_id');
    }
}