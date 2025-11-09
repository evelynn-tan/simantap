<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pusat Laporan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="laporan-umum-tab" data-tabs-target="#laporan-umum" type="button" role="tab" aria-controls="laporan-umum" aria-selected="false">Laporan Umum</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="laporan-pegawai-tab" data-tabs-target="#laporan-pegawai" type="button" role="tab" aria-controls="laporan-pegawai" aria-selected="false">Laporan Per Pegawai</button>
                        </li>
                    </ul>
                </div>

                <div id="myTabContent">
                    <div class="hidden p-4 rounded-lg bg-gray-50" id="laporan-umum" role="tabpanel" aria-labelledby="laporan-umum-tab">
                        <form action="{{ route('admin.laporan.index') }}" method="GET">
                            <input type="hidden" name="jenis_laporan" value="umum">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                <div>
                                    <label for="tanggal_mulai_umum" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai_umum" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                </div>
                                <div>
                                    <label for="tanggal_selesai_umum" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" id="tanggal_selesai_umum" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                </div>
                                <div>
                                    <label for="kategori_id" class="block mb-2 text-sm font-medium text-gray-900">Kategori Barang</label>
                                    <select id="kategori_id" name="kategori_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                        <option value="">Semua Kategori</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 h-10">Generate Laporan</button>
                            </div>
                        </form>
                    </div>
                    <div class="hidden p-4 rounded-lg bg-gray-50" id="laporan-pegawai" role="tabpanel" aria-labelledby="laporan-pegawai-tab">
                        <form action="{{ route('admin.laporan.index') }}" method="GET">
                            <input type="hidden" name="jenis_laporan" value="pegawai">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                <div>
                                    <label for="pegawai_id" class="block mb-2 text-sm font-medium text-gray-900">Pilih Pegawai *</label>
                                    <select id="pegawai_id" name="pegawai_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                        <option value="">-- Pilih Pegawai --</option>
                                        @foreach($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}">{{ $pegawai->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="periode" class="block mb-2 text-sm font-medium text-gray-900">Periode Waktu</label>
                                    <select id="periode" name="periode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                        <option value="">Semua Waktu</option>
                                        <option value="30">30 Hari Terakhir</option>
                                        <option value="90">90 Hari Terakhir</option>
                                    </select>
                                </div>
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 h-10">Generate Laporan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-medium mb-4">Hasil Laporan</h3>
                    @if ($hasilLaporan)
                        <div class="flex justify-end mb-4 gap-2">
                            <button type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Excel</button>
                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Cetak</button>
                        </div>
                        
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Tanggal Disetujui</th>
                                        <th scope="col" class="px-6 py-3">Nama Pegawai</th>
                                        <th scope="col" class="px-6 py-3">Barang & Jumlah</th>
                                        <th scope="col" class="px-6 py-3">Keperluan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($hasilLaporan as $permintaan)
                                        <tr class="bg-white border-b">
                                            <td class="px-6 py-4">{{ $permintaan->processed_at->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4">{{ $permintaan->user->name }}</td>
                                            <td class="px-6 py-4">
                                                @foreach($permintaan->details as $detail)
                                                    <div>{{ $detail->barang->nama_barang }} ({{ $detail->jumlah_diminta }} unit)</div>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4">{{ $permintaan->keperluan }}</td>
                                        </tr>
                                    @empty
                                        <tr class="bg-white border-b">
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                                Tidak ada data ditemukan untuk filter ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center p-8 border-dashed border-2 border-gray-300 rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" ...></svg> <h3 class="mt-2 text-sm font-medium text-gray-900">Silakan pilih filter dan generate laporan untuk melihat hasil.</h3>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>