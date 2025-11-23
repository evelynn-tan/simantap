@extends('layouts.pegawai-layout')

@section('title', 'Dashboard Pegawai - SIMANTAP')
@section('page-title', 'Selamat Datang, ' . $pegawai->nama_lengkap)
@section('page-subtitle', 'Dashboard Pegawai BPS Kota Tanjungpinang')

@section('content')

{{-- ===================== KPI CARDS ===================== --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <!-- Barang Telah Diterima -->
    <div class="bg-white p-5 rounded-xl shadow-md border border-blue-100 hover:shadow-lg transition">
        <div class="flex items-center">
            <div class="p-3 bg-blue-50 rounded-xl shadow-inner">
                <i class="fas fa-check-circle text-blue-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-3xl font-bold text-gray-800">{{ $barangDigunakan }}</h3>
                <p class="text-gray-600">Barang Telah Diterima</p>
                <p class="text-sm text-blue-500 font-medium">Item yang Anda pakai</p>
            </div>
        </div>
    </div>

    <!-- Total Permintaan -->
    <div class="bg-white p-5 rounded-xl shadow-md border border-green-100 hover:shadow-lg transition">
        <div class="flex items-center">
            <div class="p-3 bg-green-50 rounded-xl shadow-inner">
                <i class="fas fa-clipboard-list text-green-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-3xl font-bold text-gray-800">{{ $totalPermintaan }}</h3>
                <p class="text-gray-600">Total Permintaan</p>
                <p class="text-sm text-green-500 font-medium">Semua permintaan diajukan</p>
            </div>
        </div>
    </div>

    <!-- Menunggu Persetujuan -->
    <div class="bg-white p-5 rounded-xl shadow-md border border-yellow-100 hover:shadow-lg transition">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-50 rounded-xl shadow-inner">
                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-3xl font-bold text-gray-800">{{ $menungguPersetujuan }}</h3>
                <p class="text-gray-600">Menunggu Persetujuan</p>
                <p class="text-sm text-yellow-500 font-medium">Permintaan dalam proses</p>
            </div>
        </div>
    </div>

</div>

{{-- ===================== CHART SECTION ===================== --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">

    {{-- LINE CHART --}}
    <div class="bg-white p-5 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition h-[350px] flex flex-col">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Permintaan per Bulan</h3>
        <div class="flex-1">
            <canvas id="chartBulanan"></canvas>
        </div>
    </div>

    {{-- PIE CHART --}}
    <div class="bg-white p-5 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition h-[350px] flex flex-col">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Permintaan Barang</h3>
        
        <div class="flex-1 flex items-center justify-center">
            <div class="w-full h-[240px] flex items-center justify-center">
                <canvas id="chartStatus"></canvas>
            </div>
        </div>
    </div>

    {{-- TOP 5 BARANG PALING DIMINTA --}}
    <div class="bg-white p-5 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition h-[350px] flex flex-col">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Top 5 Barang Paling Sering Diminta</h3>
        <div class="flex-1">
            <canvas id="chartTopBarang"></canvas>
        </div>
    </div>

</div>

{{-- ===================== TABEL BARANG DIGUNAKAN ===================== --}}
<div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 mb-8">
    <h3 class="text-lg font-semibold mb-2 text-gray-800">Barang yang Sedang Saya Gunakan</h3>
    <p class="text-gray-600 mb-4">Daftar barang yang telah disetujui dan sedang Anda gunakan</p>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 text-gray-700">
                    <th class="px-4 py-2 text-left">Nama Barang</th>
                    <th class="px-4 py-2 text-left">Jumlah</th>
                    <th class="px-4 py-2 text-left">Tanggal Mulai</th>
                    <th class="px-4 py-2 text-left">Keperluan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangSedangDigunakan as $pengajuan)
                    @foreach($pengajuan->pengajuanDetails as $detail)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $detail->barang->nama_barang }}</td>
                            <td class="px-4 py-2">{{ $detail->jumlah }} {{ $detail->barang->satuan }}</td>
                            <td class="px-4 py-2">{{ $pengajuan->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $pengajuan->description }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada barang yang digunakan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===================== RIWAYAT PERMINTAAN ===================== --}}
<div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 mb-10">
    <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center gap-2">
        <i class="fas fa-history text-blue-500"></i> Riwayat 5 Permintaan Terakhir
    </h3>
    <p class="text-gray-600 mb-4">Status permintaan barang Anda sebelumnya</p>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Nama Barang</th>
                    <th class="px-4 py-2 text-left">Jumlah</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Keperluan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatPermintaan as $riwayat)
                    @foreach($riwayat->pengajuanDetails as $detail)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $riwayat->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ $detail->barang->nama_barang }}</td>
                        <td class="px-4 py-2">{{ $detail->jumlah }} {{ $detail->barang->satuan }}</td>

                        <td class="px-4 py-2">
                            @if($riwayat->status == 'menunggu')
                                <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded-full">
                                    Menunggu
                                </span>
                            @elseif($riwayat->status == 'disetujui')
                                <span class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full">
                                    Disetujui
                                </span>
                            @elseif($riwayat->status == 'ditolak')
                                <span class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">
                                    Ditolak
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-2">{{ $riwayat->description }}</td>
                    </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada riwayat permintaan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===================== CHART.JS ===================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ===== LINE CHART =====
    const ctx1 = document.getElementById('chartBulanan').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: @json($bulanLabels),
            datasets: [{
                label: 'Jumlah Permintaan',
                data: @json($bulanData),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,0.15)',
                borderWidth: 3,
                tension: 0.35,
                pointRadius: 4,
                pointBackgroundColor: '#2563eb'
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { ticks: { stepSize: 1 } }
            }
        }
    });

    // ===== PIE CHART =====
    const ctx2 = document.getElementById('chartStatus').getContext('2d');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Disetujui', 'Menunggu', 'Ditolak'],
            datasets: [{
                data: [
                    {{ $statusCounts['disetujui'] }},
                    {{ $statusCounts['menunggu'] }},
                    {{ $statusCounts['ditolak'] }}
                ],
                backgroundColor: [
                    'rgba(34,197,94,0.8)',
                    'rgba(234,179,8,0.8)',
                    'rgba(239,68,68,0.8)'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 20,
                        padding: 12
                    }
                }
            }
        }
    });

    // ===== BAR CHART: TOP 5 BARANG =====
    const ctx3 = document.getElementById('chartTopBarang').getContext('2d');

    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: @json($topBarang->pluck('nama_barang')),
            datasets: [{
                label: 'Jumlah Diminta',
                data: @json($topBarang->pluck('total')),
                backgroundColor: 'rgba(59,130,246,0.7)',
                borderColor: '#3b82f6',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection
