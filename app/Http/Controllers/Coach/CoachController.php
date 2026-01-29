<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\User; 
use App\Models\Attendance; // Pastikan model ini sudah dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoachController extends Controller
{
    /**
     * Menampilkan halaman dashboard presensi pelatih
     */
    public function index()
    {
        $user = Auth::user();
        
        // 1. MENGAMBIL DATA ATLET
        $athletes = User::where('role', 'atlet')->get();

        // 2. MENGAMBIL RIWAYAT PRESENSI
        // Kita ambil data unik berdasarkan tanggal, tempat, dan materi 
        // agar tidak muncul double jika satu sesi ada banyak atlet.
        // Kita gunakan groupBy atau manual grouping untuk dashboard.
        $attendanceHistory = Attendance::where('coach_id', Auth::id())
            ->select('tanggal', 'tempat', 'materi', DB::raw('count(athlete_id) as athletes_count'))
            ->groupBy('tanggal', 'tempat', 'materi')
            ->orderBy('tanggal', 'desc')
            ->limit(10) // Tampilkan 10 riwayat terakhir
            ->get();

        // 3. DATA STATISTIK
        $stats = [
            'total_athletes' => $athletes->count(),
            'sessions_this_week' => Attendance::where('coach_id', Auth::id())
                ->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])
                ->distinct('tanggal')
                ->count('tanggal'),
        ];

        // Mengirimkan data ke view
        return view('coach.dashboard', compact('user', 'athletes', 'stats', 'attendanceHistory'));
    }

    /**
     * Menyimpan data presensi yang dikirim dari form
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'tempat' => 'required|string',
            'athletes' => 'required|array|min:1', 
        ]);

        try {
            // Gunakan Transaction untuk memastikan semua data tersimpan dengan benar
            DB::transaction(function () use ($request) {
                foreach ($request->athletes as $athleteId) {
                    Attendance::create([
                        'coach_id' => Auth::id(),
                        'athlete_id' => $athleteId,
                        'tanggal' => $request->tanggal,
                        'tempat' => $request->tempat,
                        'materi' => $request->materi,
                    ]);
                }
            });

            return redirect()->back()->with('success', 'Presensi berhasil disimpan untuk ' . count($request->athletes) . ' atlet.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan presensi: ' . $e->getMessage());
        }
    }
}