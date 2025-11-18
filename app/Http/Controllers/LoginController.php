<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan ini ada

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses permintaan login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // PERBAIKAN: Mengganti 'phone' menjadi 'phone_number' di validasi
        $credentials = $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required',
        ]);

        // PERBAIKAN: Mengganti 'phone' menjadi 'phone_number' di Auth::attempt()
        // Kita menggunakan array asosiatif: ['kolom_db' => 'nilai_dari_form']
        if (Auth::attempt([
            'phone_number' => $credentials['phone_number'], 
            'password' => $credentials['password']
        ])) {
            $request->session()->regenerate();
            $user = Auth::user();
            // Arahkan ke rute 'dashboard', yang akan dicek oleh metode dashboard() di bawah.
            return redirect()->route('dashboard')->with('status', 'Login berhasil!');
        }

        // PERBAIKAN: Memberikan pesan error yang jelas
        return back()->withInput()->withErrors([
            'phone_number' => 'Nomor telepon atau password salah.',
        ]);
    }

    /**
     * Menampilkan halaman dashboard berdasarkan peran pengguna.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();

        // >>> LOGIKA PENTING: Cek peran pengguna
        if ($user->role === 'admin' || $user->role === 'pelatih') {
            // Jika role adalah 'admin' atau 'pelatih', arahkan ke rute Admin/Pelatih Dashboard
            return redirect()->route('admin.dashboard');
        }

        // Jika role adalah 'atlet', arahkan ke rute atlet (misalnya)
        if ($user->role === 'atlet') {
             return view('atlet.dashboard', compact('user')); // Asumsi Anda punya view 'atlet.dashboard'
        }

        // Jika role tidak terdefinisi
        return view('dashboard', compact('user'));
    }

    /**
     * Memproses permintaan logout pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Menampilkan form lupa password.
     *
     * @return \Illuminate\View\View
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Memproses permintaan reset password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        // PERBAIKAN: Mengganti 'phone' menjadi 'phone_number' di validasi
        $request->validate([
            'phone_number' => 'required|string|exists:users,phone_number',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:new_password',
        ], [
            'phone_number.exists' => 'Nomor telepon tidak terdaftar.',
            'new_password.min' => 'Kata sandi baru harus minimal 8 karakter.',
            'confirm_password.same' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // PERBAIKAN: Mengganti 'phone' menjadi 'phone_number' saat mencari user
        $user = User::where('phone_number', $request->phone_number)->first();

        if ($user) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->route('login')->with('status', 'Kata sandi berhasil diperbarui. Silakan login dengan kata sandi baru Anda.');
        }

        return back()->with('error', 'Terjadi kesalahan saat mereset kata sandi.');
    }
}
