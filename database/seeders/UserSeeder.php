<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // HANYA buat 1 Akun Admin Utama. 
        // Semua akun lain (Pelatih/Atlet) akan dibuat melalui UI Admin.
        User::create([
            'name' => 'Owner Alif M.kom',
            'email' => 'admin@damerta.com', 
            // *** NOMOR HP INI ADALAH KREDENSIAL LOGIN ANDA ***
            'phone' => '081234567890', 
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        // PENTING: Pastikan kolom 'phone' dan 'role' ada di $fillable di model App\Models\User
    }
}
