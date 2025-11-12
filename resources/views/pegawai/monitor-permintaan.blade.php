@extends('pegawai.layout')

@section('title', 'Monitor Status Permintaan - SIMANTAP')
@section('page-title', 'Monitor Status Permintaan')
@section('page-subtitle', 'Pantau status permintaan barang yang telah Anda ajukan')

@section('content')
<div class="bg-white rounded-lg shadow-sm border">
    <!-- Header dengan Filter -->
    <div class="px-6 py-4 border-b">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Monitor Status Permintaan</h3>
                <p class="text-sm text-gray-600">Pantau status permintaan barang yang telah Anda ajukan</p>
            </div>
            <div class="flex items-center space-x-4">
                <select class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option>Semua Status</option>
                    <option>Menunggu</option>
                    <option>Disetujui</option>
                    <option>Ditolak</option>
                </select>
                <input type="date" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <input type="date" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($permintaan as $p)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $p->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @foreach($p->pengajuanDetails as $detail)
                        <div class="mb-1">
                            <span class="font-medium">{{ $detail->barang->nama_barang }}</span>
                            <br>
                            <span class="text-xs text-gray-500">Kode: {{ $detail->barang->kode_barang }}</span>
                        </div>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @foreach($p->pengajuanDetails as $detail)
                        <div class="mb-1">
                            {{ $detail->jumlah }} {{ $detail->barang->satuan }}
                        </div>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                        {{ Str::limit($p->description, 50) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($p->status == 'menunggu')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>Menunggu
                            </span>
                        @elseif($p->status == 'disetujui')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>Disetujui
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times mr-1"></i>Ditolak
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                        <i class="fas fa-clipboard-list text-3xl text-gray-300 mb-2"></i>
                        <p>Belum ada permintaan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="px-6 py-4 border-t bg-gray-50">
        <p class="text-sm text-gray-600">Menampilkan {{ $permintaan->count() }} permintaan</p>
    </div>
</div>
@endsection