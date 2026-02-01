<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\AthleteController as AdminAthleteController; 
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\Coach\CoachController;
use App\Http\Controllers\Athlete\AthleteController as UserAthleteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- Rute Halaman Publik ---
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/trainings', function () {
    return view('trainings');
})->name('trainings');


// --- Rute Otentikasi Kustom (Login/Logout) ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute Forgot Password
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'resetPassword'])->name('password.reset.post');

// Rute Dashboard Utama (tergantung role, akan diarahkan di LoginController)
Route::get('/dashboard', [LoginController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// --- Rute Khusus Admin ---
// Menggabungkan semua rute admin ke dalam satu group middleware 'role:admin'
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Rute untuk Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard');

    // CRUD Atlet (Menggunakan format Resource)
    Route::resource('athletes', AdminAthleteController::class)->only(['index', 'store', 'destroy']);
    Route::post('athletes/{id}/reset-attendance', [AdminAthleteController::class, 'resetAttendance'])->name('athletes.reset-attendance');
    
    // CRUD AKUN PENGGUNA (Sekarang mencakup index, store, edit (JSON), update, destroy)
    Route::resource('users', UserController::class); 

    
});


// --- Rute Profil Pengguna (Umum) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Prefix 'coach' berarti URL akan menjadi /coach/dashboard dan /coach/presensi
    Route::prefix('coach')->group(function () {
        
        // Halaman utama dashboard
        Route::get('/dashboard', [CoachController::class, 'index'])->name('coach.dashboard');
        Route::post('/presensi', [CoachController::class, 'store'])->name('presensi.store');
        Route::delete('/coach/attendance/delete', [CoachController::class, 'destroy'])->name('coach.attendance.destroy');
});
// --- RUTE UNTUK ATHLETE ---
    Route::prefix('athlete')->name('athlete.')->group(function () {
        Route::get('/dashboard', [UserAthleteController::class, 'index'])->name('dashboard');
});
