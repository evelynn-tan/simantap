<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Pengajuan Permintaan Barang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Tampilkan error validasi -->
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
            @if (session('error'))
                <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                    <span class="font-medium">Error!</span> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('pegawai.permintaan.ajukan') }}" method="POST" class="bg-white shadow-md rounded-lg p-6" x-data="formPermintaan()">
                @csrf
                <h3 class="text-lg font-semibold mb-6">Form Pengajuan</h3>

                <!-- Keperluan -->
                <div class="mb-6">
                    <label for="keperluan" class="block mb-2 text-sm font-medium text-gray-900">Keperluan *</label>
                    <textarea id="keperluan" name="keperluan" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan untuk apa barang ini dibutuhkan..." required>{{ old('keperluan') }}</textarea>
                </div>
                
                <!-- Daftar Barang yang Diajukan -->
                <h3 class="text-lg font-semibold mb-4">Barang yang Diajukan</h3>
                <div id="items-container" class="space-y-4">
                    <!-- Baris Item akan ditambahkan oleh Alpine.js -->
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex items-center gap-4 p-4 border rounded-lg">
                            <div class="flex-1">
                                <label class="block mb-2 text-sm font-medium text-gray-900">Barang *</label>
                                <select :name="'items[' + index + '][barang_id]'" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }} (Stok: {{ $barang->stok }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-1/4">
                                <label class="block mb-2 text-sm font-medium text-gray-900">Jumlah *</label>
                                <input type="number" :name="'items[' + index + '][jumlah]'" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="1" min="1" required>
                            </div>
                            <button type="button" @click="removeItem(index)" class="text-red-600 hover:text-red-800 self-end mb-2.5">
                                Hapus
                            </button>
                        </div>
                    </template>
                </div>

                <button type="button" @click="addItem" class="mt-4 text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">
                    + Tambah Barang Lain
                </button>

                <hr class="my-6">

                <div class="flex justify-end gap-4">
                    <a href="{{ route('pegawai.barang.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Alpine.js untuk form dinamis -->
    <script>
        function formPermintaan() {
            return {
                items: [{}], // Mulai dengan 1 item kosong
                addItem() {
                    this.items.push({});
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                }
            }
        }
    </script>
</x-app-layout>