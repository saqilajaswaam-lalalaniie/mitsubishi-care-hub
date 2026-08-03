<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    // Tambah mobil (Bisa oleh User & Admin)
    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string|unique:vehicles,plat_nomor',
            'tipe_mobil' => 'required|string',
            'tahun'      => 'required|numeric',
            'warna'      => 'required|string',
            'no_rangka'  => 'required|string|unique:vehicles,no_rangka',
            'user_id'    => 'nullable|exists:users,id', // Opsional jika Admin yang menginputkan
        ], [
            'plat_nomor.unique' => 'Plat nomor ini sudah terdaftar di garasi!',
            'no_rangka.unique'  => 'Nomor rangka ini sudah pernah terdaftar!',
        ]);

        // Tentukan siapa pemilik mobilnya:
        // Jika Admin menginput & memilih user_id, pakai user_id tsb. Jika tidak, pakai ID user yang sedang login.
        $ownerId = ($request->has('user_id') && $request->user_id) 
            ? $request->user_id 
            : Auth::id();

        Vehicle::create([
            'user_id'    => $ownerId,
            'plat_nomor' => strtoupper($request->plat_nomor), // Otomatis KAPITAL
            'tipe_mobil' => $request->tipe_mobil,
            'tahun'      => $request->tahun,
            'warna'      => $request->warna,
            'no_rangka'  => strtoupper($request->no_rangka),
        ]);

        // Fleksibel: Kembalikan ke halaman sebelumnya (Bisa dari Garasi User maupun Dashboard Admin)
        return back()->with('success', 'Mobil berhasil ditambahkan ke sistem!');
    }

    // Hapus mobil
    public function destroy(Vehicle $vehicle)
    {
        $user = Auth::user();

        // Admin BOLEH hapus mobil siapapun, User HANYA BOLEH hapus mobilnya sendiri
        if ($user->role === 'admin' || $vehicle->user_id === $user->id) {
            $vehicle->delete();
            return back()->with('success', 'Data kendaraan berhasil dihapus.');
        }

        abort(403, 'Anda tidak memiliki akses untuk menghapus mobil ini.');
    }
}