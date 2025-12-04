@extends('layouts.admin')
@section('title', 'Laporan')
@section('header', 'Pusat Laporan')
@section('subtitle', 'Kelola dan ekspor laporan pengajuan barang')

@section('content')
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">🔍 Filter Laporan</h3>
        </div>
        
        <div class="p-6">
            <!-- Tabs -->
            <div class="flex gap-2 mb-6 border-b border-slate-200">
                <button 
                    onclick="switchTab('umum')"
                    id="tab-umum"
                    class="px-4 py-2.5 font-semibold text-sm transition border-b-2 border-blue-600 text-blue-600">
                    <i class="fas fa-chart-bar mr-2"></i> Laporan Umum
                </button>
                <button 
                    onclick="switchTab('pegawai')"
                    id="tab-pegawai"
                    class="px-4 py-2.5 font-semibold text-sm transition border-b-2 border-transparent text-slate-600 hover:text-slate-800">
                    <i class="fas fa-user mr-2"></i> Per Pegawai
                </button>
            </div>

            <!-- Form Laporan Umum -->
            <form id="form-umum" action="{{ route('admin.laporan.index') }}" method="GET" class="block">
                <input type="hidden" name="jenis_laporan" value="umum">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', request('tanggal_mulai')) }}" 
                            class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" style="font-family: 'Poppins', sans-serif;">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', request('tanggal_selesai')) }}" 
                            class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" style="font-family: 'Poppins', sans-serif;">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Barang</label>
                        <select name="kategori_id" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" style="font-family: 'Poppins', sans-serif;">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->kategoriID }}" {{ (string)old('kategori_id', request('kategori_id')) === (string)$kategori->kategoriID ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i> Generate
                    </button>
                </div>
            </form>

            <!-- Form Laporan Per Pegawai -->
            <form id="form-pegawai" action="{{ route('admin.laporan.index') }}" method="GET" class="hidden">
                <input type="hidden" name="jenis_laporan" value="pegawai">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pegawai <span class="text-red-600">*</span></label>
                        <select name="pegawai_id" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required style="font-family: 'Poppins', sans-serif;">
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ (string)old('pegawai_id', request('pegawai_id')) === (string)$pegawai->id ? 'selected' : '' }}>
                                    {{ $pegawai->nama_lengkap ?? $pegawai->name ?? 'Pegawai ID: ' . $pegawai->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Periode</label>
                        <select name="periode" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" style="font-family: 'Poppins', sans-serif;">
                            @php $selectedPeriode = old('periode', request('periode')); @endphp
                            <option value="" {{ $selectedPeriode == '' ? 'selected' : '' }}>Semua Waktu</option>
                            <option value="30" {{ $selectedPeriode == '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                            <option value="90" {{ $selectedPeriode == '90' ? 'selected' : '' }}>90 Hari Terakhir</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i> Generate
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Export Buttons -->
    @if (isset($hasilLaporan) && count($hasilLaporan) > 0)
    <div class="flex gap-3 justify-end">
        <form action="{{ route('admin.laporan.generate') }}" method="POST">
            @csrf
            @foreach(request()->except(['_token']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <input type="hidden" name="action" value="excel">
            <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg text-sm transition">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
            </button>
        </form>
        
        <form action="{{ route('admin.laporan.generate') }}" method="POST">
            @csrf
            @foreach(request()->except(['_token']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <input type="hidden" name="action" value="pdf">
            <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg text-sm transition">
                <i class="fas fa-file-pdf mr-2"></i> Cetak PDF
            </button>
        </form>
    </div>
    @endif

    <!-- Results Section -->
    @if (isset($hasilLaporan) && count($hasilLaporan) > 0)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">📊 Hasil Laporan</h3>
            <p class="text-sm text-slate-600 mt-1">Total data: <strong>{{ count($hasilLaporan) }}</strong> pengajuan</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Detail Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Keperluan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($hasilLaporan as $permintaan)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            {{ $permintaan->approved_at ? $permintaan->approved_at->timezone('Asia/Jakarta')->format('d M Y') : 'Menunggu' }}
                        </td>
                        <td class="px-6 py-4 text-slate-700 font-medium">
                            {{ $permintaan->user->name ?? $permintaan->userID ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-slate-700">
                            <ul class="list-disc list-inside text-sm">
                                @foreach($permintaan->details as $detail)
                                    <li>{{ $detail->barang->nama_barang ?? 'Barang Tidak Ditemukan' }} <strong>({{ $detail->jumlah ?? 0 }} unit)</strong></li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 text-slate-700 max-w-xs">
                            <span class="line-clamp-2">{{ $permintaan->keperluan ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($permintaan->status === 'approved')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Disetujui
                                </span>
                            @elseif($permintaan->status === 'rejected')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i> Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> Menunggu
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
        <i class="fas fa-file-search text-5xl text-slate-300 mb-4"></i>
        <p class="text-slate-600 font-medium mb-1">Belum ada data laporan</p>
        <p class="text-sm text-slate-500">Gunakan filter di atas dan klik "Generate" untuk melihat laporan</p>
    </div>
    @endif

</div>

<script style="font-family: 'Poppins', sans-serif;">
function switchTab(tab) {
    // Hide both forms
    document.getElementById('form-umum').classList.add('hidden');
    document.getElementById('form-pegawai').classList.add('hidden');
    
    // Remove active state from all tabs
    document.getElementById('tab-umum').classList.remove('border-blue-600', 'text-blue-600');
    document.getElementById('tab-pegawai').classList.remove('border-blue-600', 'text-blue-600');
    document.getElementById('tab-umum').classList.add('border-transparent', 'text-slate-600');
    document.getElementById('tab-pegawai').classList.add('border-transparent', 'text-slate-600');
    
    // Show selected form and tab
    if (tab === 'umum') {
        document.getElementById('form-umum').classList.remove('hidden');
        document.getElementById('tab-umum').classList.add('border-blue-600', 'text-blue-600');
        document.getElementById('tab-umum').classList.remove('border-transparent', 'text-slate-600');
    } else {
        document.getElementById('form-pegawai').classList.remove('hidden');
        document.getElementById('tab-pegawai').classList.add('border-blue-600', 'text-blue-600');
        document.getElementById('tab-pegawai').classList.remove('border-transparent', 'text-slate-600');
    }
}

// Set active tab on page load
window.addEventListener('DOMContentLoaded', function() {
    const activeTab = '{{ old("jenis_laporan", request("jenis_laporan", "umum")) }}';
    switchTab(activeTab);
});
</script>

@endsection