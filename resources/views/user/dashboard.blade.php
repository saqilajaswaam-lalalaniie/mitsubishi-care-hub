@extends('layouts.user')

@section('title', 'Beranda Utama - Mitsubishi Care Hub')

@section('content')
<div class="space-y-6">

    <!-- pesan sukses-->
    @if(session('success'))
    <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-emerald-600"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    
    <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm border-l-4 border-l-red-600 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-1">
                Selamat Datang, {{ Auth::user()->name }}! 👋
            </h1>
            <p class="text-xs text-gray-500 flex items-center gap-1.5">
                <i class="fa-solid fa-circle-info text-red-600"></i>
                Cari sparepart dan estimasi layanan servis diler resmi Sun Star Prima Motor di sini.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('user.katalog') }}" class="bg-black hover:bg-gray-800 text-white font-bold px-4 py-2 rounded-lg text-xs transition flex items-center gap-2">
                <i class="fa-solid fa-calculator"></i>
                <span>Cek Kalkulator Servis</span>
            </a>
        </div>
    </div>

    <!--  Banner Garasi -->
    <div class="bg-white rounded-lg border border-gray-200 border-dashed p-10 text-center shadow-sm space-y-3">
        <div class="w-16 h-16 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto">
            <i class="fa-solid fa-boxes-stacked text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800 text-base">Katalog Pilihan Kendaraan Anda</h3>
            <p class="text-xs text-gray-500 max-w-md mx-auto mt-1 leading-relaxed">
                Katalog sparepart dan rekomendasi servis akan disesuaikan secara otomatis berdasarkan tipe kendaraan yang terdaftar di garasi digital Anda.
            </p>
        </div>
        <div class="pt-2">
            <a href="{{ route('user.profile') }}" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold px-4 py-2 rounded-lg text-xs transition border border-gray-300">
                <i class="fa-solid fa-car"></i>
                <span>Lihat Garasi Saya</span>
            </a>
        </div>
    </div>

</div>
@endsection