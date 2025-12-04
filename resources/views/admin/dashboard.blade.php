@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Operator BMN')
@section('subtitle', 'Ringkasan status aset dan permintaan barang')

@section('content')
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">
    
    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Jenis Aset -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow-sm border border-blue-200 hover:shadow-lg transition duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-semibold uppercase tracking-wider">Jenis Aset</p>
                    <p class="text-4xl font-bold text-blue-900 mt-2">{{ $jumlahJenisAset ?? 0 }}</p>
                    <p class="text-xs text-blue-700 mt-2">Total stok: <span class="font-bold">{{ $totalStok ?? 0 }} unit</span></p>
                </div>
                <div class="h-14 w-14 bg-blue-200 rounded-xl flex items-center justify-center">
                    <i class="fas fa-boxes text-3xl text-blue-700"></i>
                </div>
            </div>
        </div>

        <!-- Permintaan Baru -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-xl shadow-sm border border-yellow-200 hover:shadow-lg transition duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-700 text-sm font-semibold uppercase tracking-wider">Menunggu Proses</p>
                    <p class="text-4xl font-bold text-yellow-900 mt-2">{{ $permintaanBaru ?? 0 }}</p>
                    <p class="text-xs text-yellow-800 mt-2 font-semibold">⚠️ Perlu tindakan</p>
                </div>
                <div class="h-14 w-14 bg-yellow-200 rounded-xl flex items-center justify-center">
                    <i class="fas fa-hourglass text-3xl text-yellow-700"></i>
                </div>
            </div>
        </div>

        <!-- Perlu Restock -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl shadow-sm border border-red-200 hover:shadow-lg transition duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-700 text-sm font-semibold uppercase tracking-wider">Stok Rendah</p>
                    <p class="text-4xl font-bold text-red-900 mt-2">{{ $barangStokRendah ?? 0 }}</p>
                    <p class="text-xs text-red-800 mt-2">Kurang dari 10 unit</p>
                </div>
                <div class="h-14 w-14 bg-red-200 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exclamation-circle text-3xl text-red-700"></i>
                </div>
            </div>
        </div>

        <!-- Total Permintaan -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl shadow-sm border border-green-200 hover:shadow-lg transition duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-700 text-sm font-semibold uppercase tracking-wider">Total Permintaan</p>
                    <p class="text-4xl font-bold text-green-900 mt-2">{{ $totalPermintaan ?? 0 }}</p>
                    <p class="text-xs text-green-800 mt-2">
                        <span class="font-bold">{{ $permintaanDisetujui ?? 0 }}</span> ✓ | 
                        <span class="font-bold">{{ $permintaanDitolak ?? 0 }}</span> ✗
                    </p>
                </div>
                <div class="h-14 w-14 bg-green-200 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-3xl text-green-700"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Permintaan Terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-800">📋 Permintaan Terbaru</h3>
                <p class="text-xs text-slate-500 mt-1">5 permintaan terbaru yang masuk</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 uppercase">Pegawai</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-slate-600 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($permintaanTerbaru ?? [] as $permintaan)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 text-slate-700 font-medium whitespace-nowrap">
                                {{ $permintaan->requested_at->timezone('Asia/Jakarta')->format('d M H:i') }}
                            </td>
                            <td class="px-4 py-3 text-slate-700">
                                {{ $permintaan->pegawai->nama_lengkap ?? $permintaan->user->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($permintaan->status == 'menunggu')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-hourglass mr-1"></i> Menunggu
                                    </span>
                                @elseif($permintaan->status == 'disetujui')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i> OK
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <i class="fas fa-times mr-1"></i> Tolak
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-slate-500 italic">
                                <i class="fas fa-inbox text-2xl opacity-50 mb-2 block"></i>
                                Tidak ada permintaan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-slate-200 text-right">
                <a href="{{ route('admin.permintaan.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Barang Paling Sering Diminta -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-800">⭐ Barang Paling Sering Diminta</h3>
                <p class="text-xs text-slate-500 mt-1">Top 5 barang yang paling sering diajukan</p>
            </div>
            <div class="p-4 space-y-3 max-h-96 overflow-y-auto">
                @forelse($barangTeratas ?? [] as $index => $barang)
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-slate-50 to-slate-100 rounded-lg border border-slate-200 hover:border-blue-300 hover:shadow-md transition duration-200">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center h-8 w-8 bg-blue-600 text-white text-sm font-bold rounded-full">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $barang->nama_barang ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">Stok: <span class="font-semibold">{{ $barang->stok ?? 0 }}</span> {{ $barang->satuan ?? 'unit' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-orange-100 text-orange-800 rounded-lg text-sm font-bold">
                            <i class="fas fa-fire text-orange-500"></i>
                            {{ $barang->total_permintaan ?? 0 }}x
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-slate-400">
                    <i class="fas fa-chart-bar text-3xl mb-2 opacity-50"></i>
                    <p class="text-sm">Belum ada data permintaan</p>
                </div>
                @endforelse
            </div>
            <div class="px-6 py-3 border-t border-slate-200 text-right">
                <a href="{{ route('admin.barang.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition">
                    Kelola Barang <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection