<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operator - SIMANTAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white">
            <div class="p-4">
                <h1 class="text-2xl font-bold">SIMANTAP</h1>
                <p class="text-sm text-blue-200">Sistem Informasi Manajemen Aset Negara</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block py-3 px-4 bg-blue-700 border-l-4 border-yellow-400">
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
                <a href="{{ route('admin.stock-opname') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-clipboard-check mr-3"></i>Stock Opname
                </a>
                <a href="{{ route('admin.pengguna.index') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-users mr-3"></i>Manajemen Pengguna
                </a>
                <a href="{{ route('admin.laporan') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-chart-bar mr-3"></i>Laporan
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="flex justify-between items-center px-6 py-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Dashboard Operator BMN</h2>
                        <p class="text-sm text-gray-600">Sistem Informasi Manajemen Aset Negara (SIMANTAP)</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">Operator BMN</span>
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
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Total Jenis Aset -->
                    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <i class="fas fa-boxes text-blue-600 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $jumlahJenisAset }}</h3>
                                <p class="text-gray-600">Jumlah Jenis Aset</p>
                                <p class="text-sm text-gray-500">Total stok: {{ $totalStok }} unit</p>
                            </div>
                        </div>
                    </div>

                    <!-- Permintaan Baru -->
                    <div class="bg-white p-6 rounded-lg shadow border border-yellow-200">
                        <div class="flex items-center">
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $permintaanBaru }}</h3>
                                <p class="text-gray-600">Permintaan Baru</p>
                                <p class="text-sm text-yellow-500">Perlu Ditindaklanjuti</p>
                            </div>
                        </div>
                    </div>

                    <!-- Perlu Restock -->
                    <div class="bg-white p-6 rounded-lg shadow border border-red-200">
                        <div class="flex items-center">
                            <div class="p-3 bg-red-100 rounded-lg">
                                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $barangStokRendah }}</h3>
                                <p class="text-gray-600">Perlu Restock</p>
                                <p class="text-sm text-red-500">Stok kurang dari 5</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Permintaan -->
                    <div class="bg-white p-6 rounded-lg shadow border border-green-200">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-lg">
                                <i class="fas fa-chart-line text-green-600 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $totalPermintaan }}</h3>
                                <p class="text-gray-600">Total Permintaan</p>
                                <p class="text-sm text-green-500">Disetujui: {{ $permintaanDisetujui }} | Ditolak: {{ $permintaanDitolak }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Two Columns Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Permintaan Terbaru -->
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Permintaan Terbaru</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-2 text-left">Tanggal</th>
                                        <th class="px-4 py-2 text-left">Pegawai</th>
                                        <th class="px-4 py-2 text-left">Barang</th>
                                        <th class="px-4 py-2 text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($permintaanTerbaru as $permintaan)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $permintaan->created_at->format('d M') }}</td>
                                        <td class="px-4 py-2">{{ $permintaan->pegawai->nama_lengkap }}</td>
                                        <td class="px-4 py-2">
                                            @foreach($permintaan->pengajuanDetails as $detail)
                                                {{ $detail->barang->nama_barang }}<br>
                                            @endforeach
                                        </td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('admin.manajemen-permintaan') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                Proses
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">Tidak ada permintaan baru</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Barang Teratas -->
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Barang Paling Sering Diminta</h3>
                        <div class="space-y-3">
                            @forelse($barangTeratas as $barang)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                <span class="font-medium">{{ $barang->nama_barang }}</span>
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">
                                    {{ $barang->total_permintaan }} permintaan
                                </span>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center">Belum ada data permintaan</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>