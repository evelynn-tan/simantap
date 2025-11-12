<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai - SIMANTAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-green-800 text-white">
            <div class="p-4">
                <h1 class="text-2xl font-bold">SIMANTAP</h1>
                <p class="text-sm text-green-200">Sistem Informasi Manajemen Aset Negara</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('pegawai.dashboard') }}" class="block py-3 px-4 bg-green-700 border-l-4 border-yellow-400">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                <a href="{{ route('pegawai.daftar-barang') }}" class="block py-3 px-4 hover:bg-green-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-list mr-3"></i>Daftar Barang Tersedia
                </a>
                <a href="{{ route('pegawai.monitor-permintaan') }}" class="block py-3 px-4 hover:bg-green-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-eye mr-3"></i>Monitor Status Permintaan
                </a>
                <a href="{{ route('pegawai.edit-profil') }}" class="block py-3 px-4 hover:bg-green-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-user-edit mr-3"></i>Edit Profil
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="flex justify-between items-center px-6 py-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ $pegawai->nama_lengkap }}!</h1>
                        <p class="text-gray-600">Dashboard Pegawai BPS Kota Tanjungpinang</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">{{ $pegawai->nama_lengkap }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6 overflow-auto">
                <!-- KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Barang Telah Diterima -->
                    <div class="bg-white p-6 rounded-lg shadow border border-blue-200">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <i class="fas fa-check-circle text-blue-600 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $barangDigunakan }}</h3>
                                <p class="text-gray-600">Barang Telah Diterima</p>
                                <p class="text-sm text-blue-500">Item yang Anda pakai</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Permintaan -->
                    <div class="bg-white p-6 rounded-lg shadow border border-green-200">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-lg">
                                <i class="fas fa-clipboard-list text-green-600 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $totalPermintaan }}</h3>
                                <p class="text-gray-600">Total Permintaan</p>
                                <p class="text-sm text-green-500">Semua permintaan yang diajukan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Menunggu Persetujuan -->
                    <div class="bg-white p-6 rounded-lg shadow border border-yellow-200">
                        <div class="flex items-center">
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $menungguPersetujuan }}</h3>
                                <p class="text-gray-600">Menunggu Persetujuan</p>
                                <p class="text-sm text-yellow-500">Permintaan dalam proses</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Barang yang Sedang Digunakan -->
                <div class="bg-white p-6 rounded-lg shadow mb-6">
                    <h3 class="text-lg font-semibold mb-4">Barang yang Sedang Saya Gunakan</h3>
                    <p class="text-gray-600 mb-4">Daftar barang yang telah disetujui dan sedang Anda gunakan</p>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left">Nama Barang</th>
                                    <th class="px-4 py-2 text-left">Jumlah</th>
                                    <th class="px-4 py-2 text-left">Tanggal Mulai</th>
                                    <th class="px-4 py-2 text-left">Keperluan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangSedangDigunakan as $pengajuan)
                                    @foreach($pengajuan->pengajuanDetails as $detail)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $detail->barang->nama_barang }}</td>
                                        <td class="px-4 py-2">{{ $detail->jumlah }} {{ $detail->barang->satuan }}</td>
                                        <td class="px-4 py-2">{{ $pengajuan->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">{{ $pengajuan->description }}</td>
                                    </tr>
                                    @endforeach
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada barang yang digunakan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>