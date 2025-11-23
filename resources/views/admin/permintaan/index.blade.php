<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Permintaan - SIMANTAP</title>
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
                <a href="{{ route('admin.dashboard') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                <a href="{{ route('admin.manajemen-permintaan') }}" class="block py-3 px-4 bg-blue-700 border-l-4 border-yellow-400">
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
                        <h2 class="text-xl font-semibold text-gray-800">Manajemen Permintaan</h2>
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
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Daftar Permintaan</h3>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Pegawai</th>
                                    <th scope="col" class="px-6 py-3">Barang & Jumlah</th>
                                    <th scope="col" class="px-6 py-3">Keperluan</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftarPermintaan as $permintaan)
                                    <tr class="bg-white border-b">
                                        <td class="px-6 py-4">{{ $permintaan->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4">{{ $permintaan->pegawai->nama_lengkap ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">
                                            @foreach($permintaan->pengajuanDetails as $detail)
                                                <div>{{ $detail->barang->nama_barang ?? 'N/A' }} ({{ $detail->jumlah }} unit)</div>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4">{{ $permintaan->description }}</td>
                                        <td class="px-6 py-4">
                                            @if ($permintaan->status == 'menunggu')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Menunggu</span>
                                            @elseif ($permintaan->status == 'disetujui')
                                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Disetujui</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($permintaan->status == 'menunggu')
                                                <div class="flex gap-2">
                                                    <form action="{{ route('admin.permintaan.setujui', $permintaan) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-sm px-3 py-1">Setujui</button>
                                                    </form>
                                                    <form action="{{ route('admin.permintaan.tolak', $permintaan) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-sm px-3 py-1">Tolak</button>
                                                    </form>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b">
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada permintaan barang.
                                        </td>
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