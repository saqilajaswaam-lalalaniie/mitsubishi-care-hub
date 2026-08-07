<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Catalog;
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
}