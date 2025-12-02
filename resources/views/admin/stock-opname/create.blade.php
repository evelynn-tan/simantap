@extends('layouts.admin')

@section('title', 'Mulai Sesi Stock Opname - SIMANTAP')
@section('header', 'Stock Opname')

@section('content')
    
    <p class="text-gray-500 mb-8">Lakukan pengecekan dan penyesuaian stok fisik barang</p>
    
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-4" role="alert">
            <strong class="font-bold">Gagal!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Notifikasi Error Inline (Pengganti alert()) --}}
    <div id="error-notification" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-4" role="alert">
        <strong class="font-bold">Perhatian!</strong>
        <span id="error-message" class="block sm:inline">Anda harus mengisi setidaknya satu item sebelum menyimpan.</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200">
            <div class="flex justify-between items-center mb-2">
                <dt class="text-md font-medium text-gray-700">Total Item</dt>
                <i class="fas fa-box-open text-blue-500"></i>
            </div>
            <dd class="text-3xl font-bold text-gray-900">{{ $barangs->count() }}</dd>
            <p class="text-xs text-gray-500">Item dalam sistem</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200">
            <div class="flex justify-between items-center mb-2">
                <dt class="text-md font-medium text-gray-700">Sudah Diperiksa</dt>
                <i class="fas fa-check-circle text-green-500"></i>
            </div>
            <dd id="count-checked" class="text-3xl font-bold text-gray-900">0</dd>
            <p id="progress-text" class="text-xs text-gray-500">0% selesai</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200">
            <div class="flex justify-between items-center mb-2">
                <dt class="text-md font-medium text-gray-700">Ada Selisih</dt>
                <i class="fas fa-exclamation-triangle text-red-500"></i>
            </div>
            <dd id="count-difference" class="text-3xl font-bold text-gray-900">0</dd>
            <p class="text-xs text-gray-500">Item dengan perbedaan stok</p>
        </div>
    </div>
    
    <div class="bg-white overflow-hidden shadow-xl rounded-xl p-8">
        
        <h3 class="text-xl font-bold text-gray-900 mb-2">Daftar Stock Opname</h3>
        <p class="text-gray-600 mb-6 text-sm">Input jumlah fisik untuk setiap barang. Sistem akan otomatis menghitung selisih.</p>

        <form id="opname-form" action="{{ route('admin.stock-opname.store') }}" method="POST">
            @csrf
            
            {{-- Tambahkan Input Catatan --}}
            <div class="mb-6">
                <label for="catatan" class="block mb-2 text-sm font-medium text-gray-900">Catatan Stock Opname (Opsional)</label>
                <textarea name="catatan" id="catatan" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: Opname dilakukan oleh tim A dan B, fokus pada barang kategori ATK dan Elektronik.">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="overflow-x-auto relative sm:rounded-lg border border-gray-200">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-4">Kode Barang</th>
                            <th scope="col" class="py-3 px-4">Nama Barang</th>
                            <th scope="col" class="py-3 px-4">Kategori</th>
                            <th scope="col" class="py-3 px-4">Stok Sistem</th>
                            <th scope="col" class="py-3 px-4 text-center">Jumlah Fisik</th>
                            <th scope="col" class="py-3 px-4 text-center">Selisih</th>
                        </tr>
                    </thead>
                    <tbody id="opname-table-body">
                        @forelse ($barangs as $barang)
                        <tr class="bg-white border-b hover:bg-gray-50" 
                            data-barang-id="{{ $barang->barangID }}" {{-- PERBAIKAN 1: Menggunakan barangID --}}
                            data-stok-sistem="{{ $barang->stok_sekarang }}">
                            
                            <td class="py-4 px-4 font-semibold text-gray-800 whitespace-nowrap">
                                {{ $barang->kode_barang ?? 'ATK000' . $barang->barangID }}
                            </td>
                            
                            <th scope="row" class="py-4 px-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $barang->nama_barang }}
                            </th>
                            
                            <td class="py-4 px-4">
                                {{-- Menggunakan optional chaining (?->) untuk mencegah error jika kategori null --}}
                                {{ $barang->kategori?->nama_kategori ?? 'N/A' }}
                            </td>
                            
                            <td class="py-4 px-4 font-medium text-gray-700">
                                {{ $barang->stok_sekarang }} {{ $barang->satuan ?? 'Unit' }}
                            </td>
                            
                            <td class="py-4 px-4 text-center" style="width: 150px;">
                               <input type="number" 
                               name="stok_fisik[{{ $barang->barangID }}]" 
                               class="input-stok-fisik bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 text-center" 
                               
                               value="{{ old('stok_fisik.' . $barang->barangID) }}" 
                               min="0">
                               {{-- Menampilkan pesan error validasi khusus untuk field ini --}}
                               @if ($errors->has('stok_fisik.' . $barang->barangID)) {{-- PERBAIKAN 2: Menggunakan barangID --}}
                                   <p class="mt-1 text-xs text-red-600">{{ $errors->first('stok_fisik.' . $barang->barangID) }}</p>
                               @endif
                            </td>
                            
                            <td class="py-4 px-4 text-center font-semibold text-gray-500 selisih-output">
                                Belum diisi
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-white border-b">
                            <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                                <i class="fas fa-info-circle mr-2"></i>Tidak ada data barang yang tersedia untuk opname.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.stock-opname.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2">
                    Batal Opname
                </a>
                <button type="button" id="open-modal-btn" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    <i class="fas fa-save mr-2"></i> Simpan & Sesuaikan Stok
                </button>
            </div>

        </form>

    </div>
    
    {{-- Modal Konfirmasi (HTML) --}}
    <div id="confirmation-modal" class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true"></div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Konfirmasi Penyesuaian Stok
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 mb-3">Anda akan menyimpan hasil stock opname dengan detail:</p>
                                
                                <ul class="list-disc list-inside text-sm text-gray-700 bg-gray-50 p-3 rounded-lg">
                                    <li>Total item diperiksa: <span id="total-diperiksa-modal" class="font-bold text-gray-900">0</span> dari {{ $barangs->count() }}</li>
                                    <li>Item dengan selisih: <span id="item-selisih-modal" class="font-bold text-red-600">0</span></li>
                                </ul>

                                <p id="warning-partial-save" class="text-xs font-semibold text-gray-700 mt-3">
                                    Perhatian: Hanya<b> <span id="items-saved-count">0</span> item </b> yang telah Anda periksa dan akan disesuaikan. Stok item yang belum diisi (<b><span id="items-remaining-modal-final">0</span></b>) akan <b> TETAP </b> pada stok sistem saat ini.
                                </p>
                                <p class="text-xs font-semibold text-red-600 mt-1">
                                    Tindakan penyesuaian stok tidak dapat dibatalkan.
                                </p>
                            </div>
                            <div class="mt-4">
                                <label for="modal-catatan-view" class="block text-xs font-medium text-gray-700">Catatan Opname yang akan disimpan:</label>
                                <p id="modal-catatan-view" class="text-sm text-gray-800 p-2 border rounded bg-gray-100 italic break-words min-h-[40px] mt-1">Tidak ada catatan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" form="opname-form" id="confirm-submit-btn" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Ya, Simpan & Sesuaikan
                    </button>
                    <button type="button" id="close-modal-btn" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('opname-form');
            const tableBody = document.getElementById('opname-table-body');
            const inputFields = tableBody.querySelectorAll('.input-stok-fisik');
            const totalItems = inputFields.length;
            
            const catatanInput = document.getElementById('catatan');

            const countChecked = document.getElementById('count-checked');
            const countDifference = document.getElementById('count-difference');
            const progressText = document.getElementById('progress-text');
            
            // Elemen notifikasi error baru
            const errorNotification = document.getElementById('error-notification');
            const errorMessage = document.getElementById('error-message');


            const modal = document.getElementById('confirmation-modal');
            const openModalBtn = document.getElementById('open-modal-btn');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const totalDiperiksaModal = document.getElementById('total-diperiksa-modal');
            const itemSelisihModal = document.getElementById('item-selisih-modal');
            const itemsSavedCount = document.getElementById('items-saved-count');
            const itemsRemainingModalFinal = document.getElementById('items-remaining-modal-final');
            const modalCatatanView = document.getElementById('modal-catatan-view');

            
            function updateSummary() {
                let checkedCount = 0;
                let differenceCount = 0;

                inputFields.forEach(input => {
                    const row = input.closest('tr');
                    
                    const stokSistemString = row.dataset.stokSistem;
                    const stokSistem = Number(stokSistemString) || 0; 
                    
                    const inputValue = input.value.trim();
                    const stokFisik = inputValue === '' ? NaN : Number(inputValue); 
                    
                    const selisihOutput = row.querySelector('.selisih-output');
                    
                    // Cek apakah input valid (terisi dan merupakan angka non-negatif)
                    const isFilledAndValid = !isNaN(stokFisik) && inputValue !== '' && stokFisik >= 0;
                    
                    // Ambil ID Barang dari data-attribute baris
                    const barangId = row.dataset.barangId;

                    // --- LOGIKA PERHITUNGAN DAN UPDATE ---
                    if (isFilledAndValid) { 
                        checkedCount++;
                        
                        // PERHITUNGAN: Selisih = Fisik - Sistem
                        const selisih = stokFisik - stokSistem; 
                        
                        selisihOutput.textContent = selisih;
                        selisihOutput.className = 'py-4 px-4 text-center font-semibold selisih-output';
                        
                        if (selisih !== 0) {
                            differenceCount++;
                            selisihOutput.classList.add(selisih > 0 ? 'text-green-600' : 'text-red-600');
                        } else {
                            selisihOutput.classList.add('text-gray-700');
                        }
                        
                        // PENTING: Pastikan input memiliki atribut name agar ter-submit
                        if (!input.hasAttribute('name') && barangId) {
                            // Ini seharusnya sudah diatur di PHP, tapi ini adalah fallback
                            input.setAttribute('name', `stok_fisik[${barangId}]`);
                        }

                    } else {
                        // Jika input kosong atau tidak valid
                        selisihOutput.textContent = 'Belum diisi';
                        selisihOutput.className = 'py-4 px-4 text-center font-semibold text-gray-500 selisih-output';
                    }
                });
                
                // Update KPI Cards di atas
                const progress = totalItems > 0 ? (checkedCount / totalItems) * 100 : 0;
                countChecked.textContent = checkedCount;
                countDifference.textContent = differenceCount;
                progressText.textContent = `${progress.toFixed(0)}% selesai`;

                // Update info di modal
                totalDiperiksaModal.textContent = checkedCount;
                itemSelisihModal.textContent = differenceCount;
                itemsSavedCount.textContent = checkedCount;
                itemsRemainingModalFinal.textContent = totalItems - checkedCount; 
                modalCatatanView.textContent = catatanInput.value.trim() || 'Tidak ada catatan';
            }

            // --- Event Listeners ---
            
            // 1. Live calculation and summary update
            inputFields.forEach(input => {
                input.addEventListener('input', updateSummary);
            });
            catatanInput.addEventListener('input', updateSummary);


            // 2. Modal interactions
            openModalBtn.addEventListener('click', openModal);
            closeModalBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });
            
            // Tambahkan event listener untuk tombol ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
            
            // 3. Submit handler
            form.addEventListener('submit', function(e) {
                // Hapus input yang kosong atau tidak valid SEBELUM submit
                // agar tidak dikirim ke controller, tetapi tetap biarkan yang valid.
                inputFields.forEach(input => {
                    const value = input.value.trim();
                    const numValue = Number(value);
                    
                    // Jika kosong ATAU bukan angka valid non-negatif
                    if (value === '' || isNaN(numValue) || numValue < 0) {
                        // Hapus attribute name agar tidak ikut ter-submit
                        input.removeAttribute('name');
                    } else {
                         // Pastikan attribute name ada untuk input yang valid
                         const row = input.closest('tr');
                         const barangId = row.dataset.barangId; // Ini mengambil ID yang sudah kita perbaiki di HTML
                         input.setAttribute('name', `stok_fisik[${barangId}]`);
                    }
                });
            });

            // --- Fungsi Modal ---
            function openModal() {
                const checkedCount = parseInt(countChecked.textContent);

                if (checkedCount === 0) {
                    // MENGHAPUS alert() dan mengganti dengan notifikasi inline
                    errorNotification.classList.remove('hidden');
                    openModalBtn.classList.add('animate-pulse', 'ring-4', 'ring-red-400', 'transition', 'duration-300');
                    
                    // Hilangkan notifikasi dan animasi setelah beberapa saat
                    setTimeout(() => {
                        openModalBtn.classList.remove('animate-pulse', 'ring-4', 'ring-red-400', 'transition', 'duration-300');
                        errorNotification.classList.add('hidden');
                    }, 3000); 
                    
                    return; 
                }
                
                // Sembunyikan notifikasi error jika ada sebelum membuka modal
                errorNotification.classList.add('hidden');

                // Update ringkasan terakhir sebelum membuka modal
                updateSummary(); 
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }


            // Panggil sekali saat load
            updateSummary();
        });
    </script>
@endsection