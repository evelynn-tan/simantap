@extends('pegawai.layout')

@section('title', 'Daftar Barang Tersedia - SIMANTAP')
@section('page-title', 'Daftar Barang Tersedia')
@section('page-subtitle', 'Lihat dan ajukan permintaan untuk barang yang tersedia')

@section('content')
<div class="bg-white rounded-lg shadow-sm border">
    <!-- Header -->
    <div class="px-6 py-4 border-b">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Daftar Barang Tersedia</h3>
                <p class="text-sm text-gray-600">Lihat dan ajukan permintaan untuk barang yang tersedia</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Cari barang..." class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent w-64">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <select class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option>Semua Kategori</option>
                    <option>ATK</option>
                    <option>Elektronik</option>
                    <option>Furniture</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($barangs as $barang)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $barang->kode_barang }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $barang->nama_barang }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ $barang->kategori->nama_kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $barang->stok_sekarang < 5 ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $barang->stok_sekarang }} {{ $barang->satuan }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Ajukan Permintaan
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                        <i class="fas fa-box-open text-3xl text-gray-300 mb-2"></i>
                        <p>Tidak ada barang tersedia</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="px-6 py-4 border-t bg-gray-50">
        <p class="text-sm text-gray-600">Menampilkan {{ $barangs->count() }} dari {{ $barangs->count() }} barang</p>
    </div>
</div>
@endsection