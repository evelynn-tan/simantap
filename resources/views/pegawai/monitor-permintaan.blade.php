@extends('layouts.pegawai-layout')

@section('title', 'Monitor Status Permintaan - SIMANTAP')
@section('page-title', 'Monitor Status Permintaan')
@section('page-subtitle', 'Pantau status permintaan barang yang telah Anda ajukan')

@section('content')
<div class="bg-white rounded-lg shadow-sm border">
    <form method="GET" action="{{ route('pegawai.monitor-permintaan') }}">
        
        <div class="px-6 py-4 border-b">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Monitor Status Permintaan</h3>
                    <p class="text-sm text-gray-600">Pantau status permintaan barang yang telah Anda ajukan</p>
                </div>
                
                <div class="flex flex-wrap items-center gap-2">
                    
                    <select 
                        name="status" 
                        class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                        onchange="this.form.submit()" {{-- Opsional: Auto-submit saat ganti --}}
                    >
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    <input 
                        type="date" 
                        name="tanggal_mulai" 
                        value="{{ request('tanggal_mulai') }}"
                        class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                        title="Tanggal Mulai"
                    >

                    <span class="text-gray-400">-</span>

                    <input 
                        type="date" 
                        name="tanggal_selesai" 
                        value="{{ request('tanggal_selesai') }}"
                        class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                        title="Tanggal Selesai"
                    >

                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    
                    @if(request()->hasAny(['status', 'tanggal_mulai', 'tanggal_selesai']))
                        <a href="{{ route('pegawai.monitor-permintaan') }}" class="text-gray-500 hover:text-red-500 px-2" title="Reset Filter">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
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
                        {{ $p->created_at->timezone('Asia/Jakarta')->format('h:i A d M Y') }}
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

    <div class="px-6 py-4 border-t bg-gray-50">
         {{ $permintaan->appends(request()->query())->links() }}
    </div>
</div>
@endsection