<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sesi Stock Opname
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.stock-opname.store') }}" method="POST">
                @csrf
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4">Daftar Stock Opname</h3>
                    <p class="text-sm text-gray-600 mb-4">Input jumlah fisik untuk setiap barang. Sistem akan otomatis menghitung selisih.</p>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Kode Barang</th>
                                    <th scope="col" class="px-6 py-3">Nama Barang</th>
                                    <th scope="col" class="px-6 py-3">Kategori</th>
                                    <th scope="col" class="px-6 py-3">Stok Sistem</th>
                                    <th scope="col" class="px-6 py-3">Jumlah Fisik</th>
                                    <th scope="col" class="px-6 py-3">Selisih</th>
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
                                            <input type="number" name="stok_fisik[{{ $barang->id }}]" 
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 p-2.5" 
                                                   value="0" required>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500 italic">
                                            (Belum diisi)
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b">
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada data barang untuk di-opname.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-end gap-4">
                        <a href="{{ route('admin.stock-opname.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Batal Opname</a>
                        <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">Simpan & Sesuaikan Stok</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>