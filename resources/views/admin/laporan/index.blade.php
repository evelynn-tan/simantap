@extends('layouts.admin')
@section('title', 'Pusat Laporan')
@section('header', 'Pusat Laporan')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            
            <!-- TAB NAVIGASI -->
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="laporan-umum-tab" data-tabs-target="#laporan-umum" type="button" role="tab" aria-controls="laporan-umum" aria-selected="false">Laporan Umum</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="laporan-pegawai-tab" data-tabs-target="#laporan-pegawai" type="button" role="tab" aria-controls="laporan-pegawai" aria-selected="false">Laporan Per Pegawai</button>
                    </li>
                </ul>
            </div>

            <!-- ISI TAB -->
            <div id="myTabContent">
                <!-- Tab Laporan Umum -->
                <div class="hidden p-4 rounded-lg bg-gray-50" id="laporan-umum" role="tabpanel" aria-labelledby="laporan-umum-tab">
                    <form action="{{ route('admin.laporan.index') }}" method="GET">
                        <input type="hidden" name="jenis_laporan" value="umum">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Kategori Barang</label>
                                <select name="kategori_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                    <option value="">Semua Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
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
                <div class="hidden p-4 rounded-lg bg-gray-50" id="laporan-pegawai" role="tabpanel" aria-labelledby="laporan-pegawai-tab">
                    <form action="{{ route('admin.laporan.index') }}" method="GET">
                        <input type="hidden" name="jenis_laporan" value="pegawai">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Pilih Pegawai *</label>
                                <select name="pegawai_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                    <option value="">-- Pilih Pegawai --</option>
                                    @foreach($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}">{{ $pegawai->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Periode</label>
                                <select name="periode" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                    <option value="">Semua Waktu</option>
                                    <option value="30">30 Hari Terakhir</option>
                                    <option value="90">90 Hari Terakhir</option>
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
                
                @if ($hasilLaporan && count($hasilLaporan) > 0)
                    <div class="flex justify-end mb-4 gap-2">
                        <button class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 font-medium rounded-lg text-sm px-4 py-2">
                            <i class="fas fa-file-excel text-green-600 mr-2"></i>Export Excel
                        </button>
                        <button class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">
                            <i class="fas fa-print mr-2"></i>Cetak PDF
                        </button>
                    </div>
                    
                    <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Pegawai</th>
                                    <th scope="col" class="px-6 py-3">Detail Barang</th>
                                    <th scope="col" class="px-6 py-3">Keperluan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilLaporan as $permintaan)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium">{{ $permintaan->processed_at ? $permintaan->processed_at->format('d/m/Y') : '-' }}</td>
                                        <td class="px-6 py-4">{{ $permintaan->user->name ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <ul class="list-disc list-inside">
                                            @foreach($permintaan->details as $detail)
                                                <li>{{ $detail->barang->nama_barang }} (<b>{{ $detail->jumlah_diminta }}</b> unit)</li>
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
@endsection