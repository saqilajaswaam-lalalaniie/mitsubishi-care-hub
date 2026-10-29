<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun - PT Sun Star Prima Motor</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-950 font-sans text-gray-800 antialiased min-h-screen flex items-center justify-center p-4">

  <div class="max-w-md w-full bg-black border border-red-600/40 rounded-2xl shadow-2xl p-8 text-white relative overflow-hidden">
    <!-- Aksen Garis Merah di Atas Card -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-red-600"></div>

    <!-- Header Logo / Judul -->
    <div class="text-center mb-8">
      <img src="{{ asset('images/lg.png') }}" alt="Logo Mitsubishi" class="h-12 w-auto mx-auto mb-3 object-contain">
      <h1 class="text-xl font-bold tracking-wide">Sun Star Prima Motor</h1>
      <p class="text-xs text-gray-400 mt-1">Daftar akun baru garasi digital</p>
    </div>

    <!-- Menampilkan Pesan Error jika Pendaftaran Gagal -->
    @if ($errors->any())
      <div class="mb-4 p-3 bg-red-600/20 border border-red-600 text-red-400 text-xs rounded-lg">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Form Register -->
    <form action="{{ route('register') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Nama Lengkap</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i class="fa-solid fa-user"></i>
          </span>
          <input type="text" name="name" value="{{ old('name') }}" required autofocus
            class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-2.5 pl-10 text-sm text-white focus:outline-none focus:border-red-600 transition"
            placeholder="Nama Lengkap Anda">
        </div>
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Email</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i class="fa-solid fa-envelope"></i>
          </span>
          <input type="email" name="email" value="{{ old('email') }}" required
            class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-2.5 pl-10 text-sm text-white focus:outline-none focus:border-red-600 transition"
            placeholder="admin@sunstar.com">
        </div>
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Password</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i class="fa-solid fa-lock"></i>
          </span>
          <input type="password" name="password" required
            class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-2.5 pl-10 text-sm text-white focus:outline-none focus:border-red-600 transition"
            placeholder="••••••••">
        </div>
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Konfirmasi Password</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i class="fa-solid fa-lock"></i>
          </span>
          <input type="password" name="password_confirmation" required
            class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-2.5 pl-10 text-sm text-white focus:outline-none focus:border-red-600 transition"
            placeholder="••••••••">
        </div>
      </div>

      <button type="submit" 
        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl transition duration-200 text-sm shadow-lg shadow-red-600/30 flex items-center justify-center gap-2 mt-2">
        <i class="fa-solid fa-user-plus"></i> Daftar Sekarang
      </button>
    </form>

    <!-- Link ke Halaman Login -->
    <div class="text-center mt-5 text-xs text-gray-400">
      Sudah punya akun? 
      <a href="{{ route('login') }}" class="text-red-500 hover:text-red-400 font-semibold transition ml-1">Masuk di sini</a>
    </div>

    <div class="text-center mt-6 text-xs text-gray-600">
      &copy; 2026 PT Sun Star Prima Motor
    </div>
  </div>

</body>
</html>