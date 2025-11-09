<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Barang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $totalBarang }}</h5>
                    <p class="font-normal text-gray-700">Total Barang</p>
                </div>
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $totalKategori }}</h5>
                    <p class="font-normal text-gray-700">Kategori</p>
                </div>
                <div class="block p-6 bg-white border border-red-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-red-700">{{ $barangHabis }}</h5>
                    <p class="font-normal text-gray-700">Barang Habis</p>
                </div>
                <div class="block p-6 bg-white border border-yellow-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-yellow-700">{{ $stokRendah }}</h5>
                    <p class="font-normal text-gray-700">Stok Rendah</p>
                </div>
            </div>

            <div class="flex justify-between items-center mb-4">
                <div class="w-1/2">
                    <form>
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Cari...</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="search" id="default-search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari berdasarkan nama atau kode barang...">
                        </div>
                    </form>
                </div>
                <a href="{{ route('admin.barang.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    + Tambah Barang Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Kode Barang</th>
                                <th scope="col" class="px-6 py-3">Nama Barang</th>
                                <th scope="col" class="px-6 py-3">Kategori</th>
                                <th scope="col" class="px-6 py-3">Stok</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangs as $barang)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $barang->kode_barang }}</th>
                                    <td class="px-6 py-4">{{ $barang->nama_barang }}</td>
                                    <td class="px-6 py-4">{{ $barang->kategori->nama_kategori }}</td>
                                    <td class="px-6 py-4">{{ $barang->stok }} {{ $barang->satuan }}</td>
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
                                        <a href="{{ route('admin.barang.edit', $barang->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b">
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data barang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>