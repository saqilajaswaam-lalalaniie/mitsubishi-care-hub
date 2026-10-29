<?php

namespace App\Http\Controllers;

use App\Models\Catalog; 
use App\Models\Booking; // ➕ Import Model Booking
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Beranda Utama (Katalog)
    public function index()
    {
        return view('user.dashboard');
    }

    // Halaman Profil & Garasi Digital
    public function profile()
    {
        $user = Auth::user();
        $vehicles = $user ? $user->vehicles : [];

        return view('user.profile', compact('user', 'vehicles'));
    }

    // Update Profil Data Diri
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Modul Orang ke-2: Katalog & Kalkulator (Dinamis dari Database)
    public function katalog()
    {
        $user = Auth::user();

        // ➕ Mengambil semua data layanan & sparepart yang di-input oleh Admin
        $catalogs = Catalog::all();

        // ➕ Mengambil data kendaraan milik user yang sedang login
        $vehicles = $user ? $user->vehicles : [];

        // ➕ Kirim $catalogs dan $vehicles ke view
        return view('user.katalog', compact('catalogs', 'vehicles'));
    }

    // ➕ Method 1: Menyimpan data booking dari kalkulator ke database
    public function storeBooking(Request $request)
    {
        $request->validate([
            'vehicle_id'   => 'required|exists:vehicles,id',
            'booking_date' => 'required|date',
            'total_price'  => 'required|numeric',
            'items'        => 'required|string',
        ]);

        Booking::create([
            'user_id'      => Auth::id(),
            'vehicle_id'   => $request->vehicle_id,
            'items'        => $request->items,
            'total_price'  => $request->total_price,
            'booking_date' => $request->booking_date,
            'notes'        => $request->notes,
            'status'       => 'Pending',
        ]);

        return redirect()->route('user.booking.history')->with('success', 'Jadwal servis berhasil disimpan! Silakan cek status pengajuan Anda di bawah.');
    }

    // ➕ Method 2: Menampilkan halaman riwayat booking milik user
    public function riwayatBooking()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('vehicle')
            ->latest()
            ->get();

        return view('user.riwayat_booking', compact('bookings'));
    }
}