<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - SIMANTAP')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR -->
        <!-- Bagian ini memanggil file sidebar yang sudah kita perbaiki sebelumnya -->
        @include('layouts.sidebar-admin') 

        <!-- KONTEN UTAMA (Sebelah Kanan Sidebar) -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden sm:ml-64">
            
            <!-- HEADER ATAS -->
            <header class="bg-white shadow border-b z-10 sticky top-0">
                <div class="flex justify-between items-center px-6 py-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">
                            <!-- Judul Halaman dinamis -->
                            @yield('header', 'Dashboard Admin')
                        </h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right hidden sm:block">
                            <div class="text-xs text-gray-500">{{ Auth::user()->role_display }}</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium border border-red-200 hover:bg-red-50 rounded-lg px-3 py-1 transition">
                                <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- ISI KONTEN DINAMIS -->
            <!-- Di sinilah tabel laporan/barang akan muncul -->
            <main class="w-full flex-grow p-6">
                @yield('content')
            </main>
            
        </div>
    </div>
</body>
</html>