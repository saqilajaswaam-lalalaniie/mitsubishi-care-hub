<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Panel')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans text-gray-800 antialiased min-h-screen flex flex-col relative">

  <!-- Overlay Sidebar -->
  <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity duration-300"></div>

  <!-- Sidebar -->
  <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-black text-white z-50 transform -translate-x-full transition-transform duration-300 ease-in-out border-r-2 border-red-600 shadow-2xl flex flex-col justify-between">
    <div>
      <!-- Header Sidebar -->
      <div class="p-5 border-b border-gray-800 flex justify-between items-center">
        <div class="flex items-center gap-2 text-red-600 font-bold text-base">
          <img src="{{ asset('images/lg.png') }}" alt="Logo" class="h-6 w-auto object-contain">
          <span class="text-white text-sm">PT Sun Star Prima Motor</span>
        </div>
        <button onclick="toggleSidebar()" class="text-gray-400 hover:text-white transition">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <!-- Menu Navigasi Admin -->
      <nav class="p-4 space-y-2">
        <div class="text-[10px] uppercase tracking-wider text-gray-500 font-bold px-3 mb-2">Navigasi Admin</div>
        
        <!-- Link Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-900 hover:text-white' }}">
          <i class="fa-solid fa-gauge w-5 text-center"></i>
          <span>Garasi Digital</span>
        </a>

        <!-- Link Booking -->
        <a href="{{ route('admin.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.bookings') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-900 hover:text-white' }}">
            <i class="fa-solid fa-list-check w-5 text-center text-base"></i>
            <span>Kelola Booking Servis</span>
        </a>

        <!-- Link Katalog & Sparepart (Menggunakan ikon Kunci Pas / Suku Cadang) -->
        <a href="{{ route('admin.katalog') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition {{ request()->routeIs('admin.katalog') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-900 hover:text-white' }}">
          <i class="fa-solid fa-screwdriver-wrench w-5 text-center"></i>
          <span>Kelola Katalog & Sparepart</span>
        </a>
      </nav>
    </div>

    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-gray-800 bg-gray-950">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center text-white font-bold text-xs">
          <i class="fa-solid fa-user-shield"></i>
        </div>
        <div class="flex-1 overflow-hidden">
          <p class="text-xs font-bold text-white truncate">Admin Diler</p>
          <p class="text-[10px] text-gray-400">Administrator</p>
        </div>
      </div>
    </div>
  </aside>

  <!-- Navbar Atas -->
  <nav class="bg-black text-white border-b-2 border-red-600 px-6 py-3 flex justify-between items-center sticky top-0 z-30 shadow-md">
    <div class="flex items-center gap-4">
      <button onclick="toggleSidebar()" class="bg-gray-900 hover:bg-red-600 text-white p-2 rounded-lg transition border border-gray-800 focus:outline-none">
        <i class="fa-solid fa-bars text-lg"></i>
      </button>

      <div class="flex items-center gap-3">
        <img src="{{ asset('images/lg.png') }}" alt="Logo Mitsubishi" class="h-8 w-auto object-contain">
        <span class="text-white font-bold tracking-wide text-base sm:text-lg">Sun Star Prima Motor</span>
        <span class="bg-red-600/20 border border-red-600/40 text-xs text-red-400 px-2.5 py-0.5 rounded-full ml-2 hidden sm:inline-block">Admin Panel</span>
      </div>
    </div>

    <div class="flex items-center gap-3">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="bg-red-600 text-white px-4 py-1.5 rounded-full text-xs font-semibold hover:bg-red-700 transition flex items-center gap-1 shadow-sm">
          <i class="fa-solid fa-right-from-bracket"></i> Logout
        </button>
      </form>
    </div>
  </nav>

  <main class="max-w-6xl w-full mx-auto my-6 p-4 flex-1">
    @yield('content')
  </main>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebar-overlay');
      
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    }
  </script>

  @stack('scripts')
</body>
</html>