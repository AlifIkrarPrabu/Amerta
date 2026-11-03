<?php

namespace App\Http\Controllers\Athlete;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Report;
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

        // Total seluruh presensi untuk menentukan posisi dalam siklus 4 latihan
        $totalKehadiran = Attendance::where('athlete_id', $user->id)->count();

        // Mengambil riwayat kehadiran khusus atlet ini (3 teratas berdasarkan tanggal terbaru)
        $attendances = Attendance::where('athlete_id', $user->id)
            ->with('coach')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->take(3)
            ->get();

        // Perhitungan Statistik
        $stats = [
            'total_hadir' => $totalKehadiran,
            'hadir_bulan_ini' => Attendance::where('athlete_id', $user->id)->where('tanggal', '>=', now()->startOfMonth())->count(),
            'latihan_terakhir' => $attendances->first()?->tanggal ?? '-',
        ];

        return view('athlete.dashboard', compact('user', 'attendances', 'stats', 'totalKehadiran'));
    }

    /**
     * Menampilkan Halaman Riwayat Presensi Penuh
     */
    public function attendanceHistory()
    {
        $user = Auth::user();

        // Urutkan murni berdasarkan tanggal presensi (terbaru di paling atas)
        $attendances = Attendance::where('athlete_id', $user->id)
            ->with('coach')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('athlete.attendance-history', compact('user', 'attendances'));
    }

    /**
     * Menampilkan Halaman Raport Bulanan Atlet
     */
    public function reportDetail(Request $request)
    {
        $user = Auth::user();

        $selectedMonth = $request->get('bulan', date('Y-m'));

        $report = Report::where('athlete_id', $user->id)
            ->where('bulan_tahun', $selectedMonth)
            ->with('coach')
            ->first();

        $availableMonths = Report::where('athlete_id', $user->id)
            ->orderBy('bulan_tahun', 'desc')
            ->pluck('bulan_tahun')
            ->unique();

        return view('athlete.report_detail', compact('user', 'report', 'selectedMonth', 'availableMonths'));
    }

    /**
     * Menampilkan Halaman Informasi & Riwayat Pembayaran Atlet
     */
    public function payment()
    {
        $user = Auth::user();

        $payments = Payment::where('athlete_id', $user->id)
            ->orderBy('bulan_tahun', 'desc')
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        return view('athlete.payment', compact('user', 'payments'));
    }
}