@extends('layouts.admin')

@section('header', 'Edit Data Barang')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <p class="text-gray-600">{{ $barang->namaBarang }}</p>
    </div>

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

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.barang.update', $barang->barangID) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="kode_barang" class="block mb-2 text-sm font-medium text-gray-900">Kode Barang (Auto-generated)</label>
                    <input type="text" id="kode_barang" class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" value="{{ $barang->kode_barang }}" readonly disabled>
                    <p class="text-gray-500 text-xs mt-1">Kode barang dibuat otomatis</p>
                </div>

                <div>
                    <label for="namaBarang" class="block mb-2 text-sm font-medium text-gray-900">Nama Barang *</label>
                    <input type="text" name="namaBarang" id="namaBarang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ old('namaBarang', $barang->namaBarang) }}" required>
                    @error('namaBarang')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kategori_id" class="block mb-2 text-sm font-medium text-gray-900">Kategori *</label>
                    <select id="kategori_id" name="kategori_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="">Pilih kategori barang</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->categoryID }}" @selected(old('kategori_id', $barang->categoryID) == $kategori->categoryID)>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="satuan" class="block mb-2 text-sm font-medium text-gray-900">Satuan *</label>
                    <select name="satuan" id="satuan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="">Pilih satuan barang</option>
                        @foreach ($satuanOptions as $satuan)
                            <option value="{{ $satuan }}" @selected(old('satuan', $barang->satuan) == $satuan)>
                                {{ ucfirst($satuan) }}
                            </option>
                        @endforeach
                    </select>
                    @error('satuan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="stok" class="block mb-2 text-sm font-medium text-gray-900">Stok *</label>
                <div class="flex gap-3 items-end">
                    <div class="flex-1">
                        <input type="number" name="stok" id="stok" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ old('stok', $barang->stok) }}" required min="0">
                        @error('stok')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="px-3 py-2 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-700 font-medium">
                        Status: <span class="font-bold">{{ ucfirst($barang->status) }}</span>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi (Opsional)</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Perubahan</button>
                <a href="{{ route('admin.barang.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection