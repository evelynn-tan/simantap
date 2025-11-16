@extends('pegawai.layout')

@section('title', 'Daftar Barang Tersedia - SIMANTAP')
@section('page-title', 'Daftar Barang Tersedia')
@section('page-subtitle', 'Lihat dan ajukan permintaan untuk barang yang tersedia')

@section('content')
<div x-data="{
    isModalOpen: false,
    selectedBarang: {},
    formData: {
        jumlah: 1,
        keperluan: ''
    },
}">

    {{-- Card utama --}}
    <div class="bg-white rounded-lg shadow-sm border">
        
        {{-- 1. Bungkus header dengan <form method="GET"> --}}
        <form method="GET" action="{{ route('pegawai.daftar-barang') }}">
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Barang Tersedia</h3>
                        <p class="text-sm text-gray-600">Lihat dan ajukan permintaan untuk barang yang tersedia</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        
                        {{-- 2. Tambahkan name="search" dan value="" --}}
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" {{-- Tambah 'name' --}}
                                value="{{ request('search') }}" {{-- Tampilkan nilai filter aktif --}}
                                placeholder="Cari barang..." 
                                class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent w-64"
                            >
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        
                        {{-- 3. Tambahkan name="kategori" dan buat dinamis --}}
                        <select 
                            name="kategori" {{-- Tambah 'name' --}}
                            class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        >
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option 
                                    value="{{ $kategori->kategoriID }}" 
                                    {{ request('kategori') == $kategori->kategoriID ? 'selected' : '' }} {{-- Tampilkan nilai filter aktif --}}
                                >
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        
                        {{-- 4. Tambahkan tombol "Cari" dan "Reset" --}}
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                            Cari
                        </button>
                        <a href="{{ route('pegawai.daftar-barang') }}" class="text-sm text-gray-600 hover:text-gray-800">
                            Reset
                        </a>
                        
                    </div>
                </div>
            </div>
        </form> {{-- Penutup tag form --}}

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- 5. @forelse sekarang akan merender barang per halaman --}}
                    @forelse($barangs as $barang)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $barang->kode_barang }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $barang->nama_barang }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $barang->kategori->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $barang->stok_sekarang < 5 ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $barang->stok_sekarang }} {{ $barang->satuan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button 
                                type="button"
                                @click="
                                    isModalOpen = true; 
                                    selectedBarang = {{ $barang->toJson() }};
                                    formData.jumlah = 1;
                                    formData.keperluan = '';
                                "
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Ajukan Permintaan
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            <i class="fas fa-box-open text-3xl text-gray-300 mb-2"></i>
                            <p>Tidak ada barang ditemukan</p>
                            <p class="text-xs">Coba ubah filter pencarian Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t bg-gray-50">
            <div class="flex justify-end">
                {{-- 6. Tampilkan pagination links --}}
                {{ $barangs->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <div
        x-show="isModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4"
        style="display: none;"
    >
        <div
            @click.away="isModalOpen = false"
            x-show="isModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6"
        >
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">
                    Form Pengajuan: <span x-text="selectedBarang.nama_barang"></span>
                </h3>
                <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <form method="POST" action="{{ route('pegawai.permintaan.ajukan') }}">
                @csrf
                <input type="hidden" name="items[0][barangID]" x-bind:value="selectedBarang.barangID">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                    <input 
                        type="text" 
                        x-bind:value="selectedBarang.nama_barang" 
                        disabled 
                        class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm"
                    >
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Stok Tersedia</label>
                    {{-- Gunakan 'stok_sekarang' sesuai variabel Anda --}}
                    <input 
                        type="text" 
                        x-bind:value="selectedBarang.stok_sekarang + ' ' + selectedBarang.satuan" 
                        disabled 
                        class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm"
                    >
                </div>

                <div class="mb-4">
                    <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Diajukan</label>
                    <input 
                        type="number" 
                        name="items[0][jumlah]" {{-- Kirim sebagai 'items[0][jumlah]' --}}
                        id="jumlah"
                        x-model="formData.jumlah"
                        min="1" 
                        x-bind:max="selectedBarang.stok_sekarang" {{-- Validasi stok --}}
                        required 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                    >
                </div>

                <div class="mb-4">
                    <label for="keperluan" class="block text-sm font-medium text-gray-700">Keperluan</t>
                    <textarea 
                        name="description" {{-- Kirim sebagai 'description' (sesuai validasi controller) --}}
                        id="keperluan"
                        x-model="formData.keperluan"
                        rows="3" 
                        required
                        placeholder="Jelaskan keperluan atau alasan permintaan barang..." 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                    ></textarea>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button 
                        type="button" 
                        @click="isModalOpen = false" 
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg"
                    >
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection