<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Sesi Stock Opname - SIMANTAP</title>
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
                        Mulai Sesi Stock Opname
                    </h2>
                </div>
            </header>
            
            <!-- Body Konten Formulir -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 md:p-12">
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Formulir Stock Opname</h3>
                        <p class="text-gray-600 mb-6">Masukkan jumlah stok fisik yang Anda hitung di lapangan untuk setiap barang. Stok sistem ditampilkan sebagai referensi.</p>

                        {{-- Perlu mengganti x-validation-errors dengan implementasi pesan error manual jika di-code mandiri --}}
                        {{-- <div class="mb-4 text-red-600">Error validation here...</div> --}}

                        <form action="{{ route('admin.stock-opname.store') }}" method="POST">
                            @csrf
                            
                            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3 px-6">Nama Barang</th>
                                            <th scope="col" class="py-3 px-6">Kategori</th>
                                            <th scope="col" class="py-3 px-6 text-center">Stok Sistem</th>
                                            <th scope="col" class="py-3 px-6 text-center" style="width: 200px;">Stok Fisik (Hasil Hitung)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($barangs as $barang)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $barang->nama_barang }}
                                            </th>
                                            <td class="py-4 px-6">
                                                {{ $barang->kategori->nama_kategori ?? 'N/A' }}
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <span class="text-lg font-semibold text-gray-700">{{ $barang->stok }}</span>
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <input type="number" 
                                                    name="stok_fisik[{{ $barang->id }}]" 
                                                    id="stok_fisik_{{ $barang->id }}" 
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 text-center" 
                                                    value="{{ old('stok_fisik.' . $barang->id, $barang->stok) }}" 
                                                    required 
                                                    min="0">
                                            </td>
                                        </tr>
                                        @empty
                                        <tr class="bg-white border-b">
                                            <td colspan="4" class="py-4 px-6 text-center text-gray-500">
                                                Tidak ada data barang. Silakan tambahkan data barang terlebih dahulu.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <a href="{{ route('admin.stock-opname.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                                    Batal
                                </a>
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2">
                                    Simpan Hasil Opname
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>