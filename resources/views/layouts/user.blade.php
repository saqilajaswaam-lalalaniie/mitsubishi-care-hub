<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pelanggan - Mitsubishi')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans text-gray-800 antialiased min-h-screen flex flex-col relative">

    <!-- Overlay Hitam Transparan saat Sidebar Terbuka -->
    <div id="user-sidebar-overlay" onclick="toggleUserSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity duration-300"></div>

    <!-- Sidebar Collapsible User -->
    <aside id="user-sidebar" class="fixed top-0 left-0 h-full w-64 bg-black text-white z-50 transform -translate-x-full transition-transform duration-300 ease-in-out border-r-2 border-red-600 shadow-2xl flex flex-col justify-between">
        <div>
            <!-- Header Sidebar -->
            <div class="p-5 border-b border-gray-800 flex justify-between items-center">
                <div class="flex items-center gap-2 text-red-600 font-bold text-base">
                    <i class="fa-solid fa-car text-xl"></i>
                    <span class="text-white">LOGO TAR GANTI AJ</span>
                </div>
                <button onclick="toggleUserSidebar()" class="text-gray-400 hover:text-white transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Menu Navigasi Pelanggan -->
            <nav class="p-4 space-y-2">
                <div class="text-[10px] uppercase tracking-wider text-gray-500 font-bold px-3 mb-2">Menu Pelanggan</div>
                
                <!-- Link Beranda Utama / Dashboard User -->
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('user.dashboard') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-900 hover:text-white' }}">
                    <i class="fa-solid fa-store w-5 text-center text-base"></i>
                    <span>Beranda Utama</span>
                </a>

                <!-- Link Profil & Garasi Digital -->
                <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('user.profile') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-900 hover:text-white' }}">
                    <i class="fa-solid fa-user-gear w-5 text-center text-base"></i>
                    <span>Profil & Garasi Saya</span>
                </a>

                <!-- Link Katalog & Estimasi Biaya -->
                <a href="{{ route('user.katalog') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('user.katalog') ? 'bg-red-600 text-white' : 'text-gray-300 hover:bg-gray-900 hover:text-white' }}">
                    <i class="fa-solid fa-calculator w-5 text-center text-base"></i>
                    <span>Katalog & Kalkulator Servis</span>
                </a>
            </nav>
        </div>

        <!-- Footer Sidebar (Info Pelanggan) -->
        <div class="p-4 border-t border-gray-800 bg-gray-950">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-xs font-bold text-white truncate m-0">{{ Auth::user()->name ?? 'Pelanggan' }}</p>
                    <p class="text-[10px] text-gray-400 m-0 truncate">{{ Auth::user()->email ?? 'User' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Top Navbar Bar -->
    <nav class="bg-black text-white border-b-2 border-red-600 px-6 py-3 flex justify-between items-center sticky top-0 z-30 shadow-md">
        <div class="flex items-center gap-4">
            
            <button onclick="toggleUserSidebar()" class="bg-gray-900 hover:bg-red-600 text-white p-2 rounded-lg transition border border-gray-800 focus:outline-none">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>

            <div class="flex items-center gap-2 font-bold text-lg text-red-600">
                <i class="fa-solid fa-car"></i>
                <span class="text-white tracking-wide">LOGO TAR GANTI AJ</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 rounded-full text-xs font-semibold transition flex items-center gap-1 border-0">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Content Utama -->
    <main class="max-w-7xl w-full mx-auto my-6 px-4 flex-1">
        @yield('content')
    </main>

    
    <script>
        function toggleUserSidebar() {
            const sidebar = document.getElementById('user-sidebar');
            const overlay = document.getElementById('user-sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>

    @stack('scripts')
</body>
</html>