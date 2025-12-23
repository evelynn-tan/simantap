@extends('layouts.pegawai-layout')

@section('title', 'Daftar Barang Tersedia - SIMANTAP')
@section('page-title', 'Daftar Barang Tersedia')
@section('page-subtitle', 'Lihat dan ajukan permintaan untuk barang yang tersedia')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>
@endpush

@section('content')
<div x-data="barangPage()">

    {{-- Header Banner with Search & Filter --}}
    <div class="mb-6">
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-boxes text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Daftar Barang Tersedia</h1>
                        <p class="text-emerald-100 text-sm">Pilih barang dan ajukan permintaan</p>
                    </div>
                </div>

                {{-- Search & Filter --}}
                <div class="flex flex-wrap items-center gap-2">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-3 text-slate-400"></i>
                        <input 
                            type="text" 
                            x-model="searchQuery"
                            @input.debounce.500ms="liveSearch"
                            placeholder="Cari barang..." 
                            class="pl-10 pr-4 py-2 border-0 rounded-lg text-sm text-slate-700 w-48 focus:ring-2 focus:ring-white"
                        >
                    </div>
                    <select 
                        x-model="kategoriFilter"
                        @change="applyFilters"
                        class="px-4 py-2 border-0 rounded-lg text-sm text-slate-700"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris ?? [] as $k)
                            <option value="{{ $k->categoryID }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <button @click="resetFilters" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition flex items-center gap-2">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>

            {{-- Active Filters Display --}}
            <div x-show="currentSort || searchQuery || kategoriFilter" class="mt-4 flex flex-wrap items-center gap-2">
                <span class="text-emerald-200 text-xs">Filter aktif:</span>
                <template x-if="currentSort">
                    <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-lg">
                        <i class="fas fa-sort mr-1"></i>Sorted: <span x-text="sortLabel"></span>
                    </span>
                </template>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <button @click="toggleSort('kode_barang')" class="flex items-center gap-1 text-xs font-bold text-slate-500 uppercase tracking-wider hover:text-emerald-600 transition">
                                Kode
                                <i class="fas" :class="getSortIcon('kode_barang')"></i>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <button @click="toggleSort('namaBarang')" class="flex items-center gap-1 text-xs font-bold text-slate-500 uppercase tracking-wider hover:text-emerald-600 transition">
                                Nama Barang
                                <i class="fas" :class="getSortIcon('namaBarang')"></i>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <button @click="toggleSort('categoryID')" class="flex items-center gap-1 text-xs font-bold text-slate-500 uppercase tracking-wider hover:text-emerald-600 transition">
                                Kategori
                                <i class="fas" :class="getSortIcon('categoryID')"></i>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-center">
                            <button @click="toggleSort('stok')" class="flex items-center gap-1 text-xs font-bold text-slate-500 uppercase tracking-wider hover:text-emerald-600 transition">
                                Stok
                                <i class="fas" :class="getSortIcon('stok')"></i>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($barangs as $barang)
                    @php
                        // Calculate pending requests for this item by current user
                        $pendingQty = \App\Models\PengajuanDetail::whereHas('pengajuan', function($q) use ($pegawai) {
                            $q->where('pegawaiID', $pegawai->pegawaiID)->where('status', 'menunggu');
                        })->where('barangID', $barang->barangID)->sum('jumlah');
                        $availableStock = $barang->stok - $pendingQty;
                        if ($availableStock < 0) $availableStock = 0;
                    @endphp
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 font-mono">
                                {{ $barang->kode_barang }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-800">
                            {{ $barang->namaBarang }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-emerald-50 text-emerald-700">
                                <i class="fas fa-folder mr-1.5"></i>{{ $barang->kategori->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($barang->stok > 10)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    <i class="fas fa-cubes mr-1.5"></i>{{ $barang->stok }} {{ $barang->satuan }}
                                </span>
                            @elseif($barang->stok > 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                    <i class="fas fa-cubes mr-1.5"></i>{{ $barang->stok }} {{ $barang->satuan }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <i class="fas fa-times-circle mr-1.5"></i>Habis
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($barang->stok > 0)
                            <button 
                                @click='openModal(@json($barang), {{ $pendingQty }}, {{ $availableStock }})'
                                class="inline-flex items-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold rounded-lg shadow-sm transition"
                            >
                                <i class="fas fa-paper-plane mr-1.5"></i> Ajukan
                            </button>
                            @else
                            <span class="text-slate-400 text-xs">Tidak tersedia</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-box-open text-5xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500 font-medium">Tidak ada barang ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($barangs, 'links'))
        <div class="px-6 py-4 border-t bg-slate-50">
            {{ $barangs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>


    {{-- ===================== MODAL AJUKAN BARANG ===================== --}}
    <div 
        x-show="isModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        <div 
            x-show="isModalOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            class="fixed inset-0 bg-black/50"
            @click="closeModal"
        ></div>

        <div 
            x-show="isModalOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
        >
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-paper-plane text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Ajukan Permintaan</h3>
                            <p class="text-sm text-emerald-100">Tentukan jumlah yang dibutuhkan</p>
                        </div>
                    </div>
                    <button @click="closeModal" class="text-white/70 hover:text-white text-xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <form method="POST" action="{{ route('pegawai.permintaan.ajukan') }}">
                @csrf
                <input type="hidden" name="items[0][barangID]" x-bind:value="selectedBarang.barangID">
                
                <div class="p-6">
                    {{-- Info Barang --}}
                    <div class="mb-5 p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                        <p class="text-xs font-bold text-emerald-600 uppercase mb-1">Barang Dipilih</p>
                        <h4 class="font-bold text-slate-800 text-lg" x-text="selectedBarang.namaBarang"></h4>
                        <p class="text-sm text-slate-500 mt-1">
                            Kode: <span class="font-mono bg-white px-2 py-0.5 rounded text-xs" x-text="selectedBarang.kode_barang"></span>
                        </p>
                    </div>

                    {{-- Warning: Pending Requests --}}
                    <div x-show="pendingQty > 0" class="mb-5 p-4 bg-amber-50 rounded-xl border border-amber-200">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-exclamation-triangle text-amber-500 mt-0.5"></i>
                            <div>
                                <p class="text-sm font-semibold text-amber-800">Anda memiliki pengajuan yang sedang diproses</p>
                                <p class="text-xs text-amber-600 mt-1">
                                    <span x-text="pendingQty"></span> <span x-text="selectedBarang.satuan"></span> sedang menunggu persetujuan.
                                    Anda hanya dapat mengajukan <strong x-text="availableStock"></strong> <span x-text="selectedBarang.satuan"></span> lagi.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Stok Info --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Stok Tersedia</label>
                        <input type="text" 
                            x-bind:value="selectedBarang.stok + ' ' + selectedBarang.satuan + (pendingQty > 0 ? ' (Tersisa untuk diajukan: ' + availableStock + ')' : '')"
                            disabled 
                            class="w-full bg-slate-100 border border-slate-200 rounded-lg px-4 py-2 text-slate-500"
                        >
                    </div>

                    {{-- Jumlah dengan +/- buttons --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Diajukan</label>
                        <div class="flex items-center gap-3">
                            <button type="button" @click="decrementJumlah()" 
                                    class="w-12 h-12 bg-slate-100 hover:bg-slate-200 rounded-lg flex items-center justify-center text-slate-600 transition text-lg font-bold">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input 
                                type="text" 
                                inputmode="numeric"
                                pattern="[0-9]*"
                                name="items[0][jumlah]"
                                x-model="formData.jumlah" 
                                @blur="validateJumlah"
                                @input="handleJumlahInput"
                                class="flex-1 text-center text-2xl font-bold border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            >
                            <button type="button" @click="incrementJumlah()" 
                                    class="w-12 h-12 bg-emerald-100 hover:bg-emerald-200 rounded-lg flex items-center justify-center text-emerald-600 transition text-lg font-bold">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <p class="text-xs text-slate-400 mt-2 text-center">
                            Maksimal: <span x-text="availableStock"></span> <span x-text="selectedBarang.satuan"></span>
                        </p>
                    </div>

                    {{-- Keperluan --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Keperluan</label>
                        <textarea 
                            name="description" 
                            rows="3" 
                            required
                            placeholder="Jelaskan keperluan Anda..."
                            class="w-full border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent resize-none"
                        ></textarea>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3">
                        <button type="button" @click="closeModal" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 rounded-lg transition">
                            Batal
                        </button>
                        <button type="submit" 
                                :disabled="availableStock <= 0"
                                :class="availableStock <= 0 ? 'bg-slate-300 cursor-not-allowed' : 'bg-emerald-500 hover:bg-emerald-600'"
                                class="flex-1 text-white font-bold py-3 rounded-lg shadow-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- JavaScript --}}
<script>
function barangPage() {
    return {
        isModalOpen: false,
        selectedBarang: {},
        pendingQty: 0,
        availableStock: 0,
        formData: {
            jumlah: 1,
        },
        searchQuery: "{{ request('search', '') }}",
        kategoriFilter: "{{ request('kategori', '') }}",
        currentSort: "{{ request('sort', '') }}",
        currentDirection: "{{ request('direction', 'asc') }}",

        get sortLabel() {
            const labels = {
                'kode_barang': 'Kode',
                'namaBarang': 'Nama',
                'categoryID': 'Kategori',
                'stok': 'Stok'
            };
            const dir = this.currentDirection === 'asc' ? '↑' : '↓';
            return (labels[this.currentSort] || this.currentSort) + ' (' + dir + ')';
        },

        openModal(barang, pending, available) {
            this.selectedBarang = barang;
            this.pendingQty = pending;
            this.availableStock = available;
            this.formData.jumlah = available > 0 ? 1 : 0;
            this.isModalOpen = true;
        },

        closeModal() {
            this.isModalOpen = false;
        },

        handleJumlahInput() {
            let val = this.formData.jumlah.toString().replace(/[^0-9]/g, '');
            if (val === '') {
                this.formData.jumlah = '';
                return;
            }
            let numVal = parseInt(val) || 0;
            if (numVal > this.availableStock) {
                numVal = this.availableStock;
            }
            this.formData.jumlah = numVal;
        },

        validateJumlah() {
            let val = parseInt(this.formData.jumlah) || 0;
            if (val < 1) val = 1;
            if (val > this.availableStock) val = this.availableStock;
            if (this.availableStock <= 0) val = 0;
            this.formData.jumlah = val;
        },

        incrementJumlah() {
            let val = parseInt(this.formData.jumlah) || 0;
            if (val < this.availableStock) {
                this.formData.jumlah = val + 1;
            }
        },

        decrementJumlah() {
            let val = parseInt(this.formData.jumlah) || 0;
            if (val > 1) {
                this.formData.jumlah = val - 1;
            }
        },

        toggleSort(column) {
            if (this.currentSort === column) {
                this.currentDirection = this.currentDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.currentSort = column;
                this.currentDirection = 'asc';
            }
            this.applyFilters();
        },

        getSortIcon(column) {
            if (this.currentSort !== column) return 'fa-sort text-slate-300';
            return this.currentDirection === 'asc' ? 'fa-sort-up text-emerald-500' : 'fa-sort-down text-emerald-500';
        },

        liveSearch() {
            this.applyFilters();
        },

        resetFilters() {
            this.searchQuery = '';
            this.kategoriFilter = '';
            this.currentSort = '';
            this.currentDirection = 'asc';
            window.location.href = "{{ route('pegawai.daftar-barang') }}";
        },

        applyFilters() {
            const params = new URLSearchParams();
            if (this.searchQuery) params.set('search', this.searchQuery);
            if (this.kategoriFilter) params.set('kategori', this.kategoriFilter);
            if (this.currentSort) {
                params.set('sort', this.currentSort);
                params.set('direction', this.currentDirection);
            }
            window.location.href = "{{ route('pegawai.daftar-barang') }}?" + params.toString();
        }
    }
}
</script>
@endsection