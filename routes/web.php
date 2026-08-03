<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AdminController;

// 1. Halaman Utama (/) - Logika Auto-Redirect
Route::get('/', function () {
    if (Auth::check()) {
        // Kalau sudah login, arahkan ke dashboard sesuai role
        return Auth::user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('user.dashboard');
    }
    // Kalau belum login, lempar ke halaman login
    return redirect()->route('login');
});

// 2. Auth Routes (Login, Register, & Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Fitur Register / Sign Up Baru
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Route Khusus User Pelanggan
Route::middleware(['auth', 'role:user'])->group(function () {
    // Beranda / Katalog Utama
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    
    // Halaman Profil & Garasi Digital
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
});

// 4. Route Khusus Admin Diler
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// 5. Route Bersama (User & Admin bisa Tambah & Hapus mobil)
Route::middleware(['auth'])->group(function () {
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
});