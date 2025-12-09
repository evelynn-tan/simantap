@extends('layouts.pegawai-layout')

@section('title', 'Dashboard Pegawai - SIMANTAP')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    
    @keyframes pulse-slow {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    .animate-pulse-slow { animation: pulse-slow 3s ease-in-out infinite; }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }
    
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fade-in-up 0.5s ease-out forwards; }
</style>
@endpush

@section('content')

{{-- ===================== WELCOME BANNER (Premium) ===================== --}}
<div class="mb-8">
    <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden">
        {{-- Animated Background Elements --}}
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-0 left-1/4 -mb-10 w-60 h-60 bg-yellow-400 opacity-10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-cyan-300 opacity-20 rounded-full blur-2xl"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-16 w-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/20">
                        <span class="text-2xl font-bold">{{ strtoupper(substr($pegawai->nama_lengkap, 0, 1)) }}{{ strtoupper(substr(explode(' ', $pegawai->nama_lengkap)[1] ?? '', 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="text-emerald-200 text-sm font-medium">Selamat Datang Kembali 👋</p>
                        <h1 class="text-2xl md:text-3xl font-extrabold">{{ $pegawai->nama_lengkap }}</h1>
                    </div>
                </div>
                <p class="text-emerald-100 text-sm md:text-base flex items-center gap-2">
                    <i class="fas fa-building"></i>
                    {{ $pegawai->jabatan }} • {{ $pegawai->divisi }}
                </p>
            </div>
            
            {{-- Live Date & Time --}}
            <div class="mt-4 md:mt-0 flex flex-col items-start md:items-end gap-2">
                <div class="bg-white/15 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20">
                    <p class="text-xs text-emerald-200">📅 {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
                <div class="bg-white/15 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20">
                    <p class="text-lg font-bold font-mono">🕐 <span id="live-clock">--:--:--</span> WIB</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================== KPI CARDS (Modern Style) ===================== --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    {{-- Card 1: Barang Diterima --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-emerald-200 transition-all duration-300 group animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Barang Diterima</p>
                <h3 class="text-4xl font-extrabold text-slate-800 mt-2 group-hover:text-emerald-600 transition">{{ $barangDigunakan }}</h3>
                <div class="mt-3 flex items-center text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg w-fit">
                    <i class="fas fa-check-circle mr-1.5"></i> Item Aktif
                </div>
            </div>
            <div class="p-4 bg-gradient-to-br from-emerald-100 to-teal-100 text-emerald-600 rounded-2xl group-hover:from-emerald-500 group-hover:to-teal-500 group-hover:text-white transition-all duration-300 transform group-hover:scale-110">
                <i class="fas fa-box-open text-2xl"></i>
            </div>
        </div>
    </div>

    {{-- Card 2: Total Permintaan --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-blue-200 transition-all duration-300 group animate-fade-in-up" style="animation-delay: 0.2s">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Permintaan</p>
                <h3 class="text-4xl font-extrabold text-slate-800 mt-2 group-hover:text-blue-600 transition">{{ $totalPermintaan }}</h3>
                <div class="mt-3 flex items-center text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg w-fit">
                    <i class="fas fa-history mr-1.5"></i> Riwayat
                </div>
            </div>
            <div class="p-4 bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600 rounded-2xl group-hover:from-blue-500 group-hover:to-indigo-500 group-hover:text-white transition-all duration-300 transform group-hover:scale-110">
                <i class="fas fa-file-signature text-2xl"></i>
            </div>
        </div>
    </div>

    {{-- Card 3: Menunggu --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-amber-200 transition-all duration-300 group animate-fade-in-up {{ $menungguPersetujuan > 0 ? 'animate-pulse-slow' : '' }}" style="animation-delay: 0.3s">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Menunggu</p>
                <h3 class="text-4xl font-extrabold text-slate-800 mt-2 group-hover:text-amber-600 transition">{{ $menungguPersetujuan }}</h3>
                <div class="mt-3 flex items-center text-xs font-semibold text-amber-600 bg-amber-50 px-3 py-1.5 rounded-lg w-fit">
                    <i class="fas fa-clock mr-1.5"></i> Diproses
                </div>
            </div>
            <div class="p-4 bg-gradient-to-br from-amber-100 to-orange-100 text-amber-600 rounded-2xl group-hover:from-amber-500 group-hover:to-orange-500 group-hover:text-white transition-all duration-300 transform group-hover:scale-110">
                <i class="fas fa-hourglass-half text-2xl"></i>
            </div>
        </div>
    </div>

    {{-- Card 4: Approval Rate --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-purple-200 transition-all duration-300 group animate-fade-in-up" style="animation-delay: 0.4s">
        @php
            $approvalRate = $totalPermintaan > 0 ? round(($statusCounts['disetujui'] / $totalPermintaan) * 100) : 0;
        @endphp
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Approval Rate</p>
                <h3 class="text-4xl font-extrabold text-slate-800 mt-2 group-hover:text-purple-600 transition">{{ $approvalRate }}%</h3>
                <div class="mt-3 flex items-center text-xs font-semibold text-purple-600 bg-purple-50 px-3 py-1.5 rounded-lg w-fit">
                    <i class="fas fa-chart-line mr-1.5"></i> Tingkat Setuju
                </div>
            </div>
            <div class="p-4 bg-gradient-to-br from-purple-100 to-pink-100 text-purple-600 rounded-2xl group-hover:from-purple-500 group-hover:to-pink-500 group-hover:text-white transition-all duration-300 transform group-hover:scale-110">
                <i class="fas fa-percentage text-2xl"></i>
            </div>
        </div>
    </div>
</div>

{{-- ===================== CHARTS SECTION ===================== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    {{-- LINE CHART (Main Chart - Span 2 Cols) --}}
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-emerald-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Tren Permintaan</h3>
                    <p class="text-xs text-slate-400">Statistik bulanan tahun {{ date('Y') }}</p>
                </div>
            </div>
            <span class="text-xs text-slate-400 bg-slate-50 px-3 py-1.5 rounded-lg border">📊 Real-time</span>
        </div>
        <div class="relative h-[280px] w-full">
            <canvas id="chartBulanan"></canvas>
        </div>
    </div>

    {{-- DOUGHNUT CHART (Side Chart) --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col">
        <div class="flex items-center gap-3 mb-4">
            <div class="h-10 w-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-pie text-blue-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Status Pengajuan</h3>
                <p class="text-xs text-slate-400">Rasio persetujuan</p>
            </div>
        </div>
        
        <div class="flex-1 flex items-center justify-center relative">
            <div class="w-full h-[200px] flex items-center justify-center">
                <canvas id="chartStatus"></canvas>
            </div>
        </div>
        
        {{-- Legend --}}
        <div class="mt-4 grid grid-cols-3 gap-2 text-center text-xs">
            <div class="p-2 bg-emerald-50 rounded-lg">
                <span class="block text-lg font-bold text-emerald-600">{{ $statusCounts['disetujui'] }}</span>
                <span class="text-slate-500">Disetujui</span>
            </div>
            <div class="p-2 bg-amber-50 rounded-lg">
                <span class="block text-lg font-bold text-amber-600">{{ $statusCounts['menunggu'] }}</span>
                <span class="text-slate-500">Menunggu</span>
            </div>
            <div class="p-2 bg-red-50 rounded-lg">
                <span class="block text-lg font-bold text-red-600">{{ $statusCounts['ditolak'] }}</span>
                <span class="text-slate-500">Ditolak</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- BAR CHART --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col">
        <div class="flex items-center gap-3 mb-4">
            <div class="h-10 w-10 bg-gradient-to-br from-purple-100 to-pink-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-trophy text-purple-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Top 5 Favorit</h3>
                <p class="text-xs text-slate-400">Barang paling sering diminta</p>
            </div>
        </div>
        <div class="relative flex-1 min-h-[280px]">
            <canvas id="chartTopBarang"></canvas>
        </div>
    </div>

    {{-- TABEL BARANG DIGUNAKAN (Span 2 Cols) --}}
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-gradient-to-br from-teal-100 to-cyan-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-box text-teal-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Barang Saya</h3>
                    <p class="text-xs text-slate-400">Barang yang sedang digunakan</p>
                </div>
            </div>
            <span class="text-xs bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-lg font-semibold">
                {{ $barangSedangDigunakan->total() }} item
            </span>
        </div>
        
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs text-slate-400 uppercase border-b border-slate-100">
                        <th class="py-3 font-bold">Nama Barang</th>
                        <th class="py-3 font-bold">Jumlah</th>
                        <th class="py-3 font-bold">Tgl Terima</th>
                        <th class="py-3 font-bold">Keperluan</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($barangSedangDigunakan as $pengajuan)
                        @foreach($pengajuan->pengajuanDetails as $detail)
                            <tr class="group hover:bg-emerald-50 transition-colors border-b border-slate-50 last:border-0">
                                <td class="py-3 font-medium text-slate-700">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 text-emerald-600 flex items-center justify-center text-xs">
                                            <i class="fas fa-box"></i>
                                        </div>
                                        <span class="group-hover:text-emerald-700 transition">{{ $detail->barang->namaBarang }}</span>
                                    </div>
                                </td>
                                <td class="py-3 text-slate-600">
                                    <span class="font-bold">{{ $detail->jumlah }}</span> 
                                    <span class="text-xs text-slate-400">{{ $detail->barang->satuan }}</span>
                                </td>
                                <td class="py-3 text-slate-500">{{ $pengajuan->created_at->format('d M Y') }}</td>
                                <td class="py-3 text-slate-500 truncate max-w-[150px]">{{ $pengajuan->description }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center">
                                    <div class="h-14 w-14 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                                        <i class="fas fa-inbox text-2xl text-slate-300"></i>
                                    </div>
                                    <p class="font-semibold text-slate-600">Belum ada barang</p>
                                    <p class="text-xs mt-1">Ajukan permintaan barang melalui menu Daftar Barang</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($barangSedangDigunakan->hasPages())
        <div class="mt-4 pt-4 border-t border-slate-100">
            {{ $barangSedangDigunakan->links() }}
        </div>
        @endif
    </div>
</div>

{{-- ===================== RIWAYAT TABLE ===================== --}}
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 bg-gradient-to-br from-slate-100 to-gray-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-history text-slate-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Riwayat Permintaan</h3>
                <p class="text-xs text-slate-400">5 aktivitas pengajuan terakhir</p>
            </div>
        </div>
        <a href="{{ route('pegawai.monitor-permintaan') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition flex items-center gap-1">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-100">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold">
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
                        <td class="px-6 py-4 text-sm text-slate-800 font-semibold">{{ $detail->barang->namaBarang }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $detail->jumlah }} {{ $detail->barang->satuan }}</td>
                        <td class="px-6 py-4">
                            @if($riwayat->status == 'menunggu')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700 border border-yellow-200">
                                    <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span> Menunggu
                                </span>
                            @elseif($riwayat->status == 'disetujui')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Disetujui
                                </span>
                            @elseif($riwayat->status == 'ditolak')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate">{{ $riwayat->description }}</td>
                    </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-file-alt text-3xl mb-2 opacity-50"></i>
                            <p>Belum ada riwayat permintaan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===================== QUICK ACTIONS ===================== --}}
<div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl shadow-lg p-6 text-white">
    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
        <i class="fas fa-bolt text-yellow-400"></i> Aksi Cepat
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('pegawai.daftar-barang') }}" class="flex items-center gap-3 p-4 bg-white/10 hover:bg-white/20 rounded-xl transition group">
            <div class="h-10 w-10 bg-emerald-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                <i class="fas fa-boxes text-white"></i>
            </div>
            <div>
                <p class="font-semibold text-sm">Lihat Barang</p>
                <p class="text-xs text-slate-400">Cari & ajukan</p>
            </div>
        </a>
        <a href="{{ route('pegawai.monitor-permintaan') }}" class="flex items-center gap-3 p-4 bg-white/10 hover:bg-white/20 rounded-xl transition group">
            <div class="h-10 w-10 bg-blue-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                <i class="fas fa-clipboard-list text-white"></i>
            </div>
            <div>
                <p class="font-semibold text-sm">Monitor</p>
                <p class="text-xs text-slate-400">Status permintaan</p>
            </div>
        </a>
        <a href="{{ route('pegawai.edit-profil') }}" class="flex items-center gap-3 p-4 bg-white/10 hover:bg-white/20 rounded-xl transition group">
            <div class="h-10 w-10 bg-purple-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                <i class="fas fa-user-edit text-white"></i>
            </div>
            <div>
                <p class="font-semibold text-sm">Edit Profil</p>
                <p class="text-xs text-slate-400">Kelola akun</p>
            </div>
        </a>
        <a href="{{ route('pegawai.dashboard') }}" class="flex items-center gap-3 p-4 bg-white/10 hover:bg-white/20 rounded-xl transition group">
            <div class="h-10 w-10 bg-teal-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                <i class="fas fa-sync-alt text-white"></i>
            </div>
            <div>
                <p class="font-semibold text-sm">Refresh</p>
                <p class="text-xs text-slate-400">Update data</p>
            </div>
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Live Clock
    function updateClock() {
        const now = new Date();
        const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };
        document.getElementById('live-clock').textContent = now.toLocaleTimeString('id-ID', options);
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Konfigurasi Global Chart
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#64748b';
    Chart.defaults.scale.grid.display = false;

    // ===== LINE CHART (Curved & Gradient) =====
    const ctx1 = document.getElementById('chartBulanan').getContext('2d');
    
    // Buat Gradient
    let gradient = ctx1.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: @json($bulanLabels),
            datasets: [{
                label: 'Permintaan',
                data: @json($bulanData),
                borderColor: '#10b981',
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#10b981',
                pointBorderWidth: 3,
                pointHoverBackgroundColor: '#10b981',
                pointHoverBorderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { weight: 'bold' },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { 
                        display: true, 
                        borderDash: [5, 5],
                        color: '#f1f5f9' 
                    },
                    ticks: { stepSize: 1, font: { weight: '600' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { weight: '600' } }
                }
            }
        }
    });

    // ===== DOUGHNUT CHART (Modern Pie) =====
    const ctx2 = document.getElementById('chartStatus').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Disetujui', 'Menunggu', 'Ditolak'],
            datasets: [{
                data: [
                    {{ $statusCounts['disetujui'] }},
                    {{ $statusCounts['menunggu'] }},
                    {{ $statusCounts['ditolak'] }}
                ],
                backgroundColor: [
                    '#10b981',
                    '#f59e0b',
                    '#ef4444'
                ],
                borderWidth: 0,
                hoverOffset: 8,
                hoverBorderWidth: 3,
                hoverBorderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    padding: 12,
                    cornerRadius: 8
                }
            }
        }
    });

    // ===== BAR CHART (Rounded Bars) =====
    const ctx3 = document.getElementById('chartTopBarang').getContext('2d');
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: @json($topBarang->pluck('namaBarang')),
            datasets: [{
                label: 'Jumlah',
                data: @json($topBarang->pluck('total')),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(236, 72, 153, 0.8)'
                ],
                borderRadius: 8,
                barThickness: 24,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { 
                        display: true, 
                        borderDash: [5, 5],
                        color: '#f1f5f9' 
                    },
                    ticks: { stepSize: 1, font: { weight: '600' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { 
                        font: { size: 10, weight: '600' },
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
</script>
@endsection