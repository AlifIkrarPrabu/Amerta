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
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 2. Lakukan pengecekan peran (role)
        // Jika peran pengguna (user->role) TIDAK SAMA dengan peran yang disyaratkan ($role),
        // maka tolak akses dan kembalikan ke dashboard.
        if ($user->role != $role) {
            // Kita arahkan ke dashboard biasa jika peran tidak sesuai
            return redirect('/dashboard')->with('error', 'Akses ditolak. Anda bukan ' . $role . '.');
        }

        // 3. Jika peran sesuai, lanjutkan ke rute tujuan
        return $next($request);
    }
}
