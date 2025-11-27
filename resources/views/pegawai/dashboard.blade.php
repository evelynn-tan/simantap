@extends('layouts.pegawai-layout')

@section('title', 'Dashboard Pegawai - SIMANTAP')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>
@endpush

@section('content')

{{-- ===================== WELCOME BANNER ===================== --}}
<div class="mb-8">
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
        {{-- Hiasan Background --}}
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 right-20 -mb-4 w-24 h-24 bg-yellow-400 opacity-20 rounded-full blur-xl"></div>
        
        <div class="relative z-10">
            <h1 class="text-2xl md:text-3xl font-bold mb-1">Selamat Datang, {{ $pegawai->nama_lengkap }}</h1>
            <p class="text-emerald-50 text-sm md:text-base opacity-90">Dashboard Pegawai BPS Kota Tanjungpinang</p>
        </div>
    </div>
</div>

{{-- ===================== KPI CARDS (MODERN STYLE) ===================== --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <!-- Card 1: Barang Diterima -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 group">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Barang Diterima</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $barangDigunakan }}</h3>
                <div class="mt-2 flex items-center text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg w-fit">
                    <i class="fas fa-check mr-1"></i> Item Aktif
                </div>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                <i class="fas fa-box-open text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Permintaan -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 group">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total Permintaan</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalPermintaan }}</h3>
                <div class="mt-2 flex items-center text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-lg w-fit">
                    <i class="fas fa-history mr-1"></i> Riwayat Pengajuan
                </div>
            </div>
            <div class="p-3 bg-purple-50 text-purple-600 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                <i class="fas fa-file-signature text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card 3: Menunggu Persetujuan -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 group">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Menunggu</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $menungguPersetujuan }}</h3>
                <div class="mt-2 flex items-center text-xs font-medium text-yellow-600 bg-yellow-50 px-2 py-1 rounded-lg w-fit">
                    <i class="fas fa-clock mr-1"></i> Sedang Diproses
                </div>
            </div>
            <div class="p-3 bg-orange-50 text-orange-600 rounded-xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                <i class="fas fa-hourglass-half text-2xl"></i>
            </div>
        </div>
    </div>
</div>

{{-- ===================== CHARTS SECTION (BENTO GRID) ===================== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    {{-- LINE CHART (Main Chart - Span 2 Cols) --}}
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-slate-800">Tren Permintaan</h3>
            <span class="text-xs text-slate-400 bg-slate-50 px-2 py-1 rounded border">Tahun Ini</span>
        </div>
        <div class="relative h-[300px] w-full">
            <canvas id="chartBulanan"></canvas>
        </div>
    </div>

    {{-- DOUGHNUT CHART (Side Chart) --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col">
        <h3 class="text-lg font-bold text-slate-800 mb-2">Status Pengajuan</h3>
        <p class="text-sm text-slate-400 mb-6">Rasio persetujuan permintaan</p>
        
        <div class="flex-1 flex items-center justify-center relative">
            <div class="w-full h-[220px] flex items-center justify-center">
                <canvas id="chartStatus"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
    {{-- BAR CHART --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col h-full">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Top 5 Barang Favorit</h3>
        <div class="relative flex-1 min-h-[400px]">
            <canvas id="chartTopBarang"></canvas>
        </div>
    </div>

    {{-- TABEL BARANG DIGUNAKAN (Span 2 Cols) --}}
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-800">Barang Saya</h3>
            {{-- Tombol Lihat Semua DIHAPUS --}}
        </div>
        
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs text-slate-400 uppercase border-b border-slate-100">
                        <th class="py-3 font-semibold">Nama Barang</th>
                        <th class="py-3 font-semibold">Jumlah</th>
                        <th class="py-3 font-semibold">Tgl Terima</th>
                        <th class="py-3 font-semibold">Keperluan</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($barangSedangDigunakan as $pengajuan)
                        @foreach($pengajuan->pengajuanDetails as $detail)
                            <tr class="group hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0">
                                <td class="py-3 font-medium text-slate-700">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">
                                            <i class="fas fa-box"></i>
                                        </div>
                                        {{ $detail->barang->nama_barang }}
                                    </div>
                                </td>
                                <td class="py-3 text-slate-600 font-semibold">{{ $detail->jumlah }} <span class="text-xs font-normal text-slate-400">{{ $detail->barang->satuan }}</span></td>
                                <td class="py-3 text-slate-500">{{ $pengajuan->created_at->format('d M Y') }}</td>
                                <td class="py-3 text-slate-500 truncate max-w-[150px]">{{ $pengajuan->description }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-3xl mb-2 opacity-50"></i>
                                    <p>Tidak ada barang yang sedang digunakan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-50">
            {{ $barangSedangDigunakan->links() }}
        </div>
    </div>
</div>

{{-- ===================== RIWAYAT TABLE ===================== --}}
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-10">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 bg-slate-100 rounded-lg text-slate-600">
            <i class="fas fa-history"></i>
        </div>
        <div>
            <h3 class="text-lg font-bold text-slate-800">Riwayat Permintaan Terakhir</h3>
            <p class="text-sm text-slate-500">5 aktivitas pengajuan terakhir Anda</p>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-100">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Barang</th>
                    <th class="px-6 py-4">Jumlah</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Catatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($riwayatPermintaan as $riwayat)
                    @foreach($riwayat->pengajuanDetails as $detail)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-600 font-medium whitespace-nowrap">
                            {{ $riwayat->created_at->format('d M Y') }}
                            <span class="block text-xs text-slate-400 font-normal">{{ $riwayat->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-800 font-semibold">{{ $detail->barang->nama_barang }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $detail->jumlah }} {{ $detail->barang->satuan }}</td>
                        <td class="px-6 py-4">
                            @if($riwayat->status == 'menunggu')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Menunggu
                                </span>
                            @elseif($riwayat->status == 'disetujui')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disetujui
                                </span>
                            @elseif($riwayat->status == 'ditolak')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate">{{ $riwayat->description }}</td>
                    </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada riwayat permintaan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Konfigurasi Global Chart agar lebih bersih
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#64748b';
    Chart.defaults.scale.grid.display = false; // Hilangkan grid default

    // ===== LINE CHART (Curved & Gradient) =====
    const ctx1 = document.getElementById('chartBulanan').getContext('2d');
    
    // Buat Gradient
    let gradient = ctx1.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)'); // Emerald color
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: @json($bulanLabels),
            datasets: [{
                label: 'Permintaan',
                data: @json($bulanData),
                borderColor: '#10b981', // Emerald 500
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0.4, // Membuat garis melengkung (curved)
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#10b981',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { 
                        display: true, 
                        borderDash: [5, 5], // Grid putus-putus halus
                        color: '#f1f5f9' 
                    },
                    ticks: { stepSize: 1 }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // ===== DOUGHNUT CHART (Modern Pie) =====
    const ctx2 = document.getElementById('chartStatus').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut', // Ganti Pie jadi Doughnut
        data: {
            labels: ['Disetujui', 'Menunggu', 'Ditolak'],
            datasets: [{
                data: [
                    {{ $statusCounts['disetujui'] }},
                    {{ $statusCounts['menunggu'] }},
                    {{ $statusCounts['ditolak'] }}
                ],
                backgroundColor: [
                    '#10b981', // Emerald
                    '#f59e0b', // Amber
                    '#ef4444'  // Red
                ],
                borderWidth: 0, // Hilangkan border putih
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%', // Membuat lubang tengah lebih besar
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { size: 12 }
                    }
                }
            }
        }
    });

    // ===== BAR CHART (Rounded Bars) =====
    const ctx3 = document.getElementById('chartTopBarang').getContext('2d');
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: @json($topBarang->pluck('nama_barang')),
            datasets: [{
                label: 'Jumlah',
                data: @json($topBarang->pluck('total')),
                backgroundColor: '#3b82f6', // Blue 500
                borderRadius: 6, // Sudut batang membulat
                barThickness: 30, // Lebar batang fix
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { 
                        display: true, 
                        borderDash: [5, 5],
                        color: '#f1f5f9' 
                    },
                    ticks: { stepSize: 1 }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endsection