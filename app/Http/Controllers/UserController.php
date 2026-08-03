<?php

namespace App\Http\Controllers;

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
}