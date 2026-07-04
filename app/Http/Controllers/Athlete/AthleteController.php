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

        // Mengambil riwayat kehadiran khusus atlet ini (Dibatasi 3 teratas untuk ringkasan dashboard)
        $attendances = Attendance::where('athlete_id', $user->id)
            ->with('coach')
            ->orderBy('tanggal', 'desc')
            ->take(3)
            ->get();

        // Perhitungan Statistik
        $stats = [
            'total_hadir' => Attendance::where('athlete_id', $user->id)->count(),
            'hadir_bulan_ini' => Attendance::where('athlete_id', $user->id)->where('tanggal', '>=', now()->startOfMonth())->count(),
            'latihan_terakhir' => $attendances->first()?->tanggal ?? '-',
        ];

        return view('athlete.dashboard', compact('user', 'attendances', 'stats'));
    }

    /**
     * Menampilkan Halaman Riwayat Presensi Penuh
     */
    public function attendanceHistory()
    {
        $user = Auth::user();

        // Menampilkan semua riwayat tanpa batasan limit, diurutkan dari yang terbaru
        $attendances = Attendance::where('athlete_id', $user->id)
            ->with('coach')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('athlete.attendance-history', compact('user', 'attendances'));
    }

    /**
     * Menampilkan Halaman Raport Bulanan (Informasi Siap Pakai)
     */
    public function reportDetail()
    {
        $user = Auth::user();
        
        // Halaman ini siap menerima komponen data visual raport Anda ke depannya
        return view('athlete.report_detail', compact('user'));
    }
}