@extends('layouts.admin')

@section('title', 'Kelola Forum QnA - Admin Panel')

@section('content')
<div class="space-y-6">

    <!-- Pesan Sukses -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 p-3.5 rounded-lg text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-green-600"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Header Modul Forum -->
    <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-1">Moderasi Forum QnA</h1>
            <p class="text-xs text-gray-500">Kelola pertanyaan, diskusi, dan berikan solusi resmi untuk kendala kendaraan pelanggan.</p>
        </div>
        <div class="bg-gray-50 p-3.5 rounded-lg border border-gray-200 self-start md:self-auto min-w-[200px]">
            <span class="text-[10px] uppercase font-bold text-gray-500 block mb-1">Total Pertanyaan</span>
            <div class="flex items-center gap-2">
                <span class="text-2xl font-bold text-gray-900">{{ isset($forums) ? count($forums) : 0 }}</span>
                <span class="bg-red-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">Diskusi Masuk</span>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Pertanyaan -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        
        <div class="bg-black text-white px-4 py-3 font-bold flex items-center justify-between text-sm">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-comments text-red-500"></i>
                <span>Daftar Tanya Jawab Komunitas</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b text-gray-600 text-xs uppercase">
                        <th class="p-3">Pengguna</th>
                        <th class="p-3">Kategori & Judul Kendala</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3 text-center">Aksi (CRUD)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($forums ?? [] as $forum)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3">
                            <div class="font-bold text-gray-900">{{ $forum->user->name ?? 'Pelanggan' }}</div>
                            <div class="text-[10px] text-gray-400">{{ $forum->user->email ?? '-' }}</div>
                        </td>
                        <td class="p-3">
                            <span class="bg-red-100 text-red-700 font-bold px-2 py-0.5 rounded text-[10px] inline-block mb-1">{{ $forum->category ?? $forum->kategori ?? 'Umum' }}</span>
                            <div class="font-semibold text-gray-800 text-xs">{{ $forum->title ?? $forum->judul ?? $forum->content ?? 'Pertanyaan Diskusi' }}</div>
                        </td>
                        <td class="p-3">
                            <span class="bg-amber-100 text-amber-700 font-bold px-2.5 py-1 rounded-full text-[10px]">
                                {{ $forum->status ?? 'Menunggu Solusi' }}
                            </span>
                        </td>
                        <td class="p-3 text-xs text-gray-500">
                            {{ $forum->created_at ? $forum->created_at->format('d M Y') : '-' }}
                        </td>
                        <td class="p-3 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <!-- Tombol Balas (Memicu Modal) -->
                                <button type="button" onclick="openReplyModal({{ $forum->id }})" class="bg-gray-100 hover:bg-gray-800 hover:text-white text-gray-700 border border-gray-300 px-2.5 py-1 rounded text-xs transition" title="Berikan Solusi">
                                    <i class="fa-solid fa-reply"></i> Balas
                                </button>
                                
                                <!-- Tombol Edit (Memicu Modal Edit) -->
                                <button type="button" onclick="openEditModal({{ $forum->id }})" class="bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-600 border border-blue-200 px-2.5 py-1 rounded text-xs transition" title="Edit Pertanyaan">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>

                                <!-- Tombol Hapus (Delete CRUD) -->
                                <form action="{{ route('admin.forum.destroy', $forum->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pertanyaan ini dari forum?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-100 hover:bg-red-600 hover:text-white text-red-600 border border-red-200 px-2 py-1 rounded text-xs transition" title="Hapus Pertanyaan">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">
                            <i class="fa-solid fa-comments text-4xl mb-2 text-gray-300 block"></i>
                            <p class="text-xs italic">Belum ada pertanyaan atau diskusi dari forum.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- MODAL BALAS DISKUSI (Untuk Admin Memberikan Solusi) -->
@foreach($forums ?? [] as $forum)
<div id="replyModal{{ $forum->id }}" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg border border-gray-200 shadow-xl max-w-lg w-full overflow-hidden">
        <div class="bg-black text-white px-4 py-3 font-bold flex justify-between items-center text-sm">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-reply text-red-500"></i> Berikan Solusi Resmi Diler
            </span>
            <button type="button" onclick="closeReplyModal({{ $forum->id }})" class="text-gray-400 hover:text-white">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form action="{{ route('reply.store', $forum->id) }}" method="POST">
            @csrf
            <div class="p-5 space-y-4 text-xs">
                <div>
                    <span class="text-gray-500 block mb-1">Pertanyaan dari: <strong>{{ $forum->user->name ?? 'Pelanggan' }}</strong></span>
                    <p class="p-3 bg-gray-50 rounded border border-gray-200 text-gray-800 font-medium italic">
                        "{{ $forum->title ?? $forum->judul ?? $forum->content }}"
                    </p>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Tulis Balasan / Solusi Servis:</label>
                    <textarea name="reply" rows="4" required class="w-full border border-gray-300 rounded p-2.5 focus:outline-none focus:ring-1 focus:ring-red-600 text-xs" placeholder="Ketik solusi atau arahan servis untuk pelanggan di sini..."></textarea>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 flex justify-end gap-2">
                <button type="button" onclick="closeReplyModal({{ $forum->id }})" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-4 py-1.5 rounded text-xs transition">
                    Batal
                </button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-1.5 rounded text-xs transition">
                    Kirim Solusi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT DISKUSI (Untuk Admin Mengedit Pertanyaan) -->
<div id="editModal{{ $forum->id }}" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg border border-gray-200 shadow-xl max-w-lg w-full overflow-hidden">
        <div class="bg-black text-white px-4 py-3 font-bold flex justify-between items-center text-sm">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-blue-500"></i> Edit Pertanyaan Forum
            </span>
            <button type="button" onclick="closeEditModal({{ $forum->id }})" class="text-gray-400 hover:text-white">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form action="{{ route('forum.update', $forum->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Kategori Kendala:</label>
                    <select name="category" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-1 focus:ring-blue-600 text-xs" required>
                        <option value="Mesin" {{ ($forum->category ?? $forum->kategori) == 'Mesin' ? 'selected' : '' }}>Mesin</option>
                        <option value="Kelistrikan" {{ ($forum->category ?? $forum->kategori) == 'Kelistrikan' ? 'selected' : '' }}>Kelistrikan</option>
                        <option value="AC" {{ ($forum->category ?? $forum->kategori) == 'AC' ? 'selected' : '' }}>AC</option>
                        <option value="Kaki-kaki" {{ ($forum->category ?? $forum->kategori) == 'Kaki-kaki' ? 'selected' : '' }}>Kaki-kaki / Suspensi</option>
                        <option value="Lainnya" {{ ($forum->category ?? $forum->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Judul Kendala:</label>
                    <input type="text" name="title" value="{{ $forum->title ?? $forum->judul }}" required class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-1 focus:ring-blue-600 text-xs">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Detail Pertanyaan:</label>
                    <textarea name="content" rows="4" required class="w-full border border-gray-300 rounded p-2.5 focus:outline-none focus:ring-1 focus:ring-blue-600 text-xs">{{ $forum->content }}</textarea>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 flex justify-end gap-2">
                <button type="button" onclick="closeEditModal({{ $forum->id }})" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-4 py-1.5 rounded text-xs transition">
                    Batal
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-1.5 rounded text-xs transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    function openReplyModal(id) {
        document.getElementById('replyModal' + id).classList.remove('hidden');
    }

    function closeReplyModal(id) {
        document.getElementById('replyModal' + id).classList.add('hidden');
    }

    function openEditModal(id) {
        document.getElementById('editModal' + id).classList.remove('hidden');
    }

    function closeEditModal(id) {
        document.getElementById('editModal' + id).classList.add('hidden');
    }
</script>
@endpush
@endsection