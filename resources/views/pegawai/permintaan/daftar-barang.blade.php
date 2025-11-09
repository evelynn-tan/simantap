<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Barang Tersedia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Tombol Ajukan Permintaan -->
            <div class="mb-4 flex justify-end">
                <a href="{{ route('pegawai.permintaan.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    + Ajukan Permintaan Barang
                </a>
            </div>

            <!-- Filter & Pencarian -->
            <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                <form action="{{ route('pegawai.barang.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <input type="search" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Cari berdasarkan nama atau kode barang...">
                        </div>
                        <div>
                            <!-- Anda bisa tambahkan filter kategori di sini nanti -->
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabel Daftar Barang -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Kode</th>
                                <th scope="col" class="px-6 py-3">Nama Barang</th>
                                <th scope="col" class="px-6 py-3">Kategori</th>
                                <th scope="col" class="px-6 py-3">Stok</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangs as $barang)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">{{ $barang->kode_barang }}</td>
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
                                </tr>
                            @empty
                                <tr class="bg-white border-b">
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada barang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $barangs->links() }} <!-- Ini untuk pagination -->
                </div>
            </div>

        </div>
    </div>
</x-app-layout>