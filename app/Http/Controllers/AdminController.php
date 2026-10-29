<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Catalog;
use App\Models\Booking; // ➕ Panggil Model Booking
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ==========================================
    // KODINGAN ASLI TEMANMU (TIDAK DIUBAH)
    // ==========================================
    public function dashboard()
    {
        // Mengambil semua data mobil beserta informasi pemiliknya (user)
        $vehicles = Vehicle::with('user')->latest()->get();

        return view('admin.dashboard', compact('vehicles'));
    }

    // ==========================================
    // MODUL ORANG KE-2: CRUD KATALOG & SPAREPART
    // ==========================================

    // 1. READ: Menampilkan Halaman & Daftar Data Katalog dari Database
    public function katalog()
    {
        $catalogs = Catalog::latest()->get();
        return view('admin.katalog', compact('catalogs'));
    }

    // 2. CREATE: Menyimpan Data Layanan / Sparepart Baru
    public function storeKatalog(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:service,sparepart',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Catalog::create([
            'name'        => $request->name,
            'type'        => $request->type,
            'price'       => $request->price,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Data katalog berhasil ditambahkan!');
    }

    // 3. UPDATE: Mengubah Harga atau Detail Layanan
    public function updateKatalog(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:service,sparepart',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $catalog = Catalog::findOrFail($id);
        $catalog->update([
            'name'        => $request->name,
            'type'        => $request->type,
            'price'       => $request->price,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Data katalog berhasil diperbarui!');
    }

    // 4. DELETE: Menghapus Item Layanan / Sparepart
    public function destroyKatalog($id)
    {
        $catalog = Catalog::findOrFail($id);
        $catalog->delete();

        return back()->with('success', 'Item katalog berhasil dihapus!');
    }

    // ==========================================
    // ➕ MODUL KELOLA BOOKING SERVIS PELANGGAN
    // ==========================================

    // 1. Menampilkan Daftar Booking Masuk dari Pelanggan
    public function indexBookings()
    {
        $bookings = Booking::with(['user', 'vehicle'])->latest()->get();
        return view('admin.bookings', compact('bookings'));
    }

    // 2. Mengubah Status Booking (Pending, Disetujui, Selesai, Ditolak)
    public function updateBookingStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Disetujui,Selesai,Ditolak',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status pengajuan booking berhasil diperbarui!');
    }
}