<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class CoachAttendanceController extends Controller
{
    public function index()
    {
        // Query untuk mengambil data sesi latihan unik per pelatih
        // Kita mengelompokkan berdasarkan pelatih, tanggal, tempat, dan materi
        $reports = Attendance::with('coach')
            ->select(
                'coach_id',
                'tanggal',
                'tempat',
                'materi',
                DB::raw('count(athlete_id) as total_atlet')
            )
            ->groupBy('coach_id', 'tanggal', 'tempat', 'materi')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.reports.coaches', compact('reports'));
    }
}