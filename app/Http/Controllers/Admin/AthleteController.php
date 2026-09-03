<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AthleteController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna dengan peran 'atlet'.
     */
    public function index()
    {
        // Mengambil user dengan role 'atlet' dan menghitung relasi 'attendances'
        $athletes = User::where('role', 'atlet')
            ->withCount('attendances') 
            ->get();

        return view('admin.athletes', compact('athletes')); 
    }

    /**
     * Menyimpan pengguna atlet baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:15', Rule::unique('users')], 
            'birth_date' => ['nullable', 'date'], 
            'address' => ['nullable', 'string', 'max:255'], 
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validatedData['name'],
            'phone_number' => $validatedData['phone_number'],
            'birth_date' => $validatedData['birth_date'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'password' => Hash::make($validatedData['password']),
            'role' => 'atlet',
        ]);

        return redirect()->route('admin.athletes.index')->with('success', 'Akun Atlet berhasil dibuat.');
    }

    /**
     * Menghapus pengguna atlet tertentu.
     */
    public function destroy(User $athlete)
    {
        if ($athlete->role !== 'atlet') {
            return redirect()->route('admin.athletes.index')->with('error', 'Tidak dapat menghapus. Pengguna bukan atlet.');
        }

        // Hapus data presensi terkait sebelum menghapus akun atlet
        $athlete->attendances()->delete();
        $athlete->delete();

        return redirect()->route('admin.athletes.index')->with('success', 'Akun Atlet berhasil dihapus.');
    }
}