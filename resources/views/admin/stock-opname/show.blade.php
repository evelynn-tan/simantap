<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Stock Opname - SIMANTAP</title>
    {{-- Memuat Tailwind CSS dan Font Awesome --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Mengatasi masalah tinggi minimal h-full di flex container jika di luar x-app-layout */
        .min-h-full-screen {
            min-height: 100vh;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-full-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white min-h-full-screen">
            <div class="p-4 pt-6">
                <h1 class="text-2xl font-bold">SIMANTAP</h1>
                <p class="text-sm text-blue-200">Sistem Informasi Manajemen Aset Negara</p>
            </div>
            
            <nav class="mt-6">
                <!-- Tautan Navigasi -->
                <a href="{{ route('admin.dashboard') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                
                <a href="{{ route('admin.manajemen-permintaan') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-clipboard-list mr-3"></i>Manajemen Permintaan
                </a>
                
                <a href="{{ route('admin.data-barang') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-boxes mr-3"></i>Data Barang
                </a>
                
                <a href="{{ route('admin.tambah-barang') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-plus-circle mr-3"></i>Tambah Barang Baru
                </a>
                
                <!-- Stock Opname (Active Link) -->
                <a href="{{ route('admin.stock-opname') }}" class="block py-3 px-4 bg-blue-700 border-l-4 border-yellow-400">
                    <i class="fas fa-clipboard-check mr-3"></i>Stock Opname
                </a>
                
                <a href="{{ route('admin.manajemen-pengguna') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-users mr-3"></i>Manajemen Pengguna
                </a>
                
                <a href="{{ route('admin.laporan') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-chart-bar mr-3"></i>Laporan
                </a>
            </nav>
        </div>

        <!-- Kolom Konten Utama -->
        <div class="flex-1 bg-gray-100">
            
            <!-- Header Halaman -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Rincian Stock Opname
                    </h2>
                </div>
            </header>
            
            <!-- Body Konten Rincian -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 md:p-12">

                        <h3 class="text-2xl font-bold text-gray-900">Rincian Sesi Stock Opname</h3>
                        <p class="text-gray-600 mb-6">
                            Sesi Opname pada {{ $opname->tanggal_opname->format('d F Y \p\u\k\u\l H:i') }}
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <dt class="text-sm font-medium text-gray-500">Total Barang Diperiksa</dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-900">{{ $opname->details->count() }}</dd>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <dt class="text-sm font-medium text-gray-500">Total Item Selisih</dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-900">{{ $opname->details->where('selisih', '!=', 0)->count() }}</dd>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <dt class="text-sm font-medium text-gray-500">Operator</dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-900">{{ $opname->operator->name }}</dd>
                            </div>
                        </div>
                        
                        <h4 class="text-xl font-bold text-gray-900 mb-4">Daftar Barang</h4>
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">No</th>
                                        <th scope="col" class="py-3 px-6">Nama Barang</th>
                                        <th scope="col" class="py-3 px-6">Kategori</th>
                                        <th scope="col" class="py-3 px-6 text-center">Stok Sistem</th>
                                        <th scope="col" class="py-3 px-6 text-center">Stok Fisik</th>
                                        <th scope="col" class="py-3 px-6 text-center">Selisih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($opname->details as $detail)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $detail->barang->nama_barang }}
                                        </th>
                                        <td class="py-4 px-6">
                                            {{ $detail->barang->kategori->nama_kategori ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-6 text-center font-medium text-gray-700">{{ $detail->stok_sistem }}</td>
                                        <td class="py-4 px-6 text-center font-medium text-blue-600">{{ $detail->stok_fisik }}</td>
                                        
                                        <td class="py-4 px-6 text-center font-bold
                                            @if ($detail->selisih > 0)
                                                text-green-600
                                            @elseif ($detail->selisih < 0)
                                                text-red-600
                                            @else
                                                text-gray-700
                                            @endif
                                        ">
                                            {{ $detail->selisih }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.dashboard') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                Selesai
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>