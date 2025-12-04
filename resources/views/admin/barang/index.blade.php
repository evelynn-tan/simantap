@extends('layouts.admin')
@section('title', 'Data Barang - SIMANTAP')
@section('header', 'Data Barang')
@section('subtitle', 'Kelola master data barang inventaris')

@section('content')
<div x-data="barangPage()" x-init="init()" class="space-y-6" style="font-family: 'Poppins', sans-serif;">

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow-sm border border-blue-200 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-semibold uppercase">Total Barang</p>
                    <p class="text-3xl font-bold text-blue-900 mt-1">{{ $totalBarang }}</p>
                </div>
                <div class="h-12 w-12 bg-blue-200 rounded-lg flex items-center justify-center">
                    <i class="fas fa-boxes text-2xl text-blue-700"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl shadow-sm border border-green-200 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-semibold uppercase">Kategori</p>
                    <p class="text-3xl font-bold text-green-900 mt-1">{{ $totalKategori }}</p>
                </div>
                <div class="h-12 w-12 bg-green-200 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list text-2xl text-green-700"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl shadow-sm border border-red-200 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-600 text-sm font-semibold uppercase">Habis</p>
                    <p class="text-3xl font-bold text-red-900 mt-1">{{ $barangHabis }}</p>
                </div>
                <div class="h-12 w-12 bg-red-200 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation text-2xl text-red-700"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-xl shadow-sm border border-yellow-200 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-600 text-sm font-semibold uppercase">Stok Rendah</p>
                    <p class="text-3xl font-bold text-yellow-900 mt-1">{{ $stokRendah }}</p>
                </div>
                <div class="h-12 w-12 bg-yellow-200 rounded-lg flex items-center justify-center">
                    <i class="fas fa-warning text-2xl text-yellow-700"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Barang -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-start sm:items-center flex-col sm:flex-row gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800">📦 Daftar Barang</h3>
                <p class="text-sm text-slate-500 mt-1">Kelola semua barang di sistem</p>
            </div>
            <a href="{{ route('admin.barang.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white hover:bg-blue-700 rounded-lg font-semibold text-sm transition duration-200 whitespace-nowrap">
                <i class="fas fa-plus mr-2"></i> Tambah Barang
            </a>
        </div>

        <!-- Filter & Search -->
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-3 top-3 text-slate-400"></i>
                    <input 
                        type="search" 
                        id="searchInput" 
                        x-model="searchTerm"
                        @input="filterTable()"
                        placeholder="Cari nama atau kode barang..." 
                        class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    >
                </div>
                <select 
                    id="categoryFilter"
                    x-model="selectedCategory"
                    @change="filterTable()"
                    class="px-4 py-2.5 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white text-slate-700"
                >
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList ?? [] as $kategori)
                        <option value="{{ $kategori->kategoriID }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Nama Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Satuan</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Stok</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody id="barangTableBody" class="divide-y divide-slate-200">
                    @forelse ($barangs as $barang)
                    <tr class="hover:bg-slate-50 transition barang-row" 
                        data-nama="{{ strtolower($barang->nama_barang) }}" 
                        data-kode="{{ strtolower($barang->kode_barang ?? '') }}" 
                        data-kategori="{{ $barang->kategoriID }}"
                        data-barang-json="{{ htmlspecialchars(json_encode($barang), ENT_QUOTES, 'UTF-8') }}"
                    >
                        <td class="px-6 py-4 font-mono font-bold text-slate-800">{{ $barang->kode_barang }}</td>
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $barang->nama_barang }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ ucfirst($barang->satuan) }}</td>
                        <td class="px-6 py-4 text-center font-bold text-slate-800">{{ $barang->stok ?? 0 }}</td>
                        <td class="px-6 py-4 text-center">
                            @if ($barang->status === 'habis')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i> Habis
                                </span>
                            @elseif ($barang->status === 'rendah')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-exclamation-circle mr-1"></i> Rendah
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Tersedia
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex gap-2 justify-center">
                                <button 
                                    @click="openEditModal({!! json_encode($barang) !!})"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-sm font-semibold transition duration-200"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button 
                                    @click="openDeleteModal({!! json_encode($barang) !!})"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-semibold transition duration-200"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-box-open text-4xl mb-3 opacity-50"></i>
                            <p class="font-medium">Belum ada data barang</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ============ MODAL EDIT ============ -->
    <div 
        x-show="isEditModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="isEditModalOpen = false"></div>
        
        <div class="relative bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-2xl">
            <div class="flex justify-between items-center px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-800">✏️ Edit Barang</h3>
                <button @click="isEditModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form method="POST" :action="`/admin/barang/${selectedBarang.barangID}`" @submit.prevent="submitEdit">
                @csrf
                @method('PUT')
                <div class="px-6 py-5 space-y-4 max-h-96 overflow-y-auto">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Barang</label>
                            <input type="text" x-model="selectedBarang.kode_barang" disabled class="block w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-slate-600" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori *</label>
                            <select name="kategori_id" x-model="selectedBarang.kategoriID" required class="block w-full border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @foreach ($kategoriList ?? [] as $kategori)
                                    <option value="{{ $kategori->kategoriID }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang *</label>
                        <input type="text" name="nama_barang" x-model="selectedBarang.nama_barang" required class="block w-full border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Satuan *</label>
                            <select name="satuan" x-model="selectedBarang.satuan" required class="block w-full border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="rim">Rim</option>
                                <option value="pcs">PCS</option>
                                <option value="buah">Buah</option>
                                <option value="box">Box</option>
                                <option value="pack">Pack</option>
                                <option value="set">Set</option>
                                <option value="lembar">Lembar</option>
                                <option value="meter">Meter</option>
                                <option value="kg">Kg</option>
                                <option value="liter">Liter</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Stok *</label>
                            <input type="number" name="stok" x-model="selectedBarang.stok" min="0" required class="block w-full border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" x-model="selectedBarang.deskripsi" rows="2" class="block w-full border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-200 flex gap-3 justify-end">
                    <button type="button" @click="isEditModalOpen = false" class="px-4 py-2 text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============ MODAL HAPUS ============ -->
    <div 
        x-show="isDeleteModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="isDeleteModalOpen = false"></div>
        
        <div class="relative bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-md">
            <div class="p-6 text-center">
                <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trash-alt text-2xl text-red-600"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus Barang?</h3>
                <p class="text-slate-600 text-sm mb-4">
                    Apakah Anda yakin ingin menghapus barang <strong x-text="selectedBarang.nama_barang"></strong>? 
                </p>
                <p class="text-xs text-slate-500 mb-6 bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                    ⚠️ Barang tidak dapat dihapus jika sudah digunakan dalam permintaan atau transaksi
                </p>
            </div>

            <form method="POST" :action="`/admin/barang/${selectedBarang.barangID}`" @submit.prevent="submitDelete">
                @csrf
                @method('DELETE')
                <div class="px-6 py-4 border-t border-slate-200 flex gap-3 justify-end">
                    <button type="button" @click="isDeleteModalOpen = false" class="px-4 py-2 text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg font-semibold transition">
                        Hapus Barang
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function barangPage() {
    return {
        isEditModalOpen: false,
        isDeleteModalOpen: false,
        selectedBarang: {},
        searchTerm: '',
        selectedCategory: '',

        init() {},

        filterTable() {
            const rows = document.querySelectorAll('.barang-row');
            rows.forEach(row => {
                const nama = row.dataset.nama;
                const kode = row.dataset.kode;
                const kategori = row.dataset.kategori;
                
                const matchSearch = nama.includes(this.searchTerm.toLowerCase()) || kode.includes(this.searchTerm.toLowerCase());
                const matchCategory = this.selectedCategory === '' || kategori === this.selectedCategory;
                
                row.style.display = matchSearch && matchCategory ? '' : 'none';
            });
        },

        openEditModal(barang) {
            this.selectedBarang = barang;
            this.isEditModalOpen = true;
        },

        openDeleteModal(barang) {
            this.selectedBarang = barang;
            this.isDeleteModalOpen = true;
        },

        submitEdit() {
            this.$el.querySelector('form').submit();
        },

        submitDelete() {
            this.$el.querySelector('form').submit();
        }
    }
}
</script>

@endsection
