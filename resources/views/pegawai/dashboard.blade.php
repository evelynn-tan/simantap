@extends('pegawai.layout')

@section('title', 'Dashboard Pegawai - SIMANTAP')
@section('page-title')
    Selamat Datang, {{ $pegawai->nama_lengkap }}!
@endsection
@section('page-subtitle', 'Dashboard Pegawai BPS Kota Tanjungpinang')
@section('content')

<!DOCTYPE html>
<html lang="id">
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
@endsection