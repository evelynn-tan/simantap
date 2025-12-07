@extends('layouts.admin')
@section('title', 'Data Barang - SIMANTAP')
@section('header', 'Data Barang')
@section('subtitle', 'Kelola master data barang inventaris')

@section('content')
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

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
                <p class="text-sm text-slate-500 mt-1">Kelola semua barang di sistem • <span class="text-blue-600">Klik header kolom untuk mengurutkan</span></p>
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
                        oninput="filterTable()"
                        placeholder="Cari nama atau kode barang..." 
                        class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    >
                </div>
                <select 
                    id="categoryFilter"
                    onchange="filterTable()"
                    class="px-4 py-2.5 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white text-slate-700"
                >
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList ?? [] as $kategori)
                        <option value="{{ $kategori->categoryID }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
                <select 
                    id="statusFilter"
                    onchange="filterTable()"
                    class="px-4 py-2.5 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white text-slate-700"
                >
                    <option value="">Semua Status</option>
                    <option value="tersedia">Tersedia</option>
                    <option value="rendah">Stok Rendah</option>
                    <option value="habis">Habis</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="barangTable">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase cursor-pointer hover:bg-slate-100 transition select-none" 
                            onclick="sortTable(0, 'string')" data-sort-dir="none">
                            <div class="flex items-center gap-2">
                                Kode
                                <span class="sort-icon text-slate-400"><i class="fas fa-sort"></i></span>
                            </div>
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase cursor-pointer hover:bg-slate-100 transition select-none" 
                            onclick="sortTable(1, 'string')" data-sort-dir="none">
                            <div class="flex items-center gap-2">
                                Nama Barang
                                <span class="sort-icon text-slate-400"><i class="fas fa-sort"></i></span>
                            </div>
                        </th>
                        <th class="hidden sm:table-cell px-4 sm:px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase cursor-pointer hover:bg-slate-100 transition select-none" 
                            onclick="sortTable(2, 'string')" data-sort-dir="none">
                            <div class="flex items-center gap-2">
                                Kategori
                                <span class="sort-icon text-slate-400"><i class="fas fa-sort"></i></span>
                            </div>
                        </th>
                        <th class="hidden md:table-cell px-4 sm:px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase cursor-pointer hover:bg-slate-100 transition select-none" 
                            onclick="sortTable(3, 'string')" data-sort-dir="none">
                            <div class="flex items-center gap-2">
                                Satuan
                                <span class="sort-icon text-slate-400"><i class="fas fa-sort"></i></span>
                            </div>
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase cursor-pointer hover:bg-slate-100 transition select-none" 
                            onclick="sortTable(4, 'number')" data-sort-dir="none">
                            <div class="flex items-center justify-center gap-2">
                                Stok
                                <span class="sort-icon text-slate-400"><i class="fas fa-sort"></i></span>
                            </div>
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase cursor-pointer hover:bg-slate-100 transition select-none" 
                            onclick="sortTable(5, 'status')" data-sort-dir="none">
                            <div class="flex items-center justify-center gap-2">
                                Status
                                <span class="sort-icon text-slate-400"><i class="fas fa-sort"></i></span>
                            </div>
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody id="barangTableBody" class="divide-y divide-slate-200">
                    @forelse ($barangs as $barang)
                    <tr class="hover:bg-slate-50 transition barang-row" 
                        data-nama="{{ strtolower($barang->namaBarang) }}" 
                        data-kode="{{ strtolower($barang->kode_barang ?? '') }}" 
                        data-kategori="{{ $barang->categoryID }}"
                        data-status="{{ $barang->status }}"
                    >
                        <td class="px-4 sm:px-6 py-4 font-mono font-bold text-slate-800 text-sm">{{ $barang->kode_barang }}</td>
                        <td class="px-4 sm:px-6 py-4 font-medium text-slate-800">{{ $barang->namaBarang }}</td>
                        <td class="hidden sm:table-cell px-4 sm:px-6 py-4 text-slate-700">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td class="hidden md:table-cell px-4 sm:px-6 py-4 text-slate-700">{{ ucfirst($barang->satuan) }}</td>
                        <td class="px-4 sm:px-6 py-4 text-center font-bold text-slate-800" data-value="{{ $barang->stok ?? 0 }}">{{ $barang->stok ?? 0 }}</td>
                        <td class="px-4 sm:px-6 py-4 text-center" data-value="{{ $barang->status }}">
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
                                    type="button"
                                    onclick="openEditModal({{ $barang->barangID }}, '{{ $barang->kode_barang }}', '{{ addslashes($barang->namaBarang) }}', {{ $barang->categoryID }}, '{{ $barang->satuan }}', {{ $barang->stok }}, '{{ addslashes($barang->deskripsi ?? '') }}')"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-sm font-semibold transition duration-200 cursor-pointer"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button 
                                    type="button"
                                    onclick="openDeleteModal({{ $barang->barangID }}, '{{ addslashes($barang->namaBarang) }}')"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-semibold transition duration-200 cursor-pointer"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-box-open text-4xl mb-3 opacity-50"></i>
                            <p class="font-medium">Belum ada data barang</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Info -->
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex justify-between items-center text-sm text-slate-600">
            <span id="tableInfo">Menampilkan <strong>{{ $totalBarang }}</strong> barang</span>
            <div id="sortInfo" class="text-slate-500 text-xs"></div>
        </div>
    </div>

    <!-- ============ MODAL EDIT ============ -->
    <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeEditModal()"></div>
        
        <div class="relative bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-2xl">
            <div class="flex justify-between items-center px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-800">✏️ Edit Barang</h3>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="editBarangForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="px-6 py-5 space-y-4 max-h-96 overflow-y-auto">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Barang</label>
                            <input type="text" id="edit_kode_barang" disabled class="block w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-slate-600" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori *</label>
                            <select name="kategori_id" id="edit_kategori_id" required class="block w-full border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @foreach ($kategoriList ?? [] as $kategori)
                                    <option value="{{ $kategori->categoryID }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang *</label>
                        <input type="text" name="namaBarang" id="edit_namaBarang" required class="block w-full border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Satuan *</label>
                            <select name="satuan" id="edit_satuan" required class="block w-full border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                            <input type="number" name="stok" id="edit_stok" min="0" required class="block w-full border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" rows="2" class="block w-full border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-200 flex gap-3 justify-end">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg font-semibold transition">
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
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        
        <div class="relative bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-md">
            <div class="p-6 text-center">
                <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trash-alt text-2xl text-red-600"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus Barang?</h3>
                <p class="text-slate-600 text-sm mb-4">
                    Apakah Anda yakin ingin menghapus barang <strong id="delete_namaBarang"></strong>? 
                </p>
                <p class="text-xs text-slate-500 mb-6 bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                    ⚠️ Barang tidak dapat dihapus jika sudah digunakan dalam permintaan atau transaksi
                </p>
            </div>

            <form id="deleteBarangForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="px-6 py-4 border-t border-slate-200 flex gap-3 justify-end">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg font-semibold transition">
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
// Current sort state
let currentSortColumn = -1;
let currentSortDir = 'none';

// Sort Table Function
function sortTable(columnIndex, type) {
    const table = document.getElementById('barangTable');
    const tbody = document.getElementById('barangTableBody');
    const rows = Array.from(tbody.querySelectorAll('tr.barang-row'));
    const headers = table.querySelectorAll('thead th');
    
    // Determine sort direction
    const header = headers[columnIndex];
    const prevDir = header.getAttribute('data-sort-dir');
    let newDir = 'asc';
    
    if (prevDir === 'asc') {
        newDir = 'desc';
    } else if (prevDir === 'desc') {
        newDir = 'none';
    }
    
    // Reset all headers
    headers.forEach((th, idx) => {
        if (idx < headers.length - 1) { // Skip Aksi column
            th.setAttribute('data-sort-dir', 'none');
            const icon = th.querySelector('.sort-icon');
            if (icon) {
                icon.innerHTML = '<i class="fas fa-sort"></i>';
                icon.className = 'sort-icon text-slate-400';
            }
        }
    });
    
    // Update current header
    header.setAttribute('data-sort-dir', newDir);
    const sortIcon = header.querySelector('.sort-icon');
    
    if (newDir === 'asc') {
        sortIcon.innerHTML = '<i class="fas fa-sort-up"></i>';
        sortIcon.className = 'sort-icon text-blue-600';
    } else if (newDir === 'desc') {
        sortIcon.innerHTML = '<i class="fas fa-sort-down"></i>';
        sortIcon.className = 'sort-icon text-blue-600';
    } else {
        sortIcon.innerHTML = '<i class="fas fa-sort"></i>';
        sortIcon.className = 'sort-icon text-slate-400';
    }
    
    // Update sort info
    const sortInfo = document.getElementById('sortInfo');
    const columnNames = ['Kode', 'Nama Barang', 'Kategori', 'Satuan', 'Stok', 'Status'];
    if (newDir !== 'none') {
        sortInfo.textContent = `Diurutkan: ${columnNames[columnIndex]} (${newDir === 'asc' ? 'A-Z ↑' : 'Z-A ↓'})`;
    } else {
        sortInfo.textContent = '';
    }
    
    // Sort rows
    if (newDir !== 'none') {
        rows.sort((a, b) => {
            let aVal, bVal;
            
            if (type === 'number') {
                aVal = parseFloat(a.cells[columnIndex].getAttribute('data-value') || a.cells[columnIndex].textContent) || 0;
                bVal = parseFloat(b.cells[columnIndex].getAttribute('data-value') || b.cells[columnIndex].textContent) || 0;
            } else if (type === 'status') {
                // Custom order: tersedia > rendah > habis
                const statusOrder = { 'tersedia': 1, 'rendah': 2, 'habis': 3 };
                aVal = statusOrder[a.cells[columnIndex].getAttribute('data-value')] || 0;
                bVal = statusOrder[b.cells[columnIndex].getAttribute('data-value')] || 0;
            } else {
                aVal = a.cells[columnIndex].textContent.trim().toLowerCase();
                bVal = b.cells[columnIndex].textContent.trim().toLowerCase();
            }
            
            if (type === 'number' || type === 'status') {
                return newDir === 'asc' ? aVal - bVal : bVal - aVal;
            } else {
                if (aVal < bVal) return newDir === 'asc' ? -1 : 1;
                if (aVal > bVal) return newDir === 'asc' ? 1 : -1;
                return 0;
            }
        });
        
        // Re-append sorted rows
        rows.forEach(row => tbody.appendChild(row));
    }
    
    currentSortColumn = columnIndex;
    currentSortDir = newDir;
}

// Filter Table Function
function filterTable() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const selectedCategory = document.getElementById('categoryFilter').value;
    const selectedStatus = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('.barang-row');
    
    let visibleCount = 0;
    
    rows.forEach(row => {
        const nama = row.dataset.nama;
        const kode = row.dataset.kode;
        const kategori = row.dataset.kategori;
        const status = row.dataset.status;
        
        const matchSearch = nama.includes(searchTerm) || kode.includes(searchTerm);
        const matchCategory = selectedCategory === '' || kategori === selectedCategory;
        const matchStatus = selectedStatus === '' || status === selectedStatus;
        
        if (matchSearch && matchCategory && matchStatus) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update table info
    document.getElementById('tableInfo').innerHTML = `Menampilkan <strong>${visibleCount}</strong> dari <strong>{{ $totalBarang }}</strong> barang`;
}

// Edit Modal Functions
function openEditModal(barangID, kodeBarang, namaBarang, categoryID, satuan, stok, deskripsi) {
    document.getElementById('editBarangForm').action = '/admin/barang/' + barangID;
    document.getElementById('edit_kode_barang').value = kodeBarang;
    document.getElementById('edit_namaBarang').value = namaBarang;
    document.getElementById('edit_kategori_id').value = categoryID;
    document.getElementById('edit_satuan').value = satuan;
    document.getElementById('edit_stok').value = stok;
    document.getElementById('edit_deskripsi').value = deskripsi;
    
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}

// Delete Modal Functions
function openDeleteModal(barangID, namaBarang) {
    document.getElementById('deleteBarangForm').action = '/admin/barang/' + barangID;
    document.getElementById('delete_namaBarang').textContent = namaBarang;
    
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}
</script>

@endsection
