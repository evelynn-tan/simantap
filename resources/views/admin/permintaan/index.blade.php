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
                    <th scope="col" class="px-6 py-3">Tanggal</th>
                    <th scope="col" class="px-6 py-3">Pegawai</th>
                    <th scope="col" class="px-6 py-3">Barang & Jumlah</th>
                    <th scope="col" class="px-6 py-3">Keperluan</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftarPermintaan as $permintaan)
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4">{{ $permintaan->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ $permintaan->pegawai->nama_lengkap ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            @foreach($permintaan->details as $detail)
                                <div>{{ $detail->barang->nama_barang ?? 'N/A' }} ({{ $detail->jumlah }} unit)</div>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">{{ $permintaan->description }}</td>
                        <td class="px-6 py-4">
                            @if ($permintaan->status == 'menunggu')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Menunggu</span>
                            @elseif ($permintaan->status == 'disetujui')
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Disetujui</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($permintaan->status == 'menunggu')
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.permintaan.setujui', $permintaan) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-sm px-3 py-1">Setujui</button>
                                    </form>
                                    <form action="{{ route('admin.permintaan.tolak', $permintaan) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-sm px-3 py-1">Tolak</button>
                                    </form>
                                </div>
                            @else
                                -
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