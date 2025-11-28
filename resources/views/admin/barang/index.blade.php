@extends('layouts.admin')
@section('title', 'Data Barang')
@section('header', 'Data Barang')

@section('content')
<div class="flex justify-between items-start mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">
            Data Barang
        </h1>
        <p class="text-gray-500 text-sm mt-1">Kelola data master barang inventaris</p>
    </div>
    <a href="{{ route('admin.barang.create') }}" class="text-white bg-gray-900 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-6 py-3 flex items-center gap-2 whitespace-nowrap h-fit">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4a1 1 0 011 1v6h6a1 1 0 110 2h-6v6a1 1 0 11-2 0v-6H5a1 1 0 110-2h6V5a1 1 0 011-1z"/></svg>
        Tambah Barang Baru
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="flex items-center p-6 bg-white border border-gray-200 rounded-lg shadow">
        <div class="flex-1">
            <p class="font-normal text-gray-700">Total Barang</p>
            <h5 class="text-2xl font-bold tracking-tight text-gray-900">{{ $totalBarang }}</h5>
        </div>
    </div>
    <div class="flex items-center p-6 bg-white border border-gray-200 rounded-lg shadow">
        <div class="flex-1">
            <p class="font-normal text-gray-700">Kategori</p>
            <h5 class="text-2xl font-bold tracking-tight text-gray-900">{{ $totalKategori }}</h5>
        </div>
    </div>
    <div class="flex items-center p-6 bg-white border border-red-200 rounded-lg shadow">
        <div class="flex-1">
            <p class="font-normal text-gray-700">Barang Habis</p>
            <h5 class="text-2xl font-bold tracking-tight text-red-700">{{ $barangHabis }}</h5>
        </div>
    </div>
    <div class="flex items-center p-6 bg-white border border-yellow-200 rounded-lg shadow">
        <div class="flex-1">
            <p class="font-normal text-gray-700">Stok Rendah</p>
            <h5 class="text-2xl font-bold tracking-tight text-yellow-700">{{ $stokRendah }}</h5>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Barang</h3>
    <div class="flex gap-3 mb-6">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="search" id="searchInput" placeholder="Cari berdasarkan nama atau kode barang..." class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <select id="categoryFilter" class="bg-white text-gray-700 py-3 px-4 rounded-lg text-sm border border-gray-300 hover:border-gray-400 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Semua Kategori</option>
            @foreach ($kategoriList ?? [] as $kategori)
                <option value="{{ $kategori->kategoriID }}">{{ $kategori->nama_kategori }}</option>
            @endforeach
        </select>
    </div>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Kode Barang</th>
                    <th scope="col" class="px-6 py-3">Nama Barang</th>
                    <th scope="col" class="px-6 py-3">Kategori</th>
                    <th scope="col" class="px-6 py-3">Satuan</th>
                    <th scope="col" class="px-6 py-3">Stok</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody id="barangTableBody">
                @forelse ($barangs as $barang)
                    <tr class="bg-white border-b" data-nama="{{ strtolower($barang->nama_barang) }}" data-kode="{{ strtolower($barang->kode_barang ?? '') }}" data-kategori="{{ $barang->kategoriID }}">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $barang->kode_barang }}</td>
                        <td class="px-6 py-4">{{ $barang->nama_barang }}</td>
                        <td class="px-6 py-4">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $barang->satuan }}</td>
                        <td class="px-6 py-4">{{ $barang->stok ?? 0 }}</td>
                        <td class="px-6 py-4">
                            @if ($barang->stok == 0)
                                <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Habis</span>
                            @elseif ($barang->stok < 10)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Sedikit</span>
                            @else
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Tersedia</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('admin.barang.edit', $barang->barangID) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.barang.destroy', $barang->barangID) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b">
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data barang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
// Search and filter functionality
const searchInput = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const tableBody = document.getElementById('barangTableBody');

function filterTable() {
    const searchTerm = searchInput.value.toLowerCase().trim();
    const selectedCategory = categoryFilter.value;
    const rows = tableBody.querySelectorAll('tr');

    rows.forEach(row => {
        const namaMatch = row.getAttribute('data-nama').includes(searchTerm) || row.getAttribute('data-kode').includes(searchTerm);
        const categoryMatch = selectedCategory === '' || row.getAttribute('data-kategori') === selectedCategory;
        
        if (namaMatch && categoryMatch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

searchInput.addEventListener('keyup', filterTable);
categoryFilter.addEventListener('change', filterTable);
</script>
@endsection
