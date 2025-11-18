<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan model User di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // Pastikan Rule di-import untuk validasi unik

class AthleteController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna dengan peran 'atlet'.
     */
    public function index()
    {
        // Ambil semua pengguna dengan role 'atlet'
        $athletes = User::where('role', 'atlet')->get();

        // Menggunakan view 'admin.athletes' (mengacu ke resources/views/admin/athletes.blade.php)
        return view('admin.athletes', compact('athletes')); 
    }

    /**
     * Menyimpan pengguna atlet baru.
     */
    public function store(Request $request)
    {
        // PERBAIKAN: Tambahkan validasi untuk semua field yang ada di form (birth_date dan address)
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // phone_number sudah benar di Controller, sekarang tinggal disamakan di Model
            'phone_number' => ['required', 'string', 'max:15', Rule::unique('users')], 
            'birth_date' => ['nullable', 'date'], 
            'address' => ['nullable', 'string', 'max:255'], 
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // PERBAIKAN: Masukkan SEMUA data yang divalidasi ke dalam array create.
        User::create([
            'name' => $validatedData['name'],
            'phone_number' => $validatedData['phone_number'],
            'birth_date' => $validatedData['birth_date'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'password' => Hash::make($validatedData['password']),
            'role' => 'atlet', // Set role secara default
        ]);

        return redirect()->route('admin.athletes.index')->with('success', 'Akun Atlet berhasil dibuat.');
    }

    /**
     * Menghapus pengguna atlet tertentu.
     */
    public function destroy(User $athlete)
    {
        // Pastikan pengguna yang dihapus benar-benar memiliki peran 'atlet'
        if ($athlete->role !== 'atlet') {
            return redirect()->route('admin.athletes.index')->with('error', 'Tidak dapat menghapus. Pengguna bukan atlet.');
        }

        $athlete->delete();

        return redirect()->route('admin.athletes.index')->with('success', 'Akun Atlet berhasil dihapus.');
    }
}
