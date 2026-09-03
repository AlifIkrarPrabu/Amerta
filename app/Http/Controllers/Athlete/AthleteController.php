<?php

namespace App\Http\Controllers\Athlete;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
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

        // Mengambil riwayat kehadiran khusus atlet ini (Dibatasi 3 teratas untuk ringkasan dashboard)
        $attendances = Attendance::where('athlete_id', $user->id)
            ->with('coach')
            ->orderBy('tanggal', 'desc')
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

        // Menampilkan semua riwayat tanpa batasan limit, diurutkan dari yang terbaru
        $attendances = Attendance::where('athlete_id', $user->id)
            ->with('coach')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('athlete.attendance-history', compact('user', 'attendances'));
    }

    /**
     * Menampilkan Halaman Raport Bulanan Atlet
     */
    public function reportDetail(Request $request)
    {
        $user = Auth::user();

        // Ambil filter bulan dari URL jika ada, atau default ke bulan saat ini (Format: YYYY-MM)
        $selectedMonth = $request->get('bulan', date('Y-m'));

        // Ambil data raport atlet ini berdasarkan bulan dan relasi pelatihnya
        $report = Report::where('athlete_id', $user->id)
            ->where('bulan_tahun', $selectedMonth)
            ->with('coach')
            ->first();

        // Ambil daftar riwayat bulan apa saja yang pernah ada catatan raport-nya (untuk filter dropdown)
        $availableMonths = Report::where('athlete_id', $user->id)
            ->orderBy('bulan_tahun', 'desc')
            ->pluck('bulan_tahun')
            ->unique();

        return view('athlete.report_detail', compact('user', 'report', 'selectedMonth', 'availableMonths'));
    }

    /**
     * Menampilkan Halaman Informasi Pembayaran
     */
    public function payment()
    {
        $user = Auth::user();

        return view('athlete.payment', compact('user'));
    }
}