@extends('layouts.admin')

@section('title', 'Tambah Data Barang - SIMANTAP')
@section('header', 'Tambah Data Barang Baru')
@section('subtitle', 'Tambahkan barang baru ke dalam sistem inventori')

@section('content')
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Form Column -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800">📝 Form Tambah Barang</h2>
                    <p class="text-sm text-slate-500 mt-1">Isi semua informasi barang yang akan ditambahkan</p>
                </div>

                <form action="{{ route('admin.barang.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    
                    <!-- Nama Barang -->
                    <div>
                        <label for="namaBarang" class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang *</label>
                        <input 
                            type="text" 
                            name="namaBarang" 
                            id="namaBarang" 
                            class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                            placeholder="Contoh: Kertas HVS A4 80 gram" 
                            value="{{ old('namaBarang') }}" 
                            required
                        >
                        @error('namaBarang')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori & Satuan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="kategori_id" class="block text-sm font-semibold text-slate-700 mb-2">Kategori *</label>
                            <select 
                                id="kategori_id" 
                                name="kategori_id" 
                                class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                required
                            >
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->categoryID }}" {{ old('kategori_id') == $kategori->categoryID ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="satuan" class="block text-sm font-semibold text-slate-700 mb-2">Satuan *</label>
                            <select 
                                id="satuan" 
                                name="satuan" 
                                class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                required
                            >
                                <option value="">-- Pilih Satuan --</option>
                                <option value="rim" {{ old('satuan') == 'rim' ? 'selected' : '' }}>Rim</option>
                                <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>PCS</option>
                                <option value="buah" {{ old('satuan') == 'buah' ? 'selected' : '' }}>Buah</option>
                                <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>Box</option>
                                <option value="pack" {{ old('satuan') == 'pack' ? 'selected' : '' }}>Pack</option>
                                <option value="set" {{ old('satuan') == 'set' ? 'selected' : '' }}>Set</option>
                                <option value="lembar" {{ old('satuan') == 'lembar' ? 'selected' : '' }}>Lembar</option>
                                <option value="meter" {{ old('satuan') == 'meter' ? 'selected' : '' }}>Meter</option>
                                <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kg</option>
                                <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>Liter</option>
                            </select>
                            @error('satuan')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stok" class="block text-sm font-semibold text-slate-700 mb-2">Stok Awal *</label>
                        <input 
                            type="number" 
                            name="stok" 
                            id="stok" 
                            class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                            placeholder="0" 
                            min="0" 
                            value="{{ old('stok', 0) }}" 
                            required
                        >
                        @error('stok')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi (Opsional)</label>
                        <textarea 
                            id="deskripsi" 
                            name="deskripsi" 
                            rows="3" 
                            class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none" 
                            placeholder="Deskripsi tambahan tentang barang..."
                        >{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-slate-200">
                        <button 
                            type="submit" 
                            class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200"
                        >
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                        <button 
                            type="reset" 
                            class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition duration-200"
                        >
                            Reset
                        </button>
                        <a 
                            href="{{ route('admin.barang.index') }}" 
                            class="px-6 py-2.5 bg-slate-100 text-slate-700 hover:bg-slate-200 font-semibold rounded-lg transition duration-200 text-center"
                        >
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Column -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center gap-2 mb-4">
                    <div class="h-10 w-10 bg-blue-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-lg text-blue-700"></i>
                    </div>
                    <h3 class="font-bold text-slate-900">Tips Pengisian</h3>
                </div>

                <ul class="space-y-3 text-sm text-slate-700">
                    <li class="flex gap-2">
                        <span class="text-blue-600 font-bold">•</span>
                        <span><strong>Nama Barang:</strong> Masukkan nama yang jelas dan deskriptif</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-blue-600 font-bold">•</span>
                        <span><strong>Kategori:</strong> Pilih kategori yang sesuai untuk pengelompokan</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-blue-600 font-bold">•</span>
                        <span><strong>Satuan:</strong> Sesuaikan dengan unit pengukuran barang</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-blue-600 font-bold">•</span>
                        <span><strong>Stok Awal:</strong> Input jumlah barang yang tersedia saat ini</span>
                    </li>
                </ul>

                <div class="mt-6 p-4 bg-white rounded-lg border border-blue-200">
                    <p class="text-xs text-slate-600 mb-2">📌 <strong>Catatan:</strong></p>
                    <p class="text-xs text-slate-600">Kode barang akan otomatis di-generate oleh sistem</p>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
