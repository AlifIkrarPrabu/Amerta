<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AthleteController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna dengan peran 'atlet' beserta fitur pencarian dan pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Mengambil user dengan role 'atlet', memfilter jika ada pencarian, dan membuat pagination 5 data per halaman
        $athletes = User::where('role', 'atlet')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('phone_number', 'like', "%{$search}%");
                });
            })
            ->withCount('attendances') 
            ->paginate(5)
            ->withQueryString(); // Mempertahankan parameter 'search' di URL saat berpindah halaman

        // Mengambil daftar pelatih untuk dropdown di modal penyesuaian presensi
        $coaches = User::where('role', 'pelatih')->get();

        return view('admin.athletes', compact('athletes', 'coaches', 'search')); 
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
     * Menambahkan presensi manual oleh Admin untuk penyesuaian sesi latihan atlet.
     */
    public function addAttendance(Request $request, User $athlete)
    {
        if ($athlete->role !== 'atlet') {
            return redirect()->route('admin.athletes.index')->with('error', 'Gagal menambahkan presensi. Pengguna bukan atlet.');
        }

        $validatedData = $request->validate([
            'coach_id' => ['required', 'exists:users,id'],
            'tanggal'  => ['required', 'date'],
            'tempat'   => ['required', 'string', 'max:255'],
            'materi'   => ['nullable', 'string'],
        ]);

        Attendance::create([
            'athlete_id' => $athlete->id,
            'coach_id'   => $validatedData['coach_id'],
            'tanggal'    => $validatedData['tanggal'],
            'tempat'     => $validatedData['tempat'],
            'materi'     => $validatedData['materi'] ?? 'Penyesuaian Sesi Manual oleh Admin',
        ]);

        return redirect()->route('admin.athletes.index')->with('success', 'Sesi latihan atlet ' . $athlete->name . ' berhasil ditambahkan.');
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