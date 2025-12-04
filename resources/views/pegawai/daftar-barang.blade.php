@extends('layouts.pegawai-layout')

@section('title', 'Daftar Barang Tersedia - SIMANTAP')
@section('page-title', 'Daftar Barang Tersedia')
@section('page-subtitle', 'Lihat dan ajukan permintaan untuk barang yang tersedia')

@section('content')
<div x-data="barangPage()" x-init="init()">

    {{-- Card utama --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
        
        {{-- Header dengan Search & Filter --}}
        <div class="px-6 py-5 border-b border-slate-100">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="h-8 w-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-boxes text-emerald-600"></i>
                        </span>
                        Daftar Barang Tersedia
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">Pilih barang dan ajukan permintaan</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    {{-- Live Search --}}
                    <div class="relative">
                        <input 
                            type="text"
                            x-model="searchQuery"
                            @input.debounce.300ms="liveSearch()"
                            placeholder="Cari barang..."
                            class="pl-10 pr-10 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent w-64 text-sm transition"
                        >
                        <i class="fas fa-search absolute left-3 top-3 text-slate-400 text-sm"></i>
                        <button 
                            x-show="searchQuery.length > 0"
                            @click="clearSearch()"
                            class="absolute right-3 top-3 text-slate-300 hover:text-slate-500"
                        >
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>

                    {{-- Kategori Filter --}}
                    <select 
                        x-model="kategoriFilter"
                        @change="applyFilters()"
                        class="px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm text-slate-600 cursor-pointer bg-white"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->categoryID }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>

                    {{-- Reset Filter --}}
                    <button 
                        @click="resetFilters()"
                        class="px-4 py-2.5 text-sm text-slate-500 hover:text-red-500 hover:bg-red-50 rounded-xl transition flex items-center gap-1"
                        title="Reset Filter"
                    >
                        <i class="fas fa-undo"></i>
                        <span class="hidden sm:inline">Reset</span>
                    </button>
                </div>
            </div>

            {{-- Active Filters Indicator --}}
            <div x-show="searchQuery || kategoriFilter || currentSort !== 'namaBarang'" class="mt-3 flex flex-wrap gap-2">
                <span class="text-xs text-slate-500">Filter aktif:</span>
                <template x-if="searchQuery">
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs">
                        <i class="fas fa-search"></i> "<span x-text="searchQuery"></span>"
                        <button @click="clearSearch()" class="ml-1 hover:text-red-500">&times;</button>
                    </span>
                </template>
                <template x-if="kategoriFilter">
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs">
                        <i class="fas fa-folder"></i> Kategori
                        <button @click="kategoriFilter = ''; applyFilters()" class="ml-1 hover:text-red-500">&times;</button>
                    </span>
                </template>
                <template x-if="currentSort !== 'namaBarang'">
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-purple-50 text-purple-700 rounded-lg text-xs">
                        <i class="fas fa-sort"></i> Sorted: <span x-text="getSortLabel()"></span>
                    </span>
                </template>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                    <tr>
                        {{-- KODE --}}
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider cursor-pointer hover:bg-slate-100 transition-colors"
                            @click="sortBy('kode_barang')">
                            <span class="flex items-center gap-2">
                                <span>Kode</span>
                                <span class="flex flex-col text-[10px] leading-3">
                                    <i class="fas fa-caret-up" :class="currentSort === 'kode_barang' && sortDirection === 'asc' ? 'text-emerald-600' : 'text-slate-300'"></i>
                                    <i class="fas fa-caret-down" :class="currentSort === 'kode_barang' && sortDirection === 'desc' ? 'text-emerald-600' : 'text-slate-300'"></i>
                                </span>
                            </span>
                        </th>

                        {{-- NAMA BARANG --}}
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider cursor-pointer hover:bg-slate-100 transition-colors"
                            @click="sortBy('namaBarang')">
                            <span class="flex items-center gap-2">
                                <span>Nama Barang</span>
                                <span class="flex flex-col text-[10px] leading-3">
                                    <i class="fas fa-caret-up" :class="currentSort === 'namaBarang' && sortDirection === 'asc' ? 'text-emerald-600' : 'text-slate-300'"></i>
                                    <i class="fas fa-caret-down" :class="currentSort === 'namaBarang' && sortDirection === 'desc' ? 'text-emerald-600' : 'text-slate-300'"></i>
                                </span>
                            </span>
                        </th>

                        {{-- KATEGORI --}}
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider cursor-pointer hover:bg-slate-100 transition-colors"
                            @click="sortBy('categoryID')">
                            <span class="flex items-center gap-2">
                                <span>Kategori</span>
                                <span class="flex flex-col text-[10px] leading-3">
                                    <i class="fas fa-caret-up" :class="currentSort === 'categoryID' && sortDirection === 'asc' ? 'text-emerald-600' : 'text-slate-300'"></i>
                                    <i class="fas fa-caret-down" :class="currentSort === 'categoryID' && sortDirection === 'desc' ? 'text-emerald-600' : 'text-slate-300'"></i>
                                </span>
                            </span>
                        </th>

                        {{-- STOK --}}
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider cursor-pointer hover:bg-slate-100 transition-colors"
                            @click="sortBy('stok')">
                            <span class="flex items-center gap-2">
                                <span>Stok</span>
                                <span class="flex flex-col text-[10px] leading-3">
                                    <i class="fas fa-caret-up" :class="currentSort === 'stok' && sortDirection === 'asc' ? 'text-emerald-600' : 'text-slate-300'"></i>
                                    <i class="fas fa-caret-down" :class="currentSort === 'stok' && sortDirection === 'desc' ? 'text-emerald-600' : 'text-slate-300'"></i>
                                </span>
                            </span>
                        </th>
                        
                        {{-- AKSI --}}
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-slate-50">
                    @forelse($barangs as $barang)
                    <tr class="hover:bg-emerald-50/50 transition duration-200 group">
                        <td class="px-6 py-4 text-sm font-medium text-slate-700">
                            <span class="font-mono bg-slate-100 px-2 py-1 rounded text-xs">{{ $barang->kode_barang }}</span>
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-700">
                            <div class="font-semibold group-hover:text-emerald-700 transition">{{ $barang->namaBarang }}</div>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs bg-slate-100 text-slate-700">
                                <i class="fas fa-folder text-slate-400 mr-1.5"></i>
                                {{ $barang->kategori->nama_kategori }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold 
                                {{ $barang->stok < 5 ? 'bg-red-50 text-red-600 border border-red-200' : ($barang->stok < 10 ? 'bg-yellow-50 text-yellow-600 border border-yellow-200' : 'bg-emerald-50 text-emerald-600 border border-emerald-200') }}">
                                <i class="fas fa-cubes mr-1.5"></i>
                                {{ $barang->stok }} {{ $barang->satuan }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 text-center">
                            <button 
                                type="button"
                                @click="openModal({!! htmlspecialchars(json_encode($barang), ENT_QUOTES, 'UTF-8') !!})"
                                class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-bold text-white transition-all duration-200 
                                       bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl 
                                       hover:from-emerald-600 hover:to-teal-600 hover:shadow-lg hover:shadow-emerald-200 
                                       active:scale-95 focus:outline-none"
                            >
                                <i class="fas fa-paper-plane mr-2 text-xs"></i> Ajukan
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <div class="h-16 w-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-box-open text-3xl text-slate-300"></i>
                                </div>
                                <p class="font-semibold text-slate-600">Tidak ada barang ditemukan</p>
                                <p class="text-sm mt-1">Coba ubah filter pencarian Anda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer dengan Pagination & Info --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-sm text-slate-500">
                Menampilkan <span class="font-semibold text-slate-700">{{ $barangs->firstItem() ?? 0 }}</span> - 
                <span class="font-semibold text-slate-700">{{ $barangs->lastItem() ?? 0 }}</span> dari 
                <span class="font-semibold text-slate-700">{{ $barangs->total() }}</span> barang
            </div>
            {{ $barangs->appends(request()->query())->links() }}
        </div>
    </div>


    {{-- ===================== MODAL FORM PENGAJUAN ===================== --}}
    <div 
        x-show="isModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
        role="dialog"
        aria-modal="true"
        style="display: none;"
    >
        {{-- Backdrop Blur --}}
        <div 
            x-show="isModalOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"
            @click="closeModal"
        ></div>

        {{-- Modal Content --}}
        <div 
            x-show="isModalOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:w-full sm:max-w-lg border border-slate-100"
        >
            {{-- Header Modal --}}
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-5">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-paper-plane text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Form Pengajuan</h3>
                            <p class="text-sm text-emerald-100">Ajukan permintaan barang</p>
                        </div>
                    </div>
                    <button @click="closeModal" class="text-white/70 hover:text-white transition text-xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            {{-- Body Modal --}}
            <div class="p-6">
                
                {{-- Info Barang Terpilih --}}
                <div class="mb-6 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-100">
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Barang Dipilih</p>
                    <h4 class="font-bold text-slate-800 text-lg" x-text="selectedBarang.namaBarang"></h4>
                    <p class="text-sm text-slate-500 mt-1">
                        <span class="font-mono bg-white px-2 py-0.5 rounded text-xs" x-text="selectedBarang.kode_barang"></span>
                    </p>
                </div>

                <form method="POST" action="{{ route('pegawai.permintaan.ajukan') }}">
                    @csrf

                    <input type="hidden" name="items[0][barangID]" x-bind:value="selectedBarang.barangID">

                    {{-- Stok Info (Readonly) --}}
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            <i class="fas fa-cubes text-emerald-500 mr-1"></i> Stok Tersedia
                        </label>
                        <input type="text" 
                            x-bind:value="selectedBarang.stok + ' ' + selectedBarang.satuan"
                            disabled 
                            class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-500 font-medium"
                        >
                    </div>

                    {{-- Jumlah --}}
                    <div class="mb-5">
                        <label for="jumlah" class="block text-sm font-bold text-slate-700 mb-2">
                            <i class="fas fa-sort-numeric-up text-emerald-500 mr-1"></i> Jumlah Diajukan
                        </label>
                        <input 
                            type="number" 
                            id="jumlah" 
                            name="items[0][jumlah]" 
                            x-model.number="formData.jumlah" 
                            min="1" 
                            x-bind:max="selectedBarang.stok"
                            @input="validateJumlah"
                            required
                            class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent px-4 py-3 transition-all"
                        >
                        <p class="text-xs text-slate-400 mt-1">Maksimal: <span x-text="selectedBarang.stok"></span> <span x-text="selectedBarang.satuan"></span></p>
                    </div>

                    {{-- Keperluan --}}
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            <i class="fas fa-clipboard text-emerald-500 mr-1"></i> Keperluan
                        </label>
                        <textarea 
                            id="keperluan" 
                            name="description" 
                            x-model="formData.keperluan" 
                            rows="3" 
                            required 
                            placeholder="Jelaskan keperluan Anda..."
                            class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent px-4 py-3 transition-all resize-none"
                        ></textarea>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="closeModal" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">
                            Batal
                        </button>
                        <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-emerald-200 transition-all flex items-center gap-2">
                            <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>

{{-- JAVASCRIPT ALPINE.JS --}}
<script>
function barangPage() {
    return {
        isModalOpen: false,
        selectedBarang: {},
        formData: {
            jumlah: 1,
            keperluan: "",
        },
        searchQuery: "{{ request('search', '') }}",
        kategoriFilter: "{{ request('kategori', '') }}",
        currentSort: "{{ request('sort', 'namaBarang') }}",
        sortDirection: "{{ request('direction', 'asc') }}",

        init() {
            // Initialize from URL params
        },

        openModal(barang) {
            this.selectedBarang = barang;
            this.formData.jumlah = 1;
            this.formData.keperluan = "";
            this.isModalOpen = true;
        },

        closeModal() {
            this.isModalOpen = false;
        },

        validateJumlah() {
            if (this.formData.jumlah > this.selectedBarang.stok) {
                this.formData.jumlah = this.selectedBarang.stok;
            }
            if (this.formData.jumlah < 1) {
                this.formData.jumlah = 1;
            }
        },

        sortBy(column) {
            if (this.currentSort === column) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.currentSort = column;
                this.sortDirection = 'asc';
            }
            this.applyFilters();
        },

        getSortLabel() {
            const labels = {
                'kode_barang': 'Kode',
                'namaBarang': 'Nama',
                'categoryID': 'Kategori',
                'stok': 'Stok'
            };
            return labels[this.currentSort] + ' (' + (this.sortDirection === 'asc' ? '↑' : '↓') + ')';
        },

        liveSearch() {
            this.applyFilters();
        },

        clearSearch() {
            this.searchQuery = '';
            this.applyFilters();
        },

        resetFilters() {
            this.searchQuery = '';
            this.kategoriFilter = '';
            this.currentSort = 'namaBarang';
            this.sortDirection = 'asc';
            this.applyFilters();
        },

        applyFilters() {
            const params = new URLSearchParams();
            if (this.searchQuery) params.set('search', this.searchQuery);
            if (this.kategoriFilter) params.set('kategori', this.kategoriFilter);
            if (this.currentSort) params.set('sort', this.currentSort);
            if (this.sortDirection) params.set('direction', this.sortDirection);
            
            window.location.href = "{{ route('pegawai.daftar-barang') }}?" + params.toString();
        }
    }
}
</script>
@endsection