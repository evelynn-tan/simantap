<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Laporan - SIMANTAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .min-h-full-screen {
            min-height: 100vh;
        }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-full-screen">
        
        <div class="w-64 bg-blue-800 text-white min-h-full-screen">
            <div class="p-4 pt-6">
                <h1 class="text-2xl font-bold">SIMANTAP</h1>
                <p class="text-sm text-blue-200">Sistem Informasi Manajemen Aset Negara</p>
            </div>
            
            <nav class="mt-6">
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
                
                <a href="{{ route('admin.stock-opname') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-clipboard-check mr-3"></i>Stock Opname
                </a>
                
                <a href="{{ route('admin.manajemen-pengguna') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-users mr-3"></i>Manajemen Pengguna
                </a>
                
                <a href="{{ route('admin.laporan.index') }}" class="block py-3 px-4 bg-blue-700 border-l-4 border-yellow-400">
                    <i class="fas fa-chart-bar mr-3"></i>Laporan
                </a>
            </nav>
        </div>

        <div class="flex-1 bg-gray-50 p-8">
            
            <header class="mb-8">
                <div class="flex items-center text-gray-900">
                    <i class="fas fa-chart-bar text-2xl mr-3 text-blue-600"></i>
                    <h1 class="text-2xl font-bold">Pusat Laporan</h1>
                </div>
                <p class="text-gray-500">Pusat untuk semua kebutuhan rekapitulasi dan ekspor data</p>
            </header>
            
            <div class="mb-6 flex gap-3" id="tab-buttons">
                
                <button id="laporan-umum-tab" data-target="#laporan-umum" 
                        class="tab-btn inline-flex items-center px-4 py-2 text-sm font-medium rounded-full bg-blue-600 text-white shadow-md transition duration-150">
                    <i class="fas fa-file-alt mr-2"></i> Laporan Umum
                </button>
                
                <button id="laporan-pegawai-tab" data-target="#laporan-pegawai" 
                        class="tab-btn inline-flex items-center px-4 py-2 text-sm font-medium rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition duration-150">
                    <i class="fas fa-user-friends mr-2"></i> Laporan Per Pegawai
                </button>
            </div>

            <div class="bg-white overflow-hidden shadow-xl rounded-xl p-8">
                
                <h4 class="text-md font-semibold text-gray-800 mb-4"><i class="fas fa-filter mr-2 text-gray-700"></i>Filter Laporan</h4>

                <div id="tab-content">

                    <div id="laporan-umum" class="tab-pane">
                        <form action="{{ route('admin.laporan.index') }}" method="GET">
                            <input type="hidden" name="jenis_laporan" value="umum">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                                
                                <div>
                                    <label for="jenis_laporan_umum" class="block mb-2 text-sm font-medium text-gray-900 sr-only">Jenis Laporan</label>
                                    <select id="jenis_laporan_umum" name="sub_jenis_laporan" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                        <option value="stok_keseluruhan">Laporan Stok Barang Keseluruhan</option>
                                        <option value="transaksi">Laporan Mutasi Transaksi</option>
                                        <option value="opname">Laporan Hasil Stock Opname</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="tanggal_mulai_umum" class="block mb-2 text-sm font-medium text-gray-900 sr-only">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai_umum" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Pilih tanggal">
                                </div>
                                
                                <div>
                                    <label for="tanggal_selesai_umum" class="block mb-2 text-sm font-medium text-gray-900 sr-only">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" id="tanggal_selesai_umum" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Pilih tanggal">
                                </div>
                                
                                <div>
                                    <label for="kategori_id" class="block mb-2 text-sm font-medium text-gray-900 sr-only">Kategori Barang</label>
                                    <select id="kategori_id" name="kategori_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                        <option value="">Semua Kategori</option>
                                        {{-- DIPERBAIKI: Menggunakan $kategoris (huruf kecil) --}}
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <button type="submit" class="text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 h-full">
                                    Generate Laporan
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="laporan-pegawai" class="tab-pane hidden">
                        <form action="{{ route('admin.laporan.index') }}" method="GET">
                            <input type="hidden" name="jenis_laporan" value="pegawai">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                
                                <div>
                                    <label for="pegawai_id" class="block mb-2 text-sm font-medium text-gray-900 sr-only">Pilih Pegawai *</label>
                                    <select id="pegawai_id" name="pegawai_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                        <option value="">-- Pilih Pegawai --</option>
                                        @foreach($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}">{{ $pegawai->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="tanggal_mulai_pegawai" class="block mb-2 text-sm font-medium text-gray-900 sr-only">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai_pegawai" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Pilih tanggal">
                                </div>
                                
                                <div>
                                    <label for="tanggal_selesai_pegawai" class="block mb-2 text-sm font-medium text-gray-900 sr-only">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" id="tanggal_selesai_pegawai" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Pilih tanggal">
                                </div>
                                
                                <button type="submit" class="text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 h-full">
                                    Generate Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Hasil Laporan</h3>
                    
                    @if (isset($hasilLaporan) && $hasilLaporan->isNotEmpty())
                        
                        <div class="flex justify-end mb-4 gap-2">
                            <button type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 shadow-sm"><i class="fas fa-file-excel mr-2"></i>Excel</button>
                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 shadow-sm"><i class="fas fa-print mr-2"></i>Cetak</button>
                        </div>
                        
                        <div class="relative overflow-x-auto shadow-md rounded-lg border border-gray-200">
                             <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Tanggal Disetujui</th>
                                        <th scope="col" class="px-6 py-3">Nama Pegawai</th>
                                        <th scope="col" class="px-6 py-3">Barang & Jumlah</th>
                                        <th scope="col" class="px-6 py-3">Keperluan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($hasilLaporan as $permintaan)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4">{{ $permintaan->processed_at->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4">{{ $permintaan->user->name }}</td>
                                            <td class="px-6 py-4">
                                                @foreach($permintaan->details as $detail)
                                                    <div>{{ $detail->barang->nama_barang }} ({{ $detail->jumlah_diminta }} unit)</div>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4">{{ $permintaan->keperluan }}</td>
                                        </tr>
                                    @empty
                                        <tr class="bg-white border-b">
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                                Tidak ada data ditemukan untuk filter ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center p-12 border-dashed border-2 border-gray-300 rounded-lg bg-gray-50">
                            <svg class="mx-auto h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.25A2.25 2.25 0 0017.25 9H11.25m0 0L14.25 6m-3 3l-3-3m-3 12h-2.25A2.25 2.25 0 014.5 17.25V5.25A2.25 2.25 0 016.75 3h10.5a2.25 2.25 0 012.25 2.25v7.5M10.75 16.5H21"/>
                            </svg> 
                            <h3 class="mt-4 text-md font-medium text-gray-900">Silakan pilih filter dan generate laporan untuk melihat hasil.</h3>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');

        function activateTab(activeTabId) {
            tabButtons.forEach(button => {
                const targetId = button.getAttribute('data-target');
                if (targetId === activeTabId) {
                    button.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                    button.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                } else {
                    button.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                    button.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                }
            });

            tabPanes.forEach(pane => {
                if ('#' + pane.id === activeTabId) {
                    pane.classList.remove('hidden');
                } else {
                    pane.classList.add('hidden');
                }
            });
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                activateTab(targetId);
            });
        });

        // Inisialisasi: Tentukan tab aktif berdasarkan query string jika ada
        const urlParams = new URLSearchParams(window.location.search);
        // Default ke '#laporan-umum' jika tidak ada query 'jenis_laporan'
        const activeType = urlParams.get('jenis_laporan') === 'pegawai' ? '#laporan-pegawai' : '#laporan-umum';
        activateTab(activeType);
    });
</script>
</body>
</html>