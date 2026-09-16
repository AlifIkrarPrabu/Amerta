<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\User; 
use App\Models\Attendance;
use App\Models\Report;
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
        
        // Pagination atlet 5 per halaman dengan mempertahankan query string
        $athletes = User::where('role', 'atlet')->paginate(5)->withQueryString();

        // Mengambil riwayat presensi yang dikelompokkan berdasarkan sesi
        $attendanceHistory = Attendance::where('coach_id', Auth::id())
            ->select('tanggal', 'tempat', 'materi', 'evaluation', DB::raw('count(athlete_id) as athletes_count'))
            ->groupBy('tanggal', 'tempat', 'materi', 'evaluation')
            ->orderBy('tanggal', 'desc')
            ->get();

        $stats = [
            'total_athletes' => $athletes->total(),
            'sessions_this_week' => Attendance::where('coach_id', Auth::id())
                ->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])
                ->distinct('tanggal')
                ->count('tanggal'),
        ];

        return view('coach.dashboard', compact('user', 'athletes', 'stats', 'attendanceHistory'));
    }

    /**
     * Menyimpan data presensi dengan proteksi 1 kali latihan per hari untuk atlet
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tempat' => 'required|string',
            'athletes' => 'required|array|min:1', 
            'evaluation' => 'nullable|string|max:500',
        ]);

        try {
            $savedCount = 0;
            $skippedAthletes = [];

            DB::transaction(function () use ($request, &$savedCount, &$skippedAthletes) {
                foreach ($request->athletes as $athleteId) {
                    
                    // Pengecekan: Apakah atlet ini sudah memiliki catatan presensi di tanggal yang sama?
                    $alreadyAttended = Attendance::where('athlete_id', $athleteId)
                        ->where('tanggal', $request->tanggal)
                        ->exists();

                    if (!$alreadyAttended) {
                        Attendance::create([
                            'coach_id'   => Auth::id(),
                            'athlete_id' => $athleteId,
                            'tanggal'    => $request->tanggal,
                            'tempat'     => $request->tempat,
                            'materi'     => $request->materi ?? '-',
                            'evaluation' => $request->evaluation,
                        ]);
                        $savedCount++;
                    } else {
                        // Catat nama atlet yang dilewati
                        $athlete = User::find($athleteId);
                        if ($athlete) {
                            $skippedAthletes[] = $athlete->name;
                        }
                    }
                }
            });

            // Respon jika semua atlet sudah di-absen sebelumnya
            if ($savedCount === 0 && !empty($skippedAthletes)) {
                return redirect()->back()->with('error', 'Gagal menyimpan. Atlet yang dipilih (' . implode(', ', $skippedAthletes) . ') sudah memiliki data presensi pada tanggal tersebut.');
            }

            // Respon jika sebagian berhasil dan sebagian dilewati
            if (!empty($skippedAthletes)) {
                $skippedNames = implode(', ', $skippedAthletes);
                return redirect()->back()->with('success', "Presensi berhasil disimpan untuk {$savedCount} atlet. Catatan: Atlet ({$skippedNames}) dilewati karena sudah di-absen oleh pelatih lain pada tanggal tersebut.");
            }

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
            Attendance::where('coach_id', Auth::id())
                ->where('tanggal', $request->tanggal)
                ->where('tempat', $request->tempat)
                ->delete();

            return redirect()->back()->with('success', 'Data presensi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan Halaman Raport Bulanan Atlet
     */
    public function reportIndex(Request $request)
    {
        $user = Auth::user();
        $selectedMonth = $request->get('bulan', date('Y-m'));

        $athletes = User::where('role', 'atlet')->get();

        // Ambil raport yang sudah diisi pada bulan tersebut
        $reports = Report::where('bulan_tahun', $selectedMonth)
            ->get()
            ->keyBy('athlete_id');

        return view('coach.reports', compact('user', 'athletes', 'reports', 'selectedMonth'));
    }

    /**
     * Menyimpan atau memperbarui Raport Bulanan Atlet
     */
    public function reportStore(Request $request)
    {
        $request->validate([
            'athlete_id' => 'required|exists:users,id',
            'bulan_tahun' => 'required|string',
            'catatan_evaluasi' => 'required|string',
        ]);

        try {
            Report::updateOrCreate(
                [
                    'athlete_id' => $request->athlete_id,
                    'bulan_tahun' => $request->bulan_tahun,
                ],
                [
                    'coach_id' => Auth::id(),
                    'catatan_evaluasi' => $request->catatan_evaluasi,
                ]
            );

            return redirect()->back()->with('success', 'Raport bulanan berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan raport: ' . $e->getMessage());
        }
    }
}