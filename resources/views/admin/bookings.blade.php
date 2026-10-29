@extends('layouts.admin')

@section('title', 'Kelola Booking Servis - Admin')

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 p-3.5 rounded-lg text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-green-600"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="bg-black text-white px-4 py-3 font-bold flex justify-between items-center text-sm">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-list-check text-red-500"></i> Daftar Pengajuan Booking Servis Pelanggan
            </span>
            <span class="bg-gray-800 text-xs text-gray-300 px-2.5 py-0.5 rounded-full font-semibold">
                {{ count($bookings) }} Data Masuk
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b text-gray-600 text-xs uppercase">
                        <th class="p-3">Pelanggan</th>
                        <th class="p-3">Kendaraan</th>
                        <th class="p-3">Rincian Servis</th>
                        <th class="p-3">Tgl Kedatangan</th>
                        <th class="p-3">Total Biaya</th>
                        <th class="p-3 text-center">Status & Ubah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($bookings as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3">
                            <div class="font-bold text-gray-900">{{ $item->user->name ?? 'User Terhapus' }}</div>
                            <div class="text-xs text-gray-400">{{ $item->user->email ?? '-' }}</div>
                        </td>
                        <td class="p-3">
                            <div class="font-bold text-red-600 text-xs">{{ $item->vehicle->tipe_mobil ?? '-' }}</div>
                            <code class="text-[11px] font-mono font-bold bg-gray-100 px-1.5 py-0.5 rounded">{{ $item->vehicle->plat_nomor ?? '-' }}</code>
                        </td>
                        <td class="p-3 text-xs max-w-xs">
                            <p class="font-medium text-gray-800">{{ $item->items }}</p>
                            @if($item->notes)
                                <p class="text-[10px] text-gray-400 italic mt-0.5">Ket: {{ $item->notes }}</p>
                            @endif
                        </td>
                        <td class="p-3 text-xs font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($item->booking_date)->format('d/m/Y H:i') }}
                        </td>
                        <td class="p-3 font-black text-gray-900 text-xs">
                            Rp {{ number_format($item->total_price, 0, ',', '.') }}
                        </td>
                        <td class="p-3 text-center">
                            <!-- Form Ubah Status -->
                            <form action="{{ route('admin.bookings.update', $item->id) }}" method="POST" class="flex items-center justify-center gap-1">
                                @csrf
                                @method('PUT')
                                <select name="status" class="border border-gray-300 rounded px-2 py-1 text-xs font-bold bg-white focus:outline-none focus:border-red-600">
                                    <option value="Pending" {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Disetujui" {{ $item->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Ditolak" {{ $item->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <button type="submit" class="bg-black hover:bg-gray-800 text-white px-2 py-1 rounded text-xs transition" title="Simpan Status">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-400 italic">Belum ada pengajuan booking dari pelanggan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection