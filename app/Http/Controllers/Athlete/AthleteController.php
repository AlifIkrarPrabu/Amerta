<?php

namespace App\Http\Controllers\Athlete;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AthleteController extends Controller
{
    /**
     * Menampilkan Dashboard Atlet
     */
    public function index()
    {
        $user = Auth::user();

        // Mengambil riwayat kehadiran khusus atlet ini
        // Menggunakan eager loading 'coach' untuk performa lebih baik
        $attendances = Attendance::where('athlete_id', $user->id)
            ->with('coach')
            ->orderBy('tanggal', 'desc')
            ->get();

        // Perhitungan Statistik
        $stats = [
            'total_hadir' => $attendances->count(),
            'hadir_bulan_ini' => $attendances->where('tanggal', '>=', now()->startOfMonth())->count(),
            'latihan_terakhir' => $attendances->first()?->tanggal ?? '-',
        ];

        return view('athlete.dashboard', compact('user', 'attendances', 'stats'));
    }
}