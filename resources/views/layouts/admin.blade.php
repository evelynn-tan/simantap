<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - SIMANTAP')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; }
        html, body { font-family: 'Poppins', sans-serif; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
        
        /* Auto-dismiss alerts */
        .alert-auto-hide {
            animation: fadeInOut 6s ease-in-out forwards;
        }
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-20px); }
            10% { opacity: 1; transform: translateY(0); }
            85% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-20px); pointer-events: none; }
        }
    </style>
</head>
<body class="bg-slate-50" style="font-family: 'Poppins', sans-serif;">

    <!-- Main Container with Alpine.js State -->
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden bg-slate-50">
        
        <!-- SIDEBAR -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform duration-300 ease-in-out lg:translate-x-0 bg-gradient-to-b from-blue-950 via-blue-900 to-slate-900 text-white" 
            aria-label="Sidebar">
            
            <!-- Mobile Overlay Backdrop -->
            <div x-show="sidebarOpen" 
                 x-cloak
                 @click="sidebarOpen = false" 
                 class="fixed inset-0 bg-black/50 z-[-1] lg:hidden"
                 x-transition:enter="transition-opacity ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
            </div>

            <div class="h-full flex flex-col" style="font-family: 'Poppins', sans-serif;">
                <!-- Logo Header with Close Button for Mobile -->
                <div class="p-4 lg:p-5 border-b border-blue-800 bg-gradient-to-r from-blue-950 to-blue-900 shadow-lg">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 hover:opacity-80 transition">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('images/logo-bps.png') }}" alt="Logo" class="w-8 h-8">
                            </div>
                            <div>
                                <h1 class="text-lg lg:text-xl font-bold text-white tracking-wider">SIMANTAP</h1>
                                <p class="text-[10px] lg:text-xs text-blue-200 font-medium hidden sm:block">BPS Kota Tanjungpinang</p>
                            </div>
                        </a>
                        <!-- Close Button (Mobile Only) -->
                        <button @click="sidebarOpen = false" class="lg:hidden p-2 rounded-lg hover:bg-blue-800 transition">
                            <i class="fas fa-times text-white text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Menu Items -->
                <div class="px-3 py-4 lg:py-5 overflow-y-auto flex-1 bg-gradient-to-b from-blue-900 to-blue-950 scrollbar-hide">
                    <ul class="space-y-1.5 lg:space-y-2 font-medium text-sm">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-blue-100 rounded-lg transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white' }}">
                                <i class="fas fa-chart-line w-5 h-5 text-yellow-300"></i>
                                <span class="ml-3 font-semibold">Dashboard</span>
                            </a>
                        </li>

                        <!-- Manajemen Permintaan -->
                        <li>
                            <a href="{{ route('admin.permintaan.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-blue-100 rounded-lg transition duration-200 {{ request()->routeIs('admin.permintaan.*') ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white' }}">
                                <i class="fas fa-file-alt w-5 h-5 text-emerald-300"></i>
                                <span class="ml-3 font-semibold">Proses Permintaan</span>
                            </a>
                        </li>

                        <!-- Data Barang -->
                        <li>
                            <a href="{{ route('admin.barang.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-blue-100 rounded-lg transition duration-200 {{ request()->routeIs('admin.barang.index') || (request()->routeIs('admin.barang.*') && !request()->routeIs('admin.barang.create')) ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white' }}">
                                <i class="fas fa-box w-5 h-5 text-cyan-300"></i>
                                <span class="ml-3 font-semibold">Data Barang</span>
                            </a>
                        </li>

                        <!-- Tambah Barang -->
                        <li>
                            <a href="{{ route('admin.barang.create') }}" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-blue-100 rounded-lg transition duration-200 {{ request()->routeIs('admin.barang.create') ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white' }}">
                                <i class="fas fa-plus-circle w-5 h-5 text-lime-300"></i>
                                <span class="ml-3 font-semibold">Tambah Barang</span>
                            </a>
                        </li>

                        <!-- Divider -->
                        <div class="my-2 lg:my-3 border-t border-blue-800"></div>

                        <!-- Stock Opname -->
                        <li>
                            <a href="{{ route('admin.stock-opname.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-blue-100 rounded-lg transition duration-200 {{ request()->routeIs('admin.stock-opname.*') ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white' }}">
                                <i class="fas fa-check-square w-5 h-5 text-orange-300"></i>
                                <span class="ml-3 font-semibold">Stock Opname</span>
                            </a>
                        </li>

                        <!-- Manajemen Pengguna -->
                        <li>
                            <a href="{{ route('admin.pengguna.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-blue-100 rounded-lg transition duration-200 {{ request()->routeIs('admin.pengguna.*') ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white' }}">
                                <i class="fas fa-users w-5 h-5 text-pink-300"></i>
                                <span class="ml-3 font-semibold">Manajemen Pengguna</span>
                            </a>
                        </li>

                        <!-- Laporan -->
                        <li>
                            <a href="{{ route('admin.laporan.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-blue-100 rounded-lg transition duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white' }}">
                                <i class="fas fa-file-pdf w-5 h-5 text-red-300"></i>
                                <span class="ml-3 font-semibold">Buat Laporan</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Logout Button - Bottom Left -->
                <div class="p-3 lg:p-4 border-t border-blue-800 bg-blue-950 mt-auto">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 lg:px-4 py-2 lg:py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-lg transition duration-200 shadow-lg border border-red-500 text-sm">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar Sistem</span>
                        </button>
                    </form>
                    <p class="text-[10px] lg:text-xs text-blue-300 text-center mt-2 lg:mt-3">© 2025 SIMANTAP</p>
                </div>
            </div>
        </aside>

        <!-- KONTEN UTAMA (Sebelah Kanan Sidebar) -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden lg:ml-64">
            
            <!-- HEADER ATAS -->
            <header class="bg-white shadow-sm border-b border-slate-200 z-10 sticky top-0">
                <div class="flex justify-between items-center px-3 sm:px-4 lg:px-6 py-3 lg:py-4">
                    <!-- Left: Hamburger + Logo + Title -->
                    <div class="flex items-center gap-2 sm:gap-3 lg:gap-4">
                        <!-- Hamburger Menu Button (Mobile & Tablet Only) -->
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="lg:hidden p-2 sm:p-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition shadow-md flex items-center justify-center">
                            <i class="fas fa-bars text-base sm:text-lg"></i>
                        </button>
                        
                        <!-- Logo (Hidden on mobile) -->
                        <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" class="h-8 sm:h-10 lg:h-12 w-auto hidden sm:block">
                        
                        <div class="min-w-0">
                            <h2 class="text-sm sm:text-lg lg:text-2xl font-bold text-slate-800 leading-tight truncate" style="font-family: 'Poppins', sans-serif;">
                                @yield('header', 'Dashboard Admin')
                            </h2>
                            <p class="text-[10px] sm:text-xs lg:text-sm text-slate-500 mt-0.5 hidden sm:block truncate">@yield('subtitle', 'Selamat datang di SIMANTAP')</p>
                        </div>
                    </div>
                    
                    <!-- Right: User Info -->
                    <div class="flex items-center space-x-2 sm:space-x-3 lg:space-x-4">
                        <div class="text-right">
                            <div class="text-xs sm:text-sm lg:text-lg font-semibold text-slate-900 truncate max-w-[80px] sm:max-w-[120px] lg:max-w-none">{{ Auth::user()->name ?? 'User' }}</div>
                            <div class="text-[10px] sm:text-xs lg:text-sm text-slate-600 hidden sm:block capitalize">{{ Auth::user()->role ?? 'Operator' }}</div>
                        </div>
                        <!-- Avatar -->
                        <div class="w-8 h-8 sm:w-10 sm:h-10 lg:w-11 lg:h-11 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold text-sm sm:text-base lg:text-lg shadow-md">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- ISI KONTEN DINAMIS -->
            <main class="w-full flex-grow p-3 sm:p-4 lg:p-6">
                @if ($errors->any())
                    <div class="mb-3 sm:mb-4 lg:mb-6 p-3 sm:p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 alert-auto-hide">
                        <p class="font-semibold mb-2 text-xs sm:text-sm lg:text-base">❌ Terjadi Kesalahan:</p>
                        <ul class="list-disc list-inside text-[10px] sm:text-xs lg:text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-3 sm:mb-4 lg:mb-6 p-3 sm:p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 alert-auto-hide">
                        <p class="font-semibold text-xs sm:text-sm lg:text-base">✅ {{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-3 sm:mb-4 lg:mb-6 p-3 sm:p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 alert-auto-hide">
                        <p class="font-semibold text-xs sm:text-sm lg:text-base">❌ {{ session('error') }}</p>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-3 sm:mb-4 lg:mb-6 p-3 sm:p-4 bg-yellow-50 border border-yellow-200 rounded-xl text-yellow-800 alert-auto-hide">
                        <p class="font-semibold text-xs sm:text-sm lg:text-base">⚠️ {{ session('warning') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
            
        </div>
    </div>
</body>
</html>