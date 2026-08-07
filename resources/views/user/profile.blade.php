@extends('layouts.user')

@section('title', 'Profil Saya & Garasi Digital')

@section('content')
<div class="space-y-6">

    <!--pesan Success -->
    @if(session('success'))
    <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-emerald-600"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- pesan Error -->
    @if($errors->any())
    <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
        <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
        <span>{{ $errors->first() }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Profil & Form Update Data Diri  -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 space-y-4 h-fit">
            <div class="text-center">
                <div class="w-20 h-20 bg-gray-300 text-white rounded-full flex items-center justify-center mx-auto mb-3 text-3xl font-bold shadow-inner">
                    <i class="fa-solid fa-user"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-900">{{ $user->name }}</h2>
                <p class="text-xs text-gray-500">{{ $user->email }}</p>
            </div>

            <hr class="border-gray-200">

            <!-- Form Update Profil -->
            <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-3">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">
                        <i class="fa-solid fa-id-card mr-1 text-gray-500"></i> Nama Lengkap
                    </label>
                    <input type="text" name="name" value="{{ $user->name }}" required class="w-full border border-gray-300 rounded px-3 py-2 text-xs focus:outline-none focus:border-red-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">
                        <i class="fa-solid fa-envelope mr-1 text-gray-500"></i> Email
                    </label>
                    <input type="email" name="email" value="{{ $user->email }}" required class="w-full border border-gray-300 rounded px-3 py-2 text-xs focus:outline-none focus:border-red-600">
                </div>

                <button type="submit" class="w-full bg-black hover:bg-gray-800 text-white font-bold py-2 rounded text-xs transition flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-pen-to-square"></i> Update Profil
                </button>
            </form>
        </div>

        <!-- Garasi Digital & Tambah Mobil Baru ( -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Garasi Digital  -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-red-600 text-white px-4 py-3 font-bold flex justify-between items-center text-sm">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-warehouse"></i> Garasi Digital Saya
                    </span>
                    <span class="bg-white text-red-600 text-[11px] px-2.5 py-0.5 rounded-full font-bold">
                        {{ count($vehicles) }} Kendaraan
                    </span>
                </div>

                <div class="p-4">
                    @if(empty($vehicles) || count($vehicles) == 0)
                        <div class="text-center py-8 text-gray-400 space-y-2">
                            <i class="fa-solid fa-car-burst text-4xl text-gray-300 block"></i>
                            <p class="text-xs italic">Belum ada kendaraan di garasi Anda. Tambahkan melalui form di bawah!</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($vehicles as $item)
                            <div class="border border-gray-200 rounded-xl p-4 bg-gray-50/50 shadow-sm space-y-2 relative hover:border-red-500 transition">
                                <div class="flex items-center justify-between border-b pb-2">
                                    <h3 class="font-bold text-sm text-red-600 flex items-center gap-2">
                                        <i class="fa-solid fa-car"></i> {{ $item->tipe_mobil }}
                                    </h3>
                                    <span class="bg-gray-200 text-gray-800 font-mono font-bold text-[10px] px-2 py-0.5 rounded border border-gray-300">
                                        {{ $item->plat_nomor }}
                                    </span>
                                </div>

                                <div class="space-y-1 text-xs text-gray-600">
                                    <p><strong class="text-gray-800">Warna / Tahun:</strong> {{ $item->warna }} ({{ $item->tahun }})</p>
                                    <p><strong class="text-gray-800">No. Rangka:</strong> <code class="bg-gray-100 px-1 py-0.5 rounded text-gray-800 font-mono">{{ $item->no_rangka }}</code></p>
                                </div>

                                <form action="{{ route('vehicles.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus mobil ini?')" class="pt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-white hover:bg-red-600 hover:text-white text-red-600 border border-red-200 font-bold py-1.5 rounded text-xs transition flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-trash-can"></i> Hapus Mobil
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Form Tambah Kendaraan Baru -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-black text-white px-4 py-3 font-bold flex items-center gap-2 text-sm">
                    <i class="fa-solid fa-square-plus text-red-500"></i> Tambah Kendaraan Baru
                </div>

                <form action="{{ route('vehicles.store') }}" method="POST" class="p-4 space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tipe Mobil</label>
                            <select name="tipe_mobil" required class="w-full border border-gray-300 rounded px-3 py-2 text-xs focus:outline-none focus:border-red-600 bg-white">
                                <option value="XPander">XPander</option>
                                <option value="XPander Cross">XPander Cross</option>
                                <option value="XForce">XForce</option>
                                <option value="Pajero Sport">Pajero Sport</option>
                                <option value="Destinator">Destinator</option>
                                <option value="L300">L300</option>
                                <option value="Triton">Triton</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">No. Polisi (Plat)</label>
                            <input type="text" name="plat_nomor" placeholder="B 1234 ABC" required class="w-full border border-gray-300 rounded px-3 py-2 text-xs focus:outline-none focus:border-red-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tahun</label>
                            <input type="number" name="tahun" placeholder="2023" required class="w-full border border-gray-300 rounded px-3 py-2 text-xs focus:outline-none focus:border-red-600">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Warna</label>
                            <select name="warna" required class="w-full border border-gray-300 rounded px-3 py-2 text-xs focus:outline-none focus:border-red-600 bg-white">
                                <option value="Hitam">Hitam</option>
                                <option value="Putih">Putih</option>
                                <option value="Merah">Merah</option>
                                <option value="Silver">Silver</option>
                                <option value="Abu-abu">Abu-abu</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">No. Rangka</label>
                            <input type="text" name="no_rangka" placeholder="MHX..." required class="w-full border border-gray-300 rounded px-3 py-2 text-xs focus:outline-none focus:border-red-600">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded text-xs transition flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan ke Garasi
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection