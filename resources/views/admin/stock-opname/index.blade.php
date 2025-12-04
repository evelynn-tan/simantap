@extends('layouts.admin')

@section('title', 'Stock Opname - SIMANTAP')
@section('header', 'Stock Opname')
@section('subtitle', 'Pengecekan fisik dan penyesuaian stok barang')

@section('content')
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

    <!-- Info Card -->
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start gap-4">
            <div class="h-12 w-12 bg-blue-200 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-clipboard-check text-2xl text-blue-700"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-blue-900 mb-1">Sesi Stock Opname Baru</h3>
                <p class="text-sm text-blue-800 mb-3">
                    Lakukan pengecekan fisik untuk <strong>{{ \App\Models\Barang::count() }} barang</strong> dalam sistem
                </p>
                <p class="text-xs text-blue-700 mb-3">⚠️ Stock opname akan mencatat semua perbedaan stok dan membuat transaksi penyesuaian otomatis</p>
                <a href="{{ route('admin.stock-opname.create') }}" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-sm transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Mulai Sesi Opname Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Riwayat Opname -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">📋 Riwayat Stock Opname</h3>
            <p class="text-sm text-slate-500 mt-1">Daftar semua sesi stock opname yang telah dilakukan</p>
        </div>

        @if($riwayatOpname->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">ID Opname</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Operator</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Total Item</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Item Selisih</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($riwayatOpname as $opname)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-mono font-bold text-slate-800">OP-{{ str_pad($opname->opnameID, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4 text-slate-700">
                            {{ \Carbon\Carbon::parse($opname->tanggal_opname)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-slate-700 font-medium">
                            {{ $opname->user->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center text-slate-800 font-semibold">
                            {{ $opname->details->count() ?? 0 }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $selisihCount = $opname->details()->where('stok_selisih', '!=', 0)->count();
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold" 
                                :class="$selisihCount > 0 ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800'">
                                @if($selisihCount > 0)
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $selisihCount }} item
                                @else
                                    <i class="fas fa-check-circle mr-1"></i> Sesuai
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex gap-2 justify-center">
                                <a 
                                    href="{{ route('admin.stock-opname.show', $opname->opnameID) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-sm font-semibold transition duration-200"
                                    title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.stock-opname.destroy', $opname->opnameID) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        onclick="return confirm('Yakin ingin menghapus record ini?')"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-semibold transition duration-200"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex justify-end">
            {{ $riwayatOpname->links() }}
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <i class="fas fa-inbox text-4xl text-slate-300 mb-3"></i>
            <p class="text-slate-500 font-medium">Belum ada riwayat stock opname</p>
            <p class="text-sm text-slate-400 mt-1">Mulai sesi opname baru untuk mencatat perbedaan stok</p>
        </div>
        @endif
    </div>

</div>
@endsection