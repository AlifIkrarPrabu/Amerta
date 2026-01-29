<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles  // Menggunakan splat operator agar bisa menerima lebih dari satu role
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 2. Lakukan pengecekan peran (role)
        // in_array memungkinkan kita mengecek misal: role:admin,pelatih
        if (!in_array($user->role, $roles)) {
            
            // Logika cerdas: arahkan ke dashboard masing-masing jika salah alamat
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            } elseif ($user->role === 'pelatih') {
                return redirect()->route('coach.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            } elseif ($user->role === 'atlet') {
                return redirect()->route('atlet.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }

            // Fallback terakhir jika role tidak dikenal
            Auth::logout();
            return redirect('/login')->with('error', 'Sesi tidak valid atau peran tidak ditemukan.');
        }

        // 3. Jika peran sesuai, lanjutkan ke rute tujuan
        return $next($request);
    }
}