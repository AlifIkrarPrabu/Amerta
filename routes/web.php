<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\AthleteController as AdminAthleteController; 
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\Admin\CoachAttendanceController;
use App\Http\Controllers\Coach\CoachController;
use App\Http\Controllers\Athlete\AthleteController as UserAthleteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
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

// Rute Dashboard Utama (Grup Auth umum)
Route::get('/dashboard', [LoginController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- Rute Khusus Admin ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard');

    Route::get('/reports/coaches', [CoachAttendanceController::class, 'index'])->name('reports.coaches');
    Route::resource('athletes', AdminAthleteController::class)->only(['index', 'store', 'destroy']);
    Route::post('athletes/{id}/reset-attendance', [AdminAthleteController::class, 'resetAttendance'])->name('athletes.reset-attendance');
    Route::resource('users', UserController::class); 
});

// --- Rute Profil Pengguna (Umum) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- RUTE UNTUK COACH ---
Route::middleware(['auth'])->prefix('coach')->group(function () {
    Route::get('/dashboard', [CoachController::class, 'index'])->name('coach.dashboard');
    Route::post('/presensi', [CoachController::class, 'store'])->name('presensi.store');
    Route::delete('/coach/attendance/delete', [CoachController::class, 'destroy'])->name('coach.attendance.destroy');
});

// --- RUTE UNTUK ATHLETE (Sudah Ditambahkan Rute Navigasi Baru) ---
Route::middleware(['auth'])->prefix('athlete')->name('athlete.')->group(function () {
    Route::get('/dashboard', [UserAthleteController::class, 'index'])->name('dashboard');
    Route::get('/attendance-history', [UserAthleteController::class, 'attendanceHistory'])->name('attendance-history');
    Route::get('/report-detail', [UserAthleteController::class, 'reportDetail'])->name('report_detail');
});