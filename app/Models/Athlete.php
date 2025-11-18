<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     * @var string
     */
    protected $table = 'athletes';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone', // Nomor telepon atlet, bisa digunakan untuk identifikasi
        'birth_date',
        'address',
    ];

    /**
     * Atribut yang harus dikonversi ke tipe data tertentu (casts).
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date',
    ];
}
