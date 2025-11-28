@extends('layouts.pegawai-layout')

@section('title', 'Daftar Barang Tersedia - SIMANTAP')
@section('page-title', 'Daftar Barang Tersedia')
@section('page-subtitle', 'Lihat dan ajukan permintaan untuk barang yang tersedia')

@section('content')
<div x-data="barangPage()" x-init="init()">

    {{-- Card utama --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
        
        {{-- Form Filter --}}
        <form method="GET" action="{{ route('pegawai.daftar-barang') }}">
            <input type="hidden" name="sort" value="{{ request('sort') }}">
            <input type="hidden" name="direction" value="{{ request('direction') }}">

            <div class="px-6 py-5 border-b border-slate-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Daftar Barang Tersedia</h3>
                        <p class="text-sm text-slate-500">Lihat dan ajukan permintaan untuk barang yang tersedia</p>
                    </div>

                    <div class="flex items-center gap-3">
                        {{-- Search --}}
                        <div class="relative">
                            <input 
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari barang..."
                                class="pl-10 pr-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent w-64 text-sm"
                            >
                            <i class="fas fa-search absolute left-3 top-3 text-slate-400 text-xs"></i>
                        </div>

                        {{-- Kategori --}}
                        <select 
                            name="kategori"
                            class="px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm text-slate-600 cursor-pointer"
                        >
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option 
                                    value="{{ $kategori->kategoriID }}"
                                    {{ request('kategori') == $kategori->kategoriID ? 'selected' : '' }}
                                >
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Tombol filter --}}
                        <button type="submit" class="bg-emerald-600 text-white px-5 py-2 rounded-xl hover:bg-emerald-700 text-sm font-semibold transition-colors shadow-sm">
                            Cari
                        </button>

                        <a href="{{ route('pegawai.daftar-barang') }}" class="text-sm text-slate-500 hover:text-red-500 transition-colors" title="Reset Filter">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                    <tr>
                        {{-- KODE --}}
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider cursor-pointer hover:bg-slate-100 transition-colors group">
                            <a href="{{ route('pegawai.daftar-barang', array_merge(request()->query(), ['sort' => 'kode_barang', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-2">
                                <span>Kode</span>
                                <span class="flex flex-col text-[10px] leading-3 text-slate-300">
                                    <i class="fas fa-caret-up {{ request('sort') == 'kode_barang' && request('direction') == 'asc' ? 'text-emerald-600' : '' }}"></i>
                                    <i class="fas fa-caret-down {{ request('sort') == 'kode_barang' && request('direction') == 'desc' ? 'text-emerald-600' : '' }}"></i>
                                </span>
                            </a>
                        </th>

                        {{-- NAMA BARANG --}}
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider cursor-pointer hover:bg-slate-100 transition-colors group">
                            <a href="{{ route('pegawai.daftar-barang', array_merge(request()->query(), ['sort' => 'nama_barang', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-2">
                                <span>Nama Barang</span>
                                <span class="flex flex-col text-[10px] leading-3 text-slate-300">
                                    <i class="fas fa-caret-up {{ request('sort') == 'nama_barang' && request('direction') == 'asc' ? 'text-emerald-600' : '' }}"></i>
                                    <i class="fas fa-caret-down {{ request('sort') == 'nama_barang' && request('direction') == 'desc' ? 'text-emerald-600' : '' }}"></i>
                                </span>
                            </a>
                        </th>

                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">Stok</th>
                        
                        {{-- HEADER AKSI: Diubah jadi text-center (Tengah) --}}
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-slate-50">
                    @forelse($barangs as $barang)
                    <tr class="hover:bg-slate-50/80 transition duration-200">
                        <td class="px-6 py-4 text-sm font-medium text-slate-700 font-mono">
                            {{ $barang->kode_barang }}
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-700 font-semibold">
                            {{ $barang->nama_barang }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs bg-white-100 text-black-800">
                                {{ $barang->kategori->nama_kategori }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                                {{ $barang->stok_sekarang < 5 ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                {{ $barang->stok_sekarang }} {{ $barang->satuan }}
                            </span>
                        </td>
                        
                        {{-- BODY AKSI: Diubah jadi text-center (Tengah) --}}
                        <td class="px-6 py-4 text-center">
                            <button 
                                type="button"
                                @click="openModal({!! htmlspecialchars(json_encode($barang), ENT_QUOTES, 'UTF-8') !!})"
                                class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white transition-all duration-200 
                                       bg-emerald-600 rounded-xl 
                                       hover:bg-emerald-700 hover:shadow-lg hover:shadow-emerald-200 
                                       active:scale-95 focus:outline-none"
                            >
                                <i class="fas fa-paper-plane mr-2 text-xs"></i> Ajukan Permintaan
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-box-open text-4xl mb-3 opacity-50"></i>
                            <p class="font-medium">Tidak ada barang ditemukan</p>
                            <p class="text-xs mt-1">Coba ubah filter pencarian Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-end">
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
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"
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
            <div class="flex justify-between items-center px-8 py-5 border-b border-slate-100">
                <h3 class="text-xl font-bold text-slate-800">
                    Form Pengajuan
                </h3>
                <button @click="closeModal" class="text-slate-400 hover:text-red-500 transition-colors text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Body Modal --}}
            <div class="p-8">
                
                {{-- Info Barang Terpilih --}}
                <div class="mb-6 p-4 bg-white rounded-xl border border-slate-200 flex items-center gap-4">
                    <div>
                        <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Barang Dipilih</p>
                        <h4 class="font-bold text-slate-800 text-lg" x-text="selectedBarang.nama_barang"></h4>
                    </div>
                </div>

                <form method="POST" action="{{ route('pegawai.permintaan.ajukan') }}">
                    @csrf

                    <input type="hidden" name="items[0][barangID]" x-bind:value="selectedBarang.barangID">

                    {{-- Nama Barang (Hidden) --}}
                    <div class="hidden">
                        <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                        <input type="text" x-bind:value="selectedBarang.nama_barang" disabled 
                            class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm">
                    </div>

                    {{-- Stok Info (Readonly) --}}
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Stok Tersedia</label>
                        <input type="text" 
                            x-bind:value="selectedBarang.stok_sekarang + ' ' + selectedBarang.satuan"
                            disabled 
                            class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-500 font-medium"
                        >
                    </div>

                    {{-- Jumlah --}}
                    <div class="mb-5">
                        <label for="jumlah" class="block text-sm font-bold text-slate-700 mb-2">Jumlah Diajukan</label>
                        <input 
                            type="number" 
                            id="jumlah" 
                            name="items[0][jumlah]" 
                            x-model.number="formData.jumlah" 
                            min="1" 
                            x-bind:max="selectedBarang.stok_sekarang"
                            @input="validateJumlah"
                            required
                            class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all"
                        >
                    </div>

                    {{-- Keperluan --}}
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Keperluan</label>
                        <textarea 
                            id="keperluan" 
                            name="description" 
                            x-model="formData.keperluan" 
                            rows="3" 
                            required 
                            placeholder="Jelaskan keperluan Anda..."
                            class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all resize-none"
                        ></textarea>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end space-x-3 pt-2">
                        <button type="button" @click="closeModal" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold px-6 py-2.5 rounded-xl transition-all">
                            Batal
                        </button>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-md hover:shadow-emerald-200 transition-all">
                            Kirim Pengajuan
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

        init() {},

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
            if (this.formData.jumlah > this.selectedBarang.stok_sekarang) {
                this.formData.jumlah = this.selectedBarang.stok_sekarang;
            }
            if (this.formData.jumlah < 1) {
                this.formData.jumlah = 1;
            }
        }
    }
}
</script>
@endsection