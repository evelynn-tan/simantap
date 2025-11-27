<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMANTAP - Pegawai')</title>
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Google Fonts: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Alpine.js (Untuk Interaksi Mobile) --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom Scrollbar agar lebih rapi */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="lg:hidden flex justify-between items-center bg-white p-4 shadow-sm sticky top-0 z-20">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo-bps.png') }}" alt="Logo" class="w-8 h-8">
            <span class="font-bold text-emerald-700">SIMANTAP</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-600 hover:text-emerald-600 focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>

    <div class="flex h-screen overflow-hidden">
        
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-slate-100 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col h-full shadow-lg lg:shadow-none">
            
            <div class="h-20 flex items-center px-6 border-b border-slate-50">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" class="w-9 h-9 object-contain">
                    <div class="leading-tight">
                        <h1 class="text-xl font-extrabold text-emerald-700 tracking-tight">SIMANTAP</h1>
                        <p class="text-[10px] font-medium text-slate-400 uppercase tracking-wider">Aset Negara</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden ml-auto text-slate-400 hover:text-red-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                
                {{-- Helper function untuk class menu --}}
                @php
                    function getMenuClass($routeName) {
                        $isActive = request()->routeIs($routeName);
                        $baseClass = "flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group";
                        
                        if ($isActive) {
                            return "$baseClass bg-emerald-50 text-emerald-700 shadow-sm";
                        }
                        return "$baseClass text-slate-500 hover:bg-slate-50 hover:text-emerald-600";
                    }
                @endphp
                
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Menu Utama</p>

                <a href="{{ route('pegawai.dashboard') }}" class="{{ getMenuClass('pegawai.dashboard') }}">
                    <i class="{{ request()->routeIs('pegawai.dashboard') ? 'fas' : 'far' }} fa-compass w-5 text-center"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('pegawai.daftar-barang') }}" class="{{ getMenuClass('pegawai.daftar-barang') }}">
                    <i class="{{ request()->routeIs('pegawai.daftar-barang') ? 'fas' : 'far' }} fa-folder-open w-5 text-center"></i>
                    Daftar Barang
                </a>
                
                <a href="{{ route('pegawai.monitor-permintaan') }}" class="{{ getMenuClass('pegawai.monitor-permintaan') }}">
                    <i class="{{ request()->routeIs('pegawai.monitor-permintaan') ? 'fas' : 'far' }} fa-eye w-5 text-center"></i>
                    Monitor Status
                </a>

                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-6 mb-2">Pengaturan</p>
                
                <a href="{{ route('pegawai.edit-profil') }}" class="{{ getMenuClass('pegawai.edit-profil') }}">
                    <i class="{{ request()->routeIs('pegawai.edit-profil') ? 'fas' : 'far' }} fa-user-circle w-5 text-center"></i>
                    Edit Profil
                </a>
            </nav>

            <div class="p-4 border-t border-slate-50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar Aplikasi</span>
                    </button>
                </form>
            </div>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-slate-900/50 z-20 lg:hidden" x-cloak></div>

        <div class="flex-1 flex flex-col h-full overflow-hidden relative">
            
            <header class="bg-white/80 backdrop-blur-md sticky top-0 z-10 border-b border-slate-100 h-20 hidden lg:flex items-center justify-between px-8">
                
                <div>
                    <h2 class="text-lg font-bold text-slate-800">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">@yield('page-subtitle', 'Overview & Statistik')</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-bold text-slate-800">{{ $pegawai->nama_lengkap ?? 'Pegawai' }}</p>
                        <p class="text-xs text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded-full inline-block">
                            Pegawai BPS
                        </p>
                    </div>
                    
                    <div class="w-10 h-10 rounded-full bg-emerald-100 border-2 border-white shadow-sm flex items-center justify-center text-emerald-700 font-bold text-lg">
                        {{ substr($pegawai->nama_lengkap ?? 'P', 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 bg-slate-50">
                <div class="max-w-7xl mx-auto">
                    {{-- Pesan Sukses/Error Global --}}
                    @if (session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
                            <i class="fas fa-check-circle text-xl"></i>
                            <div>
                                <span class="font-bold block">Berhasil!</span>
                                <span class="text-sm">{{ session('success') }}</span>
                            </div>
                            <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-700"><i class="fas fa-times"></i></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

        </div>
    </div>

    @yield('scripts')
</body>
</html>