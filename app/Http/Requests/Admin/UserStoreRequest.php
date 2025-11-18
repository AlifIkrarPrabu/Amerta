<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan membuat permintaan ini.
     * Ini adalah otorisasi. Hanya Admin yang boleh.
     */
    public function authorize(): bool
    {
        // Memastikan pengguna yang sedang login memiliki role 'admin'
        return $this->user() && $this->user()->role === 'admin';
    }

    /**
     * Dapatkan aturan validasi.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            
            // PENTING: Nomor HP harus unik dan wajib diisi (mengatasi masalah login Ahsan).
            'phone' => ['required', 'string', 'min:10', 'max:15', 'unique:users', 'regex:/^(\+62|0)8[0-9]{8,12}$/'],
            
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // Peran hanya boleh 'pelatih' atau 'atlet'
            'role' => ['required', 'string', Rule::in(['pelatih', 'atlet'])],
        ];
    }
    
    /**
     * Kustomisasi pesan kesalahan (Agar lebih mudah dipahami).
     */
    public function messages(): array
    {
        return [
            'phone.unique' => 'Nomor Telepon ini sudah terdaftar. Gunakan yang lain.',
            'phone.required' => 'Nomor Telepon wajib diisi untuk login.',
            'phone.regex' => 'Format Nomor Telepon tidak valid (gunakan format 08...).',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
