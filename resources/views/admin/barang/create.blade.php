<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Data Barang Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                    <span class="font-medium">Oops! Ada kesalahan:</span>
                    <ul class="mt-1.5 ml-4 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.barang.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
                @csrf
                <h3 class="text-lg font-semibold mb-6">Form Tambah Barang</h3>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="kode_barang" class="block mb-2 text-sm font-medium text-gray-900">Kode Barang *</label>
                        <input type="text" name="kode_barang" id="kode_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: ATK001" value="{{ old('kode_barang') }}" required>
                    </div>
                    <div>
                        <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-900">Nama Barang *</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: Laptop Dell Inspiron 15" value="{{ old('nama_barang') }}" required>
                    </div>
                    <div>
                        <label for="kategori_id" class="block mb-2 text-sm font-medium text-gray-900">Kategori *</label>
                        <select id="kategori_id" name="kategori_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Pilih kategori barang</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @if(old('kategori_id') == $kategori->id) selected @endif>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="satuan" class="block mb-2 text-sm font-medium text-gray-900">Satuan *</label>
                        <input type="text" name="satuan" id="satuan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: Unit, Rim, Box" value="{{ old('satuan') }}" required>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="stok_awal" class="block mb-2 text-sm font-medium text-gray-900">Stok Awal *</label>
                    <input type="number" name="stok_awal" id="stok_awal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ old('stok_awal', 0) }}" required>
                </div>
                
                <div class="mt-6">
                    <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi (Opsional)</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi tambahan tentang barang...">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mt-6 flex gap-4">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Data</button>
                    <button type="reset" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Reset Form</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>