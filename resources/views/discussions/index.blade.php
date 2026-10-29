<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Tanya Jawab Komunitas - Mitsubishi Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">

    <nav class="bg-black text-white p-4 flex justify-between items-center border-b-4 border-red-600">
        <div class="font-bold text-lg text-red-600 flex items-center gap-2">
            🚗 MITSUBISHI CARE
        </div>
        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('forum.index') }}" class="hover:text-red-500 font-semibold">Forum QnA</a>
            @if(Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="hover:text-red-500">Dashboard Admin</a>
            @else
                <a href="{{ route('user.dashboard') }}" class="hover:text-red-500">Garasi Saya</a>
            @endif
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-4xl">
        
        @if(session('success'))
        <div class="bg-[#d4edda] border border-[#c3e6cb] text-[#155724] px-4 py-3 rounded-lg mb-6 shadow-sm flex items-center gap-2 text-sm font-medium">
            <i class="fa-solid fa-circle-check text-green-600"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tanya Jawab & Forum Komunitas</h1>
                <p class="text-sm text-gray-600">Diskusikan kendala kendaraan Anda atau cari solusi resmi dari diler.</p>
            </div>
            
            <button onclick="document.getElementById('modalCreate').classList.remove('hidden')" class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition">
                + Buat Pertanyaan Baru
            </button>
        </div>

        <form method="GET" action="{{ route('forum.index') }}" class="bg-white p-4 rounded-lg shadow mb-6 flex flex-col md:flex-row gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau isi pertanyaan..." class="flex-1 border rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
            
            <select name="category" class="border rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Semua Kategori</option>
                <option value="Mesin" {{ request('category') == 'Mesin' ? 'selected' : '' }}>Mesin</option>
                <option value="Kelistrikan" {{ request('category') == 'Kelistrikan' ? 'selected' : '' }}>Kelistrikan</option>
                <option value="AC" {{ request('category') == 'AC' ? 'selected' : '' }}>AC</option>
                <option value="Kaki-kaki" {{ request('category') == 'Kaki-kaki' ? 'selected' : '' }}>Kaki-kaki</option>
                <option value="Lainnya" {{ request('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>

            <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 transition">Cari</button>
        </form>

        <div class="space-y-6">
            @forelse($discussions as $item)
                <div class="bg-white p-5 rounded-lg shadow border-l-4 border-red-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full font-semibold">{{ $item->category }}</span>
                            <h2 class="text-lg font-bold mt-2 text-gray-900">{{ $item->title }}</h2>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded-full font-semibold {{ $item->status == 'Terjawab' || $item->status == 'Solusi Resmi' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $item->status ?? 'Menunggu' }}
                        </span>
                    </div>
                    <p class="text-gray-600 mt-2 text-sm whitespace-pre-line">{{ $item->content }}</p>
                    
                    <div class="mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center text-xs text-gray-400 border-t pt-3 gap-2">
                        <span>Ditulis oleh: <strong class="text-gray-700">{{ $item->user->name ?? 'Anonim' }}</strong> pada {{ $item->created_at->format('d M Y, H:i') }}</span>
                        
                        <div class="flex items-center gap-3">
                            @if(Auth::check() && Auth::user()->role === 'admin')
                                <form action="{{ route('forum.update', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Solusi Resmi">
                                    <button type="submit" class="text-blue-600 hover:underline font-semibold">Tandai Solusi Resmi</button>
                                </form>
                            @endif

                            {{-- Tombol Edit untuk Pemilik Pertanyaan atau Admin --}}
                            @if(Auth::check() && (Auth::id() === $item->user_id || Auth::user()->role === 'admin'))
                                <button type="button" onclick="openEditModal({{ $item->id }})" class="text-blue-600 hover:underline font-semibold">Edit</button>

                                <form action="{{ route('forum.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus diskusi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline font-semibold">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="mt-5 border-t pt-4 bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-xs font-bold uppercase text-gray-500 mb-3">Balasan / Solusi ({{ $item->replies->count() }})</h3>
                        
                        <div class="space-y-3 mb-4">
                            @forelse($item->replies as $reply)
                                @if(optional($reply->user)->role === 'admin')
                                    <div class="bg-red-50 border-l-4 border-red-600 p-3.5 rounded-r-lg text-sm relative shadow-sm">
                                        <div class="flex justify-between items-start mb-1">
                                            <span class="font-bold text-red-700 text-xs flex items-center gap-1.5">
                                                🛡️ {{ $reply->user->name ?? 'Admin' }} 
                                                <span class="bg-red-600 text-white text-[10px] px-2 py-0.5 rounded-full font-semibold uppercase tracking-wider">Respon Resmi Diler</span>
                                            </span>
                                        </div>
                                        
                                        <p class="text-gray-800 text-xs whitespace-pre-line font-medium mt-1 mb-2">{{ $reply->content }}</p>

                                        <div class="flex justify-between items-center text-[10px] text-gray-500 border-t border-red-200 pt-2">
                                            <span>{{ $reply->created_at->format('d M Y, H:i') }}</span>

                                            @if(Auth::check() && (Auth::id() === $reply->user_id || Auth::user()->role === 'admin'))
                                                <form action="{{ route('reply.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Hapus balasan resmi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline font-semibold">✕ Hapus Balasan</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-white border border-gray-200 p-3 rounded-lg text-sm relative">
                                        <div class="flex justify-between items-start mb-1">
                                            <span class="font-bold text-gray-800 text-xs flex items-center gap-1">
                                                👤 {{ $reply->user->name ?? 'Anonim' }}
                                            </span>
                                        </div>

                                        <p class="text-gray-600 text-xs whitespace-pre-line mt-1 mb-2">{{ $reply->content }}</p>

                                        <div class="flex justify-between items-center text-[10px] text-gray-400 border-t border-gray-100 pt-2">
                                            <span>{{ $reply->created_at->format('d M Y, H:i') }}</span>

                                            @if(Auth::check() && (Auth::id() === $reply->user_id || Auth::user()->role === 'admin'))
                                                <form action="{{ route('reply.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Hapus balasan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:underline font-semibold">✕ Hapus</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p class="text-xs text-gray-400 italic">Belum ada balasan untuk diskusi ini.</p>
                            @endforelse
                        </div>

                        <!-- Form Kirim Balasan -->
                        <form action="{{ route('reply.store', $item->id) }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="reply" placeholder="Tulis balasan atau solusi..." class="flex-1 border rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 bg-white" required>
                            <button type="submit" class="bg-black text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-gray-800 transition">Kirim</button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="bg-white p-10 text-center rounded-lg shadow text-gray-500">
                    Belum ada diskusi atau pertanyaan ditemukan.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $discussions->links() }}
        </div>
    </div>

    <!-- MODAL CREATE -->
    <div id="modalCreate" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-xl">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Buat Pertanyaan Baru</h2>
            <form action="{{ route('forum.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Kategori Kendala</label>
                    <select name="category" class="w-full border rounded-lg p-2.5 mt-1 text-sm focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        <option value="Mesin">Mesin</option>
                        <option value="Kelistrikan">Kelistrikan</option>
                        <option value="AC">AC</option>
                        <option value="Kaki-kaki">Kaki-kaki / Suspensi</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Judul Kendala / Pertanyaan</label>
                    <input type="text" name="title" class="w-full border rounded-lg p-2.5 mt-1 text-sm focus:outline-none focus:ring-2 focus:ring-red-500" required placeholder="Contoh: Suara berdengung di bagian mesin saat RPM tinggi">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Detail Pertanyaan</label>
                    <textarea name="content" rows="4" class="w-full border rounded-lg p-2.5 mt-1 text-sm focus:outline-none focus:ring-2 focus:ring-red-500" required placeholder="Jelaskan kendala mobil Anda secara detail..."></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modalCreate').classList.add('hidden')" class="bg-gray-300 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-400">Batal</button>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700">Kirim Pertanyaan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT UNTUK SETIAP DISKUSI -->
    @foreach($discussions as $item)
    <div id="editModal{{ $item->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-xl">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Edit Pertanyaan</h2>
            <form action="{{ route('forum.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Kategori Kendala</label>
                    <select name="category" class="w-full border rounded-lg p-2.5 mt-1 text-sm focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        <option value="Mesin" {{ $item->category == 'Mesin' ? 'selected' : '' }}>Mesin</option>
                        <option value="Kelistrikan" {{ $item->category == 'Kelistrikan' ? 'selected' : '' }}>Kelistrikan</option>
                        <option value="AC" {{ $item->category == 'AC' ? 'selected' : '' }}>AC</option>
                        <option value="Kaki-kaki" {{ $item->category == 'Kaki-kaki' ? 'selected' : '' }}>Kaki-kaki / Suspensi</option>
                        <option value="Lainnya" {{ $item->category == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Judul Kendala / Pertanyaan</label>
                    <input type="text" name="title" value="{{ $item->title }}" class="w-full border rounded-lg p-2.5 mt-1 text-sm focus:outline-none focus:ring-2 focus:ring-red-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Detail Pertanyaan</label>
                    <textarea name="content" rows="4" class="w-full border rounded-lg p-2.5 mt-1 text-sm focus:outline-none focus:ring-2 focus:ring-red-500" required>{{ $item->content }}</textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal({{ $item->id }})" class="bg-gray-300 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-400">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <script>
        function openEditModal(id) {
            document.getElementById('editModal' + id).classList.remove('hidden');
        }
        function closeEditModal(id) {
            document.getElementById('editModal' + id).classList.add('hidden');
        }
    </script>

</body>
</html>