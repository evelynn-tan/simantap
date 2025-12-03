@extends('layouts.admin')

@section('title', 'Manajemen Permintaan - SIMANTAP')
@section('header', 'Manajemen Permintaan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-medium mb-4">Daftar Permintaan</h3>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 w-44">Tanggal</th>
                    <th scope="col" class="px-6 py-3 w-48">Pegawai</th>
                    <th scope="col" class="px-6 py-3">Barang & Jumlah</th>
                    <th scope="col" class="px-6 py-3">Keperluan</th>
                    <th scope="col" class="px-6 py-3 w-32">Status</th>
                    <th scope="col" class="px-6 py-3 w-24 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftarPermintaan as $permintaan)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $permintaan->created_at->timezone('Asia/Jakarta')->format('h:i A d M Y') }}</td>
                        <td class="px-6 py-4">{{ $permintaan->pegawai->nama_lengkap ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            @foreach($permintaan->details as $detail)
                                <div>{{ $detail->barang->nama_barang ?? 'N/A' }} ({{ $detail->jumlah }} unit)</div>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">{{ $permintaan->description }}</td>
                        <td class="px-6 py-4">
                            @if ($permintaan->status == 'menunggu')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Menunggu</span>
                            @elseif ($permintaan->status == 'disetujui')
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Disetujui</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($permintaan->status == 'menunggu')
                                <div class="flex gap-2 justify-center">
                                    <form action="{{ route('admin.permintaan.setujui', $permintaan) }}" method="POST" class="group relative">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-white hover:bg-green-600 rounded-lg p-2 transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                            Setujui
                                        </span>
                                    </form>
                                    <form action="{{ route('admin.permintaan.tolak', $permintaan) }}" method="POST" class="group relative">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-white hover:bg-red-600 rounded-lg p-2 transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                            Tolak
                                        </span>
                                    </form>
                                </div>
                            @else
                                <div class="text-center text-gray-400">-</div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b">
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada permintaan barang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection