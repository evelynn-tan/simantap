<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMANTAP - Pegawai')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .sidebar-logo {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        .active-menu {
            background-color: #065f46;
            border-left-color: #f59e0b;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-green-800 text-white shadow-lg">
            <!-- Header dengan Logo BPS -->
            <div class="sidebar-logo p-4 border-b border-green-700">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" class="w-10 h-10">
                    <div>
                        <h1 class="text-xl font-bold">SIMANTAP</h1>
                        <p class="text-xs text-green-200">Sistem Informasi Manajemen Aset Negara</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-6">
                @php
                    $currentRoute = request()->route()->getName();
                @endphp
                
                <a href="{{ route('pegawai.dashboard') }}" 
                   class="block py-3 px-4 transition-all duration-200 {{ str_contains($currentRoute, 'dashboard') ? 'active-menu' : 'hover:bg-green-700 border-l-4 border-transparent hover:border-yellow-400' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                
                <a href="{{ route('pegawai.daftar-barang') }}" 
                   class="block py-3 px-4 transition-all duration-200 {{ str_contains($currentRoute, 'daftar-barang') ? 'active-menu' : 'hover:bg-green-700 border-l-4 border-transparent hover:border-yellow-400' }}">
                    <i class="fas fa-list mr-3"></i>Daftar Barang Tersedia
                </a>
                
                <a href="{{ route('pegawai.monitor-permintaan') }}" 
                   class="block py-3 px-4 transition-all duration-200 {{ str_contains($currentRoute, 'monitor-permintaan') ? 'active-menu' : 'hover:bg-green-700 border-l-4 border-transparent hover:border-yellow-400' }}">
                    <i class="fas fa-eye mr-3"></i>Monitor Status Permintaan
                </a>
                
                <a href="{{ route('pegawai.edit-profil') }}" 
                   class="block py-3 px-4 transition-all duration-200 {{ str_contains($currentRoute, 'edit-profil') ? 'active-menu' : 'hover:bg-green-700 border-l-4 border-transparent hover:border-yellow-400' }}">
                    <i class="fas fa-user-edit mr-3"></i>Edit Profil
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex justify-between items-center px-6 py-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard Pegawai')</h2>
                        <p class="text-sm text-gray-600">@yield('page-subtitle', 'Sistem Informasi Manajemen Aset Negara (SIMANTAP)')</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="font-medium text-gray-800">{{ $pegawai->nama_lengkap ?? 'Pegawai' }}</p>
                            <p class="text-sm text-gray-600">Pegawai BPS</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6 overflow-auto bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>