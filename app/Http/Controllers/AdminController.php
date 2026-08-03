<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Mengambil semua data mobil beserta informasi pemiliknya (user)
        $vehicles = Vehicle::with('user')->latest()->get();

        return view('admin.dashboard', compact('vehicles'));
    }
}