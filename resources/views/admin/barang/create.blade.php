@extends('layouts.admin')

@section('header', 'Tambah Data Barang Baru')

@section('content')
<div class="w-full">
    <p class="text-gray-600 mb-6">Tambahkan barang baru ke dalam sistem inventori</p>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-bold">+</span>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Form Tambah Barang</h2>
                </div>
                <p class="text-gray-500 text-sm mb-6">Isi semua informasi barang yang akan ditambahkan</p>

                @if ($errors->any())
                    <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                        <span class="font-medium">Ada kesalahan:</span>
                        <ul class="mt-1.5 ml-4 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.barang.store') }}" method="POST" id="formBarang">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="kode_barang" class="block mb-2 text-sm font-medium text-gray-900">Kode Barang *</label>
                            <input type="text" name="kode_barang" id="kode_barang" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50" 
                                placeholder="Contoh: BRG001" value="{{ old('kode_barang') }}" required>
                            @error('kode_barang')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-900">Nama Barang *</label>
                            <input type="text" name="nama_barang" id="nama_barang" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50" 
                                placeholder="Contoh: Laptop Dell Inspiron 15" value="{{ old('nama_barang') }}" required>
                            @error('nama_barang')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="kategori_id" class="block mb-2 text-sm font-medium text-gray-900">Kategori *</label>
                            <select id="kategori_id" name="kategori_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50" required>
                                <option value="">Pilih kategori barang</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->kategoriID }}" @if(old('kategori_id') == $kategori->kategoriID) selected @endif>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="satuan" class="block mb-2 text-sm font-medium text-gray-900">Satuan *</label>
                            <input type="text" name="satuan" id="satuan" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50" 
                                placeholder="Pilih satuan barang" value="{{ old('satuan') }}" required>
                            @error('satuan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="stok_awal" class="block mb-2 text-sm font-medium text-gray-900">Stok Awal *</label>
                        <input type="number" name="stok_awal" id="stok_awal" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50" 
                            value="{{ old('stok_awal', 0) }}" min="0" required>
                        @error('stok_awal')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi (Opsional)</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50" 
                            placeholder="Deskripsi tambahan tentang barang (opsional)">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white font-medium rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Simpan Data
                        </button>
                        <button type="reset" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                            Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="font-semibold text-gray-900">Preview Data</h3>
                </div>
                <p class="text-gray-500 text-sm mb-4">Pratinjau data barang yang akan ditambahkan</p>

                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-500">Kode Barang</p>
                        <p class="font-medium text-gray-900" id="preview_kode">-</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Nama Barang</p>
                        <p class="font-medium text-gray-900" id="preview_nama">-</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-500">Kategori</p>
                            <p class="font-medium text-gray-900" id="preview_kategori">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Satuan</p>
                            <p class="font-medium text-gray-900" id="preview_satuan">-</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-500">Stok Awal</p>
                        <p class="font-medium text-gray-900" id="preview_stok">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Status Validasi</h3>
                
                <div id="validation-status" class="space-y-2 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Kode Barang</span>
                        <span class="text-red-500 text-lg">✕</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Nama Barang</span>
                        <span class="text-red-500 text-lg">✕</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Kategori</span>
                        <span class="text-red-500 text-lg">✕</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Satuan</span>
                        <span class="text-red-500 text-lg">✕</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Stok</span>
                        <span class="text-green-500 text-lg">✓</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Update preview & status validasi real-time
const form = document.getElementById('formBarang');
const inputs = form.querySelectorAll('input, select, textarea');

function updatePreview() {
    const kode = document.getElementById('kode_barang').value;
    const nama = document.getElementById('nama_barang').value;
    const kategoriId = document.getElementById('kategori_id').value;
    const kategoriElement = document.getElementById('kategori_id');
    // Menambahkan pengecekan agar tidak error jika index belum dipilih
    const kategoriText = kategoriElement.selectedIndex >= 0 ? kategoriElement.options[kategoriElement.selectedIndex].text : '';
    const satuan = document.getElementById('satuan').value;
    const stok = document.getElementById('stok_awal').value || '0';

    // Update preview
    document.getElementById('preview_kode').textContent = kode || '-';
    document.getElementById('preview_nama').textContent = nama || '-';
    document.getElementById('preview_kategori').textContent = (kategoriId && kategoriText !== 'Pilih kategori barang') ? kategoriText : '-';
    document.getElementById('preview_satuan').textContent = satuan || '-';
    document.getElementById('preview_stok').textContent = stok;

    // PERBAIKAN 2: Menggunakan getElementById untuk menargetkan div yang spesifik
    const statusContainer = document.getElementById('validation-status');
    
    // Safety check: jika element tidak ditemukan, hentikan fungsi
    if (!statusContainer) return;

    const statuses = [
        { field: 'Kode Barang', valid: kode.length > 0 },
        { field: 'Nama Barang', valid: nama.length > 0 },
        { field: 'Kategori', valid: kategoriId.length > 0 },
        { field: 'Satuan', valid: satuan.length > 0 },
        { field: 'Stok', valid: true }
    ];

    const statusHtml = statuses.map(s => `
        <div class="flex justify-between items-center">
            <span class="text-gray-700">${s.field}</span>
            <span class="${s.valid ? 'text-green-500' : 'text-red-500'} text-lg">${s.valid ? '✓' : '✕'}</span>
        </div>
    `).join('');

    statusContainer.innerHTML = statusHtml;
}

inputs.forEach(input => {
    input.addEventListener('input', updatePreview);
    input.addEventListener('change', updatePreview);
});

// Jalankan sekali saat load
updatePreview();
</script>
@endsection