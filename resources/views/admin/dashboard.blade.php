@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Operator BMN')

@section('content')
    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Jenis Aset -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-blue-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-boxes text-blue-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-800">{{ $jumlahJenisAset ?? 0 }}</h3>
                    <p class="text-gray-600 text-sm font-medium">Jumlah Jenis Aset</p>
                    <p class="text-xs text-gray-500 mt-1">Total stok: {{ $totalStok ?? 0 }} unit</p>
                </div>
            </div>
        </div>

        <!-- Permintaan Baru -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-yellow-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-800">{{ $permintaanBaru ?? 0 }}</h3>
                    <p class="text-gray-600 text-sm font-medium">Permintaan Baru</p>
                    <p class="text-xs text-yellow-600 mt-1 font-semibold">Perlu Ditindaklanjuti</p>
                </div>
            </div>
        </div>

        <!-- Perlu Restock -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-red-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-800">{{ $barangStokRendah ?? 0 }}</h3>
                    <p class="text-gray-600 text-sm font-medium">Perlu Restock</p>
                    <p class="text-xs text-red-500 mt-1 font-semibold">Stok kurang dari 5</p>
                </div>
            </div>
        </div>

        <!-- Total Permintaan -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-green-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-chart-line text-green-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalPermintaan ?? 0 }}</h3>
                    <p class="text-gray-600 text-sm font-medium">Total Permintaan</p>
                    <p class="text-xs text-green-600 mt-1">
                        <span class="font-semibold">{{ $permintaanDisetujui ?? 0 }}</span> OK | 
                        <span class="font-semibold">{{ $permintaanDitolak ?? 0 }}</span> Tolak
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Permintaan Terbaru -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Permintaan Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">Pegawai</th>
                            <th class="px-4 py-3 text-left">Barang</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($permintaanTerbaru ?? [] as $permintaan)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $permintaan->created_at->format('d M') }}</td>
                            <td class="px-4 py-3 font-medium">{{ $permintaan->pegawai->nama_lengkap ?? $permintaan->user->name ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <ul class="list-disc list-inside text-xs text-gray-600">
                                @foreach($permintaan->details ?? $permintaan->pengajuanDetails as $detail)
                                    <li>{{ $detail->barang->nama_barang }}</li>
                                @endforeach
                                </ul>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <!-- PERBAIKAN DI SINI: Mengubah 'permintaan.index' menjadi 'admin.permintaan.index' -->
                                <a href="{{ route('admin.permintaan.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs transition font-medium">
                                    Proses
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500 italic">Tidak ada permintaan baru saat ini</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Barang Teratas -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Barang Paling Sering Diminta</h3>
            <div class="space-y-4">
                @forelse($barangTeratas ?? [] as $barang)
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 transition border border-gray-100">
                    <div>
                        <span class="font-bold text-gray-800 block">{{ $barang->nama_barang }}</span>
                        <span class="text-xs text-gray-500">Stok: {{ $barang->stok_sekarang }}</span>
                    </div>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold">
                        {{ $barang->total_permintaan }}x diminta
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Belum ada data permintaan</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection