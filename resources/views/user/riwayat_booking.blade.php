@extends('layouts.user')

@section('title', 'Riwayat Booking Servis')

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-emerald-600"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="bg-black text-white px-4 py-3 font-bold flex justify-between items-center text-sm border-b-2 border-red-600">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-red-500"></i> Riwayat & Status Booking Servis
            </span>
            <span class="bg-gray-800 text-xs text-gray-300 px-2.5 py-0.5 rounded-full font-semibold">
                {{ count($bookings) }} Pengajuan
            </span>
        </div>

        <div class="p-4">
            @forelse($bookings as $item)
            <div class="border border-gray-200 rounded-xl p-4 mb-4 bg-gray-50/50 hover:border-red-500 transition space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b pb-2">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-car text-red-600 text-lg"></i>
                        <h3 class="font-bold text-gray-900 text-sm">
                            {{ $item->vehicle->tipe_mobil ?? 'Mobil Terhapus' }}  
                            <span class="font-mono text-gray-600">({{ $item->vehicle->plat_nomor ?? '-' }})</span>
                        </h3>
                    </div>

                    <!-- Badge Status -->
                    <div>
                        @if($item->status == 'Pending')
                            <span class="bg-amber-100 text-amber-800 border border-amber-300 text-xs font-bold px-3 py-1 rounded-full">
                                <i class="fa-solid fa-hourglass-half mr-1"></i> Menunggu Konfirmasi
                            </span>
                        @elseif($item->status == 'Disetujui')
                            <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 text-xs font-bold px-3 py-1 rounded-full">
                                <i class="fa-solid fa-circle-check mr-1"></i> Disetujui
                            </span>
                        @elseif($item->status == 'Selesai')
                            <span class="bg-blue-100 text-blue-800 border border-blue-300 text-xs font-bold px-3 py-1 rounded-full">
                                <i class="fa-solid fa-check-double mr-1"></i> Servis Selesai
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 border border-red-300 text-xs font-bold px-3 py-1 rounded-full">
                                <i class="fa-solid fa-circle-xmark mr-1"></i> Ditolak
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs text-gray-700">
                    <div>
                        <span class="text-gray-400 block font-semibold mb-0.5">Rincian Layanan & Sparepart:</span>
                        <p class="font-medium text-gray-800">{{ $item->items }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400 block font-semibold mb-0.5">Rencana Kedatangan:</span>
                        <p class="font-bold text-gray-900">
                            <i class="fa-regular fa-calendar-check text-red-600 mr-1"></i>
                            {{ \Carbon\Carbon::parse($item->booking_date)->format('d M Y - H:i') }} WIB
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-400 block font-semibold mb-0.5">Total Estimasi Biaya:</span>
                        <p class="font-black text-red-600 text-sm">
                            Rp {{ number_format($item->total_price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                @if($item->notes)
                <div class="bg-white p-2.5 rounded border text-xs text-gray-600">
                    <span class="font-bold text-gray-800">Catatan Tambahan:</span> {{ $item->notes }}
                </div>
                @endif
            </div>
            @empty
            <div class="text-center py-10 text-gray-400 space-y-2">
                <i class="fa-solid fa-calendar-xmark text-4xl text-gray-300 block"></i>
                <p class="text-xs italic">Belum ada riwayat booking servis. Buat melalui menu Kalkulator Servis!</p>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection