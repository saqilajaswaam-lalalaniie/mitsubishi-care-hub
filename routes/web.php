<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\AdminForumController;

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
    // Beranda / Katalog Utama (Milik Teman)
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    
    // Halaman Profil & Garasi Digital (Milik Teman)
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');

    // Katalog untuk User (Modul Orang ke-2)
    Route::get('/user/katalog', [UserController::class, 'katalog'])->name('user.katalog');
});

// 4. Route Khusus Admin Diler
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // ➕ MODUL ORANG KE-2: ROUTE CRUD ADMIN KATALOG & SPAREPART
    Route::get('/admin/katalog', [AdminController::class, 'katalog'])->name('admin.katalog');
    Route::post('/admin/katalog', [AdminController::class, 'storeKatalog'])->name('admin.katalog.store');
    Route::put('/admin/katalog/{id}', [AdminController::class, 'updateKatalog'])->name('admin.katalog.update');
    Route::delete('/admin/katalog/{id}', [AdminController::class, 'destroyKatalog'])->name('admin.katalog.destroy');
});

// 5. Route Bersama (User & Admin bisa Tambah & Hapus mobil)
Route::middleware(['auth'])->group(function () {
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
});

// 6. Route untuk Forum QnA
Route::middleware(['auth'])->group(function () {
    Route::get('/forum', [DiscussionController::class, 'index'])->name('forum.index');
    Route::post('/forum', [DiscussionController::class, 'store'])->name('forum.store');
    Route::put('/forum/{id}', [DiscussionController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{id}', [DiscussionController::class, 'destroy'])->name('forum.destroy');

    // Route untuk mengirim balasan/solusi forum
    Route::post('/forum/{discussion}/reply', [ReplyController::class, 'store'])->name('reply.store');
    Route::delete('/forum/reply/{id}', [ReplyController::class, 'destroy'])->name('reply.destroy');
});

// 7. Route untuk folder discussions
Route::middleware(['auth'])->group(function () {
    Route::get('/discussions', function () {
        return view('discussions.index');
    })->name('discussions.index');
});

// 8. Route Khusus Admin Moderasi Forum
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/forum', [AdminForumController::class, 'index'])->name('forum.index');
    Route::delete('/forum/{id}', [AdminForumController::class, 'destroy'])->name('forum.destroy');
});