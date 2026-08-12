@extends('layouts.user')

@section('title', 'Katalog Servis & Kalkulator Estimasi')

@section('content')
<div class="space-y-4">

    @if(session('success'))
    <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-emerald-600"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

       
        <div class="lg:col-span-2 bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            
            <!-- Katalog Servis -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900">Katalog Servis</h2>
                <span class="text-xs text-gray-400 font-medium">Modul Orang ke-2</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                @forelse($catalogs->where('type', 'service') as $item)
                <label class="border border-gray-200 rounded-xl p-4 flex items-start gap-3 cursor-pointer hover:border-red-500 transition relative">
                    <input type="checkbox" data-name="{{ $item->name }}" data-price="{{ $item->price }}" class="item-checkbox mt-1 w-4 h-4 accent-black rounded">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-wrench text-xl text-gray-800"></i>
                            <h3 class="font-bold text-sm text-gray-900">{{ $item->name }}</h3>
                        </div>
                        <p class="text-xs text-gray-500 mb-2 leading-relaxed">{{ $item->description ?? 'Layanan perawatan kendaraan' }}</p>
                        <span class="font-bold text-sm text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    </div>
                </label>
                @empty
                <p class="text-xs text-gray-400 italic col-span-2">Belum ada paket servis yang ditambahkan Admin.</p>
                @endforelse
            </div>

            <!-- Sparepart Pendukung -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900">Sparepart Pendukung</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                @forelse($catalogs->where('type', 'sparepart') as $item)
                <label class="border border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-pointer hover:border-red-500 transition">
                    <input type="checkbox" data-name="{{ $item->name }}" data-price="{{ $item->price }}" class="item-checkbox w-4 h-4 accent-black rounded">
                    <i class="fa-solid fa-gears text-2xl text-gray-800"></i>
                    <div class="flex-1 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-sm text-gray-900">{{ $item->name }}</h3>
                            <span class="font-bold text-sm text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </label>
                @empty
                <p class="text-xs text-gray-400 italic col-span-2">Belum ada sparepart yang ditambahkan Admin.</p>
                @endforelse
            </div>

        </div>

        <!-- Kalkulator Estimasi Biaya-->
        <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 h-fit space-y-4">
            
            <!-- Header Kalkulator -->
            <div class="bg-black text-white p-3 rounded-md flex justify-between items-center text-sm font-bold">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-calculator text-red-500"></i>
                    <span>Kalkulator Estimasi Biaya</span>
                </div>
                <!-- Jumlah Mobil  -->
                <span class="bg-white text-black text-[10px] px-2 py-0.5 rounded font-bold">
                    {{ count($vehicles) }} Kendaraan
                </span>
            </div>

            <!-- Detail Mobil  -->
            <div class="space-y-1.5 p-2 bg-gray-50 rounded-lg border border-gray-200">
                <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">
                    <i class="fa-solid fa-car-side text-red-600 mr-1"></i> Pilih Mobil di Garasi Saya:
                </label>
                
                @if(count($vehicles) > 0)
                    <select name="vehicle_id" id="vehicleSelect" class="w-full border border-gray-300 rounded px-3 py-2 text-xs font-semibold text-gray-800 focus:outline-none focus:border-red-600 bg-white">
                        @foreach($vehicles as $v)
                            <option value="{{ $v->id }}">
                                {{ $v->tipe_mobil }} - ({{ $v->plat_nomor }})
                            </option>
                        @endforeach
                    </select>
                @else
                    <div class="p-2 text-center text-xs text-gray-500 bg-white border border-gray-200 rounded">
                        <span>Belum ada mobil di garasi. </span>
                        <a href="{{ route('user.profile') }}" class="text-red-600 font-bold underline">Tambah Mobil</a>
                    </div>
                @endif
            </div>

            <!--  Rincian Biaya  -->
            <div class="space-y-2.5 text-xs text-gray-700 pt-1">
                <div id="rincian-item-list" class="space-y-2">
                </div>

                <div class="border-t border-dashed border-gray-400 my-2 pt-2 flex justify-between font-bold text-sm text-gray-900">
                    <span>Subtotal</span>
                    <span id="subtotal-val">Rp 0</span>
                </div>

                <div class="flex justify-between text-xs text-gray-600">
                    <span>PPN (11%)</span>
                    <span id="ppn-val">Rp 0</span>
                </div>

                <div class="border-b-4 border-double border-gray-400 my-2"></div>

                <div class="flex justify-between items-baseline pt-1">
                    <span class="font-extrabold text-base text-gray-900">Total Estimasi:</span>
                    <span id="total-val" class="font-black text-xl text-red-600">Rp 0</span>
                </div>
            </div>

            <button class="w-full bg-black hover:bg-gray-900 text-white font-bold py-3 rounded-lg text-sm transition mt-4 flex items-center justify-center gap-2">
                <i class="fa-solid fa-calendar-check"></i> Simpan Estimasi / Ambil Jadwal
            </button>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkboxes = document.querySelectorAll(".item-checkbox");
        const rincianList = document.getElementById("rincian-item-list");
        const subtotalVal = document.getElementById("subtotal-val");
        const ppnVal = document.getElementById("ppn-val");
        const totalVal = document.getElementById("total-val");

        function formatRupiah(angka) {
            return "Rp " + angka.toLocaleString("id-ID");
        }

        function hitungTotal() {
            let subtotal = 0;
            rincianList.innerHTML = "";

            checkboxes.forEach(function (cb) {
                if (cb.checked) {
                    const nama = cb.getAttribute("data-name");
                    const harga = parseInt(cb.getAttribute("data-price"));
                    subtotal += harga;

                    const itemRow = document.createElement("div");
                    itemRow.className = "flex justify-between";
                    itemRow.innerHTML = `
                        <span>${nama}</span>
                        <span class="font-semibold text-gray-900">${formatRupiah(harga)}</span>
                    `;
                    rincianList.appendChild(itemRow);
                }
            });

            if (subtotal === 0) {
                rincianList.innerHTML = `<span class="text-gray-400 italic">Belum ada layanan dipilih</span>`;
            }

            const ppn = Math.round(subtotal * 0.11);
            const total = subtotal + ppn;

            subtotalVal.textContent = formatRupiah(subtotal);
            ppnVal.textContent = formatRupiah(ppn);
            totalVal.textContent = formatRupiah(total);
        }

        checkboxes.forEach(function (cb) {
            cb.addEventListener("change", hitungTotal);
        });

        hitungTotal();
    });
</script>
@endpush