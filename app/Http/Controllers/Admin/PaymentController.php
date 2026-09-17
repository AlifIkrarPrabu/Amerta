<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Menampilkan daftar riwayat pembayaran & form input pembayaran oleh Admin
     */
    public function index(Request $request)
    {
        // Mengambil seluruh data atlet untuk disuplai ke JavaScript Autocomplete Search
        $athletes = User::where('role', 'atlet')
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();
        
        $selectedMonth = $request->get('bulan', date('Y-m'));

        $payments = Payment::with('athlete')
            ->where('bulan_tahun', $selectedMonth)
            ->orderBy('tanggal_bayar', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.payments.index', compact('athletes', 'payments', 'selectedMonth'));
    }

    /**
     * Menyimpan data pembayaran baru yang diinput Admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'athlete_id' => 'required|exists:users,id',
            'bulan_tahun' => 'required|string',
            'tanggal_bayar' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:Cash,Transfer',
            'catatan' => 'nullable|string|max:255',
        ], [
            'athlete_id.required' => 'Silakan cari dan pilih nama atlet terlebih dahulu.',
            'athlete_id.exists' => 'Data atlet yang dipilih tidak valid.'
        ]);

        try {
            Payment::create([
                'athlete_id' => $request->athlete_id,
                'bulan_tahun' => $request->bulan_tahun,
                'tanggal_bayar' => $request->tanggal_bayar,
                'jumlah' => (int) round($request->jumlah),
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'Lunas',
                'catatan' => $request->catatan,
            ]);

            return redirect()->back()->with('success', 'Catatan pembayaran SPP berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus riwayat pembayaran
     */
    public function destroy($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->delete();

            return redirect()->back()->with('success', 'Data pembayaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}