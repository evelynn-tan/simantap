@extends('layouts.admin')
@section('title', 'Pusat Laporan')
@section('header', 'Pusat Laporan')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            
            <!-- TAB NAVIGASI -->
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="laporanTab" data-tabs-toggle="#laporanTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        {{-- Atur tab aktif berdasarkan jenis_laporan di request --}}
                        <button class="inline-block p-4 border-b-2 rounded-t-lg {{ old('jenis_laporan', request('jenis_laporan')) == 'umum' || !request('jenis_laporan') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}" id="laporan-umum-tab" data-tabs-target="#laporan-umum" type="button" role="tab" aria-controls="laporan-umum" aria-selected="{{ old('jenis_laporan', request('jenis_laporan')) == 'umum' || !request('jenis_laporan') ? 'true' : 'false' }}">Laporan Umum</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg {{ old('jenis_laporan', request('jenis_laporan')) == 'pegawai' ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}" id="laporan-pegawai-tab" data-tabs-target="#laporan-pegawai" type="button" role="tab" aria-controls="laporan-pegawai" aria-selected="{{ old('jenis_laporan', request('jenis_laporan')) == 'pegawai' ? 'true' : 'false' }}">Laporan Per Pegawai</button>
                    </li>
                </ul>
            </div>

            <!-- ISI TAB -->
            <div id="laporanTabContent">
                
                @php
                    $activeTab = old('jenis_laporan', request('jenis_laporan', 'umum'));
                @endphp
                
                <!-- Tab Laporan Umum -->
                <div class="{{ $activeTab == 'umum' ? 'block' : 'hidden' }} p-4 rounded-lg bg-gray-50" id="laporan-umum" role="tabpanel" aria-labelledby="laporan-umum-tab">
                    <form action="{{ route('admin.laporan.index') }}" method="GET">
                        <input type="hidden" name="jenis_laporan" value="umum">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', request('tanggal_mulai')) }}" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', request('tanggal_selesai')) }}" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Kategori Barang</label>
                                <select name="kategori_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                    <option value="">Semua Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->kategoriID }}" {{ (string)old('kategori_id', request('kategori_id')) === (string)$kategori->kategoriID ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 h-[42px]">
                                <i class="fas fa-search mr-2"></i>Generate
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tab Laporan Pegawai -->
                <div class="{{ $activeTab == 'pegawai' ? 'block' : 'hidden' }} p-4 rounded-lg bg-gray-50" id="laporan-pegawai" role="tabpanel" aria-labelledby="laporan-pegawai-tab">
                    <form action="{{ route('admin.laporan.index') }}" method="GET">
                        <input type="hidden" name="jenis_laporan" value="pegawai">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Pilih Pegawai *</label>
                                <select name="pegawai_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                    <option value="">-- Pilih Pegawai --</option>
                                    @foreach($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}" {{ (string)old('pegawai_id', request('pegawai_id')) === (string)$pegawai->id ? 'selected' : '' }}>
                                            {{-- PERBAIKAN: Gunakan null coalescing operator untuk fallback --}}
                                            {{ $pegawai->name ?? 'Pegawai ID: ' . $pegawai->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Periode</label>
                                <select name="periode" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                    @php $selectedPeriode = old('periode', request('periode')); @endphp
                                    <option value="" {{ $selectedPeriode == '' ? 'selected' : '' }}>Semua Waktu</option>
                                    <option value="30" {{ $selectedPeriode == '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                                    <option value="90" {{ $selectedPeriode == '90' ? 'selected' : '' }}>90 Hari Terakhir</option>
                                </select>
                            </div>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 h-[42px]">
                                <i class="fas fa-search mr-2"></i>Generate
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- HASIL LAPORAN (TABEL) -->
            <div class="mt-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Hasil Laporan</h3>
                
                {{-- Cek apakah variabel hasilLaporan tersedia dari controller dan memiliki data --}}
                @if (isset($hasilLaporan) && count($hasilLaporan) > 0)
                    <div class="flex justify-end mb-4 gap-2">
                        {{-- Tombol Export & Cetak (Gunakan rute POST/GET terpisah untuk ekspor) --}}
                        
                        <form action="{{ route('admin.laporan.generate') }}" method="POST">
                            @csrf
                            {{-- Passthrough semua filter request ke form export/print --}}
                            @foreach(request()->except(['_token']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <input type="hidden" name="action" value="excel">
                            <button type="submit" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 font-medium rounded-lg text-sm px-4 py-2">
                                <i class="fas fa-file-excel text-green-600 mr-2"></i>Export Excel
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.laporan.generate') }}" method="POST">
                            @csrf
                            @foreach(request()->except(['_token']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <input type="hidden" name="action" value="pdf">
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">
                                <i class="fas fa-print mr-2"></i>Cetak PDF
                            </button>
                        </form>

                    </div>
                    
                    <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Tanggal Disetujui</th>
                                    <th scope="col" class="px-6 py-3">Pegawai Peminta</th>
                                    <th scope="col" class="px-6 py-3">Detail Barang Keluar</th>
                                    <th scope="col" class="px-6 py-3">Keperluan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilLaporan as $permintaan)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        {{-- Gunakan processed_at yang disediakan di controller --}}
                                        <td class="px-6 py-4 font-medium">{{ $permintaan->approved_at ? $permintaan->approved_at->format('d/m/Y H:i') : 'Menunggu' }}</td>
                                        {{-- Asumsi relasi User di Pengajuan dinamai 'user' --}}
                                        <td class="px-6 py-4">{{ $permintaan->user->name ?? $permintaan->userID ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <ul class="list-disc list-inside">
                                            @foreach($permintaan->details as $detail)
                                                {{-- Asumsi kolom di PengajuanDetail adalah 'jumlah' --}}
                                                <li>{{ $detail->barang->nama_barang ?? 'Barang Tidak Ditemukan' }} (<b>{{ $detail->jumlah ?? 'N/A' }}</b> unit)</li>
                                            @endforeach
                                            </ul>
                                        </td>
                                        <td class="px-6 py-4">{{ $permintaan->keperluan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center p-8 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                        <i class="fas fa-search text-4xl mb-3 text-gray-300"></i>
                        <p class="text-sm">Belum ada data laporan yang ditampilkan.</p>
                        <p class="text-xs">Silakan gunakan filter di atas lalu klik "Generate".</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
    
    {{-- Script untuk Tab Toggle (dari kode Anda sebelumnya) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('#laporanTab button');
            const tabContents = document.querySelectorAll('#laporanTabContent > div');

            // Logic untuk mengaktifkan/menonaktifkan tab.
            tabs.forEach(tab => {
                tab.addEventListener('click', (e) => {
                    const target = e.target.getAttribute('data-tabs-target');
                    
                    // Non-aktifkan semua tab
                    tabs.forEach(t => {
                        t.classList.remove('text-blue-600', 'border-blue-600');
                        t.classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                        t.setAttribute('aria-selected', 'false');
                    });

                    // Sembunyikan semua konten
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                        content.classList.remove('block');
                    });

                    // Aktifkan tab yang diklik
                    e.target.classList.add('text-blue-600', 'border-blue-600');
                    e.target.classList.remove('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                    e.target.setAttribute('aria-selected', 'true');
                    
                    // Tampilkan konten yang sesuai
                    document.querySelector(target).classList.remove('hidden');
                    document.querySelector(target).classList.add('block');
                });
            });

            // Logika untuk mengaktifkan tab saat memuat halaman (berdasarkan URL parameter)
            const activeTab = '{{ $activeTab }}';
            if (activeTab) {
                const activeTabId = '#laporan-' + activeTab + '-tab';
                const activeTabButton = document.querySelector(activeTabId);
                if (activeTabButton) {
                    activeTabButton.click();
                }
            } else {
                 // Default: aktifkan tab umum
                document.getElementById('laporan-umum-tab').click();
            }
        });
    </script>
@endsection