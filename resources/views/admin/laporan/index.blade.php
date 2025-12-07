@extends('layouts.admin')
@section('title', 'Laporan - SIMANTAP')
@section('header', 'Pusat Laporan')
@section('subtitle', 'Kelola dan ekspor laporan pengajuan barang')

@section('content')
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-slate-200">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-filter"></i> Filter Laporan
            </h3>
            <p class="text-blue-100 text-sm mt-1">Pilih jenis laporan dan filter yang diinginkan</p>
        </div>
        
        <div class="p-4 sm:p-5 lg:p-6">
            <!-- Tabs -->
            <div class="flex gap-1 mb-4 sm:mb-6 bg-slate-100 p-1 rounded-lg w-full sm:w-fit overflow-x-auto">
                <button 
                    onclick="switchTab('umum')"
                    id="tab-umum"
                    class="flex-1 sm:flex-none px-3 sm:px-5 py-2 sm:py-2.5 font-semibold text-xs sm:text-sm transition rounded-md bg-white text-blue-600 shadow-sm whitespace-nowrap">
                    <i class="fas fa-chart-bar mr-1 sm:mr-2"></i> <span class="hidden xs:inline">Laporan</span> Umum
                </button>
                <button 
                    onclick="switchTab('pegawai')"
                    id="tab-pegawai"
                    class="flex-1 sm:flex-none px-3 sm:px-5 py-2 sm:py-2.5 font-semibold text-xs sm:text-sm transition rounded-md text-slate-600 hover:bg-white/50 whitespace-nowrap">
                    <i class="fas fa-user mr-1 sm:mr-2"></i> Per Pegawai
                </button>
            </div>

            <!-- Form Laporan Umum -->
            <form id="form-umum" action="{{ route('admin.laporan.index') }}" method="GET" class="block">
                <input type="hidden" name="jenis_laporan" value="umum">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 items-end">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            <i class="fas fa-calendar text-blue-500 mr-1"></i> Tanggal Mulai
                        </label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', request('tanggal_mulai')) }}" 
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            <i class="fas fa-calendar-check text-blue-500 mr-1"></i> Tanggal Selesai
                        </label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', request('tanggal_selesai')) }}" 
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            <i class="fas fa-tags text-blue-500 mr-1"></i> Kategori Barang
                        </label>
                        <select name="kategori_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->categoryID }}" {{ (string)old('kategori_id', request('kategori_id')) === (string)$kategori->categoryID ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                        <i class="fas fa-search"></i> Generate Laporan
                    </button>
                </div>
            </form>

            <!-- Form Laporan Per Pegawai -->
            <form id="form-pegawai" action="{{ route('admin.laporan.index') }}" method="GET" class="hidden">
                <input type="hidden" name="jenis_laporan" value="pegawai">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 items-end">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            <i class="fas fa-user text-blue-500 mr-1"></i> Pegawai <span class="text-red-500">*</span>
                        </label>
                        <select name="pegawai_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->pegawaiID }}" {{ (string)old('pegawai_id', request('pegawai_id')) === (string)$pegawai->pegawaiID ? 'selected' : '' }}>
                                    {{ $pegawai->nama_lengkap }} ({{ $pegawai->nip }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            <i class="fas fa-clock text-blue-500 mr-1"></i> Periode
                        </label>
                        <select name="periode" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white">
                            @php $selectedPeriode = old('periode', request('periode')); @endphp
                            <option value="" {{ $selectedPeriode == '' ? 'selected' : '' }}>Semua Waktu</option>
                            <option value="30" {{ $selectedPeriode == '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                            <option value="90" {{ $selectedPeriode == '90' ? 'selected' : '' }}>90 Hari Terakhir</option>
                            <option value="180" {{ $selectedPeriode == '180' ? 'selected' : '' }}>6 Bulan Terakhir</option>
                            <option value="365" {{ $selectedPeriode == '365' ? 'selected' : '' }}>1 Tahun Terakhir</option>
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                        <i class="fas fa-search"></i> Generate Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===================== HASIL LAPORAN UMUM ===================== -->
    @if ($jenisLaporan === 'umum')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-600 border-b border-slate-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fas fa-chart-bar"></i> Laporan Umum
                </h3>
                <p class="text-green-100 text-sm mt-1">
                    Periode: {{ request('tanggal_mulai') ? \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d M Y') : 'Awal' }} 
                    - {{ request('tanggal_selesai') ? \Carbon\Carbon::parse(request('tanggal_selesai'))->format('d M Y') : 'Sekarang' }}
                    | Total: <strong>{{ count($hasilLaporanUmum) }}</strong> pengajuan
                </p>
            </div>
            @if (count($hasilLaporanUmum) > 0)
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.export-excel', request()->all()) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-lg text-sm transition backdrop-blur-sm">
                    <i class="fas fa-file-excel mr-2"></i> Excel
                </a>
                <a href="{{ route('admin.laporan.export-pdf', request()->all()) }}" target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-lg text-sm transition backdrop-blur-sm">
                    <i class="fas fa-file-pdf mr-2"></i> PDF
                </a>
            </div>
            @endif
        </div>

        @if (count($hasilLaporanUmum) > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Detail Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Keperluan</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($hasilLaporanUmum as $index => $pengajuan)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            {{ $pengajuan->approved_at ? $pengajuan->approved_at->timezone('Asia/Jakarta')->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800">{{ $pengajuan->nama_pegawai }}</div>
                            <div class="text-xs text-slate-500">{{ $pengajuan->nip }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-700">
                            <ul class="space-y-1">
                                @foreach($pengajuan->pengajuanDetails as $detail)
                                    <li class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                                        {{ $detail->barang->namaBarang ?? 'Barang Tidak Ditemukan' }} 
                                        <span class="font-semibold text-blue-600">({{ $detail->jumlah ?? 0 }} {{ $detail->barang->satuan ?? 'unit' }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 text-slate-700 max-w-xs">
                            <span class="line-clamp-2">{{ $pengajuan->description ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i> Disetujui
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-12 text-center">
            <i class="fas fa-inbox text-5xl text-slate-300 mb-4"></i>
            <p class="text-slate-600 font-medium mb-1">Tidak ada data ditemukan</p>
            <p class="text-sm text-slate-500">Coba ubah filter tanggal atau kategori</p>
        </div>
        @endif
    </div>
    @endif

    <!-- ===================== HASIL LAPORAN PER PEGAWAI ===================== -->
    @if ($jenisLaporan === 'pegawai')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-violet-600 border-b border-slate-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fas fa-user"></i> Laporan Per Pegawai
                </h3>
                @if ($selectedPegawai)
                <p class="text-purple-100 text-sm mt-1">
                    Pegawai: <strong>{{ $selectedPegawai->nama_lengkap }}</strong> ({{ $selectedPegawai->nip }})
                    | Total: <strong>{{ count($hasilLaporanPegawai) }}</strong> pengajuan disetujui
                </p>
                @endif
            </div>
            @if (count($hasilLaporanPegawai) > 0)
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.export-excel', request()->all()) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-lg text-sm transition backdrop-blur-sm">
                    <i class="fas fa-file-excel mr-2"></i> Excel
                </a>
                <a href="{{ route('admin.laporan.export-pdf', request()->all()) }}" target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-lg text-sm transition backdrop-blur-sm">
                    <i class="fas fa-file-pdf mr-2"></i> PDF
                </a>
            </div>
            @endif
        </div>

        @if ($selectedPegawai)
        <!-- Info Pegawai Card -->
        <div class="px-6 py-4 bg-purple-50 border-b border-purple-100">
            <div class="flex items-center gap-4">
                <div class="h-14 w-14 bg-gradient-to-br from-purple-400 to-violet-500 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                    {{ strtoupper(substr($selectedPegawai->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-lg">{{ $selectedPegawai->nama_lengkap }}</h4>
                    <div class="flex items-center gap-4 text-sm text-slate-600 mt-1">
                        <span><i class="fas fa-id-card mr-1 text-purple-500"></i> {{ $selectedPegawai->nip }}</span>
                        <span><i class="fas fa-briefcase mr-1 text-purple-500"></i> {{ $selectedPegawai->jabatan }}</span>
                        <span><i class="fas fa-building mr-1 text-purple-500"></i> {{ $selectedPegawai->divisi }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (count($hasilLaporanPegawai) > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Tanggal Disetujui</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Detail Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Keperluan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Disetujui Oleh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($hasilLaporanPegawai as $index => $pengajuan)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            {{ $pengajuan->approved_at ? $pengajuan->approved_at->timezone('Asia/Jakarta')->format('d M Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-slate-700">
                            <ul class="space-y-1">
                                @foreach($pengajuan->pengajuanDetails as $detail)
                                    <li class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-purple-400 rounded-full"></span>
                                        {{ $detail->barang->namaBarang ?? 'Barang Tidak Ditemukan' }} 
                                        <span class="font-semibold text-purple-600">({{ $detail->jumlah ?? 0 }} {{ $detail->barang->satuan ?? 'unit' }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 text-slate-700 max-w-xs">
                            <span class="line-clamp-2">{{ $pengajuan->description ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-700">
                            {{ $pengajuan->approver->email ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="px-6 py-4 bg-purple-50 border-t border-purple-100">
            <div class="flex items-center gap-6 text-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-box text-purple-500"></i>
                    <span class="text-slate-600">Total Barang Diminta:</span>
                    <strong class="text-purple-700">
                        {{ $hasilLaporanPegawai->flatMap(fn($p) => $p->pengajuanDetails)->sum('jumlah') }} item
                    </strong>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-slate-600">Total Pengajuan Disetujui:</span>
                    <strong class="text-green-700">{{ count($hasilLaporanPegawai) }}</strong>
                </div>
            </div>
        </div>
        @else
        <div class="p-12 text-center">
            <i class="fas fa-user-slash text-5xl text-slate-300 mb-4"></i>
            <p class="text-slate-600 font-medium mb-1">Tidak ada data pengajuan disetujui</p>
            <p class="text-sm text-slate-500">Pegawai ini belum memiliki pengajuan yang disetujui dalam periode yang dipilih</p>
        </div>
        @endif
    </div>
    @endif

    <!-- Jika belum ada laporan yang digenerate -->
    @if (!$jenisLaporan)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
        <div class="max-w-md mx-auto">
            <div class="h-20 w-20 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-chart-pie text-4xl text-blue-500"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Selamat Datang di Pusat Laporan</h3>
            <p class="text-slate-600 mb-4">Pilih jenis laporan dan kriteria filter di atas, lalu klik tombol "Generate Laporan" untuk melihat data.</p>
            <div class="flex justify-center gap-4 text-sm text-slate-500">
                <span class="flex items-center gap-1"><i class="fas fa-chart-bar text-green-500"></i> Laporan Umum</span>
                <span class="flex items-center gap-1"><i class="fas fa-user text-purple-500"></i> Laporan Per Pegawai</span>
            </div>
        </div>
    </div>
    @endif

</div>

<script>
function switchTab(tab) {
    // Hide both forms
    document.getElementById('form-umum').classList.add('hidden');
    document.getElementById('form-pegawai').classList.add('hidden');
    
    // Reset tab styles
    document.getElementById('tab-umum').classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
    document.getElementById('tab-pegawai').classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
    document.getElementById('tab-umum').classList.add('text-slate-600');
    document.getElementById('tab-pegawai').classList.add('text-slate-600');
    
    // Show selected form and activate tab
    if (tab === 'umum') {
        document.getElementById('form-umum').classList.remove('hidden');
        document.getElementById('tab-umum').classList.add('bg-white', 'text-blue-600', 'shadow-sm');
        document.getElementById('tab-umum').classList.remove('text-slate-600');
    } else {
        document.getElementById('form-pegawai').classList.remove('hidden');
        document.getElementById('tab-pegawai').classList.add('bg-white', 'text-blue-600', 'shadow-sm');
        document.getElementById('tab-pegawai').classList.remove('text-slate-600');
    }
}

// Set active tab on page load
window.addEventListener('DOMContentLoaded', function() {
    const activeTab = '{{ old("jenis_laporan", request("jenis_laporan", "umum")) }}';
    switchTab(activeTab);
});
</script>

@endsection