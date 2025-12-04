<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - SIMANTAP')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; }
        html, body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50" style="font-family: 'Poppins', sans-serif;">
    <div class="flex h-screen overflow-hidden bg-slate-50">
        
        <!-- SIDEBAR -->
        @include('layouts.sidebar-admin') 

        <!-- KONTEN UTAMA (Sebelah Kanan Sidebar) -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden sm:ml-64">
            
            <!-- HEADER ATAS -->
            <header class="bg-white shadow-sm border-b border-slate-200 z-10 sticky top-0">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" class="h-12 w-auto">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800" style="font-family: 'Poppins', sans-serif;">
                                @yield('header', 'Dashboard Admin')
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">@yield('subtitle', 'Selamat datang di SIMANTAP')</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right hidden sm:block">
                            <div class="text-xl font-semibold text-slate-900">{{ Auth::user()->name ?? 'User' }}</div>
                            <div class="text-m text-slate-700">{{ Auth::user()->role ?? 'Role' }}</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- ISI KONTEN DINAMIS -->
            <main class="w-full flex-grow p-6">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800">
                        <p class="font-semibold mb-2">❌ Terjadi Kesalahan:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 animate-pulse">
                        <p class="font-semibold">✅ {{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800">
                        <p class="font-semibold">❌ {{ session('error') }}</p>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl text-yellow-800">
                        <p class="font-semibold">⚠️ {{ session('warning') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
            
        </div>
    </div>
</body>
</html>