@extends('layouts.admin')

@section('title', 'Admin Panel - Kelola Katalog & Sparepart')

@section('content')
<div class="space-y-6">

  
  @if(session('success'))
  <div class="bg-green-100 border border-green-300 text-green-800 p-3.5 rounded-lg text-sm flex items-center gap-2">
    <i class="fa-solid fa-circle-check text-green-600"></i>
    <span>{{ session('success') }}</span>
  </div>
  @endif


  <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
    <div class="bg-red-600 text-white px-4 py-3 font-bold flex items-center gap-2 text-sm">
      <i class="fa-solid fa-plus-circle"></i> Tambah Data Servis & Sparepart Baru
    </div>

    <form action="{{ route('admin.katalog.store') }}" method="POST" class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
      @csrf
      <div>
        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Layanan / Sparepart</label>
        <input type="text" name="name" required placeholder="misal: Servis Ringan / Rutin" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-red-600">
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-700 mb-1">Kategori</label>
        <select name="type" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-red-600 bg-white">
          <option value="service">Paket Servis</option>
          <option value="sparepart">Sparepart</option>
        </select>
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-700 mb-1">Harga (Rp)</label>
        <input type="number" name="price" required placeholder="450000" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-red-600">
      </div>

      <div class="md:col-span-3">
        <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi Singkat</label>
        <input type="text" name="description" placeholder="Deskripsi komponen atau garansi..." class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-red-600">
      </div>

      <div class="md:col-span-3 flex justify-end gap-2">
        <button type="submit" class="bg-black hover:bg-gray-800 text-white font-bold px-6 py-2 rounded text-sm transition">
          <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Data
        </button>
      </div>

    </form>
  </div>

 
  <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
    <div class="bg-black text-white px-4 py-3 font-bold flex justify-between items-center text-sm">
      <span><i class="fa-solid fa-list mr-1"></i> Daftar Katalog Aktif</span>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-sm">
        <thead>
          <tr class="bg-gray-100 border-b text-gray-600 text-xs uppercase">
            <th class="p-3">Nama Item</th>
            <th class="p-3">Kategori</th>
            <th class="p-3">Harga</th>
            <th class="p-3">Deskripsi</th>
            <th class="p-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse($catalogs as $item)
          <tr class="hover:bg-gray-50">
            <td class="p-3 font-semibold text-gray-900">{{ $item->name }}</td>
            <td class="p-3">
              @if($item->type == 'service')
                <span class="bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full">Paket Servis</span>
              @else
                <span class="bg-gray-200 text-gray-800 text-xs font-bold px-2.5 py-1 rounded-full">Sparepart</span>
              @endif
            </td>
            <td class="p-3 font-bold text-gray-800">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
            <td class="p-3 text-xs text-gray-500">{{ $item->description ?? '-' }}</td>
            <td class="p-3 text-center space-x-1">
              
              
              <button onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->name) }}', '{{ $item->type }}', {{ $item->price }}, '{{ addslashes($item->description ?? '') }}')" 
                      class="bg-gray-800 text-white px-2.5 py-1 rounded text-xs hover:bg-black transition">
                <i class="fa-solid fa-pen-to-square"></i> Edit
              </button>

           
              <form action="{{ route('admin.katalog.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin mau hapus item ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-100 text-red-600 border border-red-200 px-2.5 py-1 rounded text-xs hover:bg-red-600 hover:text-white transition">
                  <i class="fa-solid fa-trash"></i> Hapus
                </button>
              </form>

            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="p-4 text-center text-gray-400 italic">Belum ada data tersimpan di database. Silakan isi form di atas.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- MPOPUP EDIT DATA -->
<div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
  <div class="bg-white rounded-lg border border-gray-200 shadow-xl max-w-lg w-full overflow-hidden">
    <div class="bg-black text-white px-4 py-3 font-bold flex justify-between items-center text-sm">
      <span><i class="fa-solid fa-pen-to-square mr-1 text-red-500"></i> Edit Data Katalog</span>
      <button onclick="closeEditModal()" class="text-gray-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
    </div>

    <form id="editForm" method="POST" class="p-4 space-y-4">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Layanan / Sparepart</label>
        <input type="text" id="edit_name" name="name" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-red-600">
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-700 mb-1">Kategori</label>
        <select id="edit_type" name="type" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-red-600 bg-white">
          <option value="service">Paket Servis</option>
          <option value="sparepart">Sparepart</option>
        </select>
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-700 mb-1">Harga (Rp)</label>
        <input type="number" id="edit_price" name="price" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-red-600">
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi Singkat</label>
        <input type="text" id="edit_description" name="description" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-red-600">
      </div>

      <div class="flex justify-end gap-2 pt-2">
        <button type="button" onclick="closeEditModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-4 py-2 rounded text-xs">Batal</button>
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2 rounded text-xs transition">Update Data</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function openEditModal(id, name, type, price, description) {
    document.getElementById('editForm').action = '/admin/katalog/' + id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_type').value = type;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_description').value = description;
    
    document.getElementById('editModal').classList.remove('hidden');
  }

  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
  }
</script>
@endpush