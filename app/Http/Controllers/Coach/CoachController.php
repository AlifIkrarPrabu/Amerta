<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\User; 
use App\Models\Attendance;
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
        
        $athletes = User::where('role', 'atlet')->get();

        // Mengambil riwayat presensi yang dikelompokkan berdasarkan sesi
        $attendanceHistory = Attendance::where('coach_id', Auth::id())
            ->select('tanggal', 'tempat', 'materi', DB::raw('count(athlete_id) as athletes_count'))
            ->groupBy('tanggal', 'tempat', 'materi')
            ->orderBy('tanggal', 'desc')
            ->get();

        $stats = [
            'total_athletes' => $athletes->count(),
            'sessions_this_week' => Attendance::where('coach_id', Auth::id())
                ->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])
                ->distinct('tanggal')
                ->count('tanggal'),
        ];

        return view('coach.dashboard', compact('user', 'athletes', 'stats', 'attendanceHistory'));
    }

    /**
     * Menyimpan data presensi
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tempat' => 'required|string',
            'athletes' => 'required|array|min:1', 
        ]);

        try {
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

            return redirect()->back()->with('success', 'Presensi berhasil disimpan.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus satu sesi presensi
     */
    public function destroy(Request $request)
    {
        try {
            // Kita hapus semua data atlet yang ada di sesi yang sama (tanggal, tempat, materi)
            Attendance::where('coach_id', Auth::id())
                ->where('tanggal', $request->tanggal)
                ->where('tempat', $request->tempat)
                ->where('materi', $request->materi)
                ->delete();

            return redirect()->back()->with('success', 'Data presensi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}