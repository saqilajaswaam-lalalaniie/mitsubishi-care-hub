@extends('layouts.admin')

@section('title', 'Monitoring Garasi Digital - Admin Panel')

@section('content')
<div class="space-y-6">

    <!-- Pesan Success -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 p-3.5 rounded-lg text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-green-600"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Monitoring Garasi Digital Header -->
    <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-1">Monitoring Garasi Digital</h1>
            <p class="text-xs text-gray-500">Daftar semua unit kendaraan pelanggan yang terdaftar di sistem Mitsubishi Sun Star Prima Motor.</p>
        </div>
        <div class="bg-gray-50 p-3.5 rounded-lg border border-gray-200 self-start md:self-auto min-w-[200px]">
            <span class="text-[10px] uppercase font-bold text-gray-500 block mb-1">Total Unit Registered</span>
            <div class="flex items-center gap-2">
                <span class="text-2xl font-bold text-gray-900">{{ count($vehicles) }}</span>
                <span class="bg-red-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">Mobil Pelanggan</span>
            </div>
        </div>
    </div>

    <!-- Tabel Data Kendaraan Terdaftar -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        
        <!-- Search Bar -->
        <div class="bg-black text-white px-4 py-3 font-bold flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-sm">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-car-tunnel text-red-500"></i>
                <span>Data Kendaraan Terdaftar</span>
            </div>
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Cari Nopol / Pemilik / Tipe..." class="w-full bg-white text-gray-800 pl-8 pr-3 py-1.5 rounded text-xs focus:outline-none focus:ring-1 focus:ring-red-600 border-0">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm" id="vehicleTable">
                <thead>
                    <tr class="bg-gray-100 border-b text-gray-600 text-xs uppercase">
                        <th class="p-3">Pemilik</th>
                        <th class="p-3">Tipe Mobil</th>
                        <th class="p-3">Plat Nomor</th>
                        <th class="p-3">Warna & Tahun</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($vehicles as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3">
                            <div class="font-bold text-gray-900">{{ $item->user->name ?? 'User Terhapus' }}</div>
                        </td>
                        <td class="p-3">
                            <span class="bg-red-100 text-red-700 font-bold px-2.5 py-1 rounded-md text-xs inline-block">
                                {{ $item->tipe_mobil }}
                            </span>
                        </td>
                        <td class="p-3">
                            <code class="bg-gray-100 font-mono font-bold text-gray-800 px-2 py-1 rounded border border-gray-200 text-xs">
                                {{ $item->plat_nomor }}
                            </code>
                        </td>
                        <td class="p-3">
                            <span class="font-semibold text-gray-800">{{ $item->warna }}</span>
                            <span class="text-xs text-gray-400">({{ $item->tahun }})</span>
                        </td>
                        <td class="p-3 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button onclick="openDetailModal({{ $item->id }})" class="bg-gray-100 hover:bg-gray-800 hover:text-white text-gray-700 border border-gray-300 px-2 py-1 rounded text-xs transition" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>

                                <form action="{{ route('vehicles.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data mobil ini dari garasi digital?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-100 hover:bg-red-600 hover:text-white text-red-600 border border-red-200 px-2 py-1 rounded text-xs transition" title="Hapus Data">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">
                            <i class="fa-solid fa-folder-open text-4xl mb-2 text-gray-300 block"></i>
                            <p class="text-xs italic">Belum ada kendaraan yang dimasukkan oleh pelanggan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- MODAL DETAIL KENDARAAN -->
@foreach($vehicles as $item)
<div id="modalDetail{{ $item->id }}" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg border border-gray-200 shadow-xl max-w-md w-full overflow-hidden">
        <div class="bg-black text-white px-4 py-3 font-bold flex justify-between items-center text-sm">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-id-card text-red-500"></i> Kartu Informasi Kendaraan
            </span>
            <button onclick="closeDetailModal({{ $item->id }})" class="text-gray-400 hover:text-white">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="p-5 text-left space-y-4">
            <div class="text-center pb-2 border-b">
                <span class="bg-red-600 text-white font-bold text-xs px-3 py-1 rounded-full mb-2 inline-block">{{ $item->tipe_mobil }}</span>
                <h3 class="font-mono font-bold text-xl text-gray-900">{{ $item->plat_nomor }}</h3>
            </div>

            <div class="space-y-2.5 text-xs">
                <div class="flex justify-between border-b pb-1.5">
                    <span class="text-gray-500 flex items-center gap-1.5"><i class="fa-solid fa-user w-4"></i> Nama Pemilik:</span>
                    <span class="font-bold text-gray-800">{{ $item->user->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b pb-1.5">
                    <span class="text-gray-500 flex items-center gap-1.5"><i class="fa-solid fa-envelope w-4"></i> Email Pemilik:</span>
                    <span class="text-gray-800 font-medium">{{ $item->user->email ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b pb-1.5">
                    <span class="text-gray-500 flex items-center gap-1.5"><i class="fa-solid fa-palette w-4"></i> Warna / Tahun:</span>
                    <span class="text-gray-800 font-medium">{{ $item->warna }} / {{ $item->tahun }}</span>
                </div>
                <div class="flex justify-between border-b pb-1.5">
                    <span class="text-gray-500 flex items-center gap-1.5"><i class="fa-solid fa-fingerprint w-4"></i> No. Rangka:</span>
                    <code class="font-bold text-gray-800 bg-gray-100 px-1.5 py-0.5 rounded">{{ $item->no_rangka }}</code>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 flex items-center gap-1.5"><i class="fa-solid fa-calendar-check w-4"></i> Terdaftar Pada:</span>
                    <span class="text-gray-800 font-medium">{{ $item->created_at ? $item->created_at->format('d M Y H:i') . ' WIB' : '-' }}</span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-4 py-3 flex justify-end">
            <button onclick="closeDetailModal({{ $item->id }})" class="bg-gray-800 hover:bg-black text-white font-bold px-4 py-1.5 rounded text-xs transition">
                Tutup
            </button>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    // Search Table Script
    function searchTable() {
        let input = document.getElementById("searchInput").value.toUpperCase();
        let table = document.getElementById("vehicleTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName("td");
            if (td.length > 0) {
                let text = tr[i].innerText.toUpperCase();
                if (text.indexOf(input) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    // Modal JS
    function openDetailModal(id) {
        document.getElementById('modalDetail' + id).classList.remove('hidden');
    }

    function closeDetailModal(id) {
        document.getElementById('modalDetail' + id).classList.add('hidden');
    }
</script>
@endpush
@endsection