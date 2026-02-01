<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; 
use App\Models\Attendance; // Import Model Attendance
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AthleteController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna dengan peran 'atlet'.
     */
    public function index()
    {
        // Mengambil user dengan role 'atlet' dan menghitung relasi 'attendances'
        // Nama relasi harus sama dengan fungsi di User.php yaitu attendances()
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

        // Karena atlet dihapus, sebaiknya presensinya juga dihapus otomatis
        $athlete->attendances()->delete();
        $athlete->delete();

        return redirect()->route('admin.athletes.index')->with('success', 'Akun Atlet berhasil dihapus.');
    }

    /**
     * Fitur Konfirmasi Pembayaran: Reset Kehadiran menjadi 0
     */
    public function resetAttendance($id)
    {
        try {
            // 1. Cari user berdasarkan ID
            $athlete = User::where('id', $id)->where('role', 'atlet')->firstOrFail();

            // 2. Jalankan penghapusan data presensi melalui relasi hasMany
            // Ini akan menghapus semua baris di tabel attendances yang memiliki athlete_id = $id
            $athlete->attendances()->delete();

            // 3. Kembali ke halaman index dengan pesan sukses
            return redirect()->route('admin.athletes.index')
                             ->with('success', "Presensi untuk atlet {$athlete->name} berhasil direset menjadi 0.");

        } catch (\Exception $e) {
            Log::error("Gagal reset presensi ID {$id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal meriset data presensi. Silakan coba lagi.');
        }
    }
}