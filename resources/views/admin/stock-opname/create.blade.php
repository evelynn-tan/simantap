@extends('layouts.admin')

@section('title', 'Mulai Stock Opname - SIMANTAP')
@section('header', 'Stock Opname')
@section('subtitle', 'Lakukan pengecekan dan penyesuaian stok fisik barang')

@section('content')
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">
    
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-500"></i>
            <span><strong>Gagal!</strong> {{ session('error') }}</span>
        </div>
    @endif

    <!-- Error Notification (for JS validation) -->
    <div id="error-notification" class="hidden bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-red-500"></i>
        <span id="error-message">Anda harus mengisi setidaknya satu item sebelum menyimpan.</span>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Total Item</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $barangs->count() }}</p>
                    <p class="text-xs text-slate-400 mt-1">Item dalam sistem</p>
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box-open text-xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Sudah Diperiksa</p>
                    <p id="count-checked" class="text-3xl font-bold text-green-600 mt-1">0</p>
                    <p id="progress-text" class="text-xs text-slate-400 mt-1">0% selesai</p>
                </div>
                <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-xl text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Ada Selisih</p>
                    <p id="count-difference" class="text-3xl font-bold text-orange-600 mt-1">0</p>
                    <p class="text-xs text-slate-400 mt-1">Item dengan perbedaan stok</p>
                </div>
                <div class="h-12 w-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-xl text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-slate-700">Progress Pengecekan</span>
            <span id="progress-percentage" class="text-sm font-bold text-teal-600">0%</span>
        </div>
        <div class="w-full bg-slate-200 rounded-full h-3">
            <div id="progress-bar" class="bg-gradient-to-r from-teal-500 to-cyan-500 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
        </div>
    </div>
    
    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 bg-gradient-to-r from-teal-500 to-cyan-600">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-clipboard-check"></i> Daftar Barang untuk Opname
            </h3>
            <p class="text-teal-100 text-sm mt-1">Input jumlah fisik untuk setiap barang. Sistem akan otomatis menghitung selisih.</p>
        </div>

        <form id="opname-form" action="{{ route('admin.stock-opname.store') }}" method="POST">
            @csrf
            
            <!-- Catatan Input -->
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <label for="catatan" class="block mb-2 text-sm font-semibold text-slate-700">
                    <i class="fas fa-sticky-note mr-1 text-teal-500"></i> Catatan Stock Opname (Opsional)
                </label>
                <textarea name="keterangan" id="catatan" rows="2" 
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition resize-none text-sm"
                    placeholder="Contoh: Opname dilakukan fokus pada kategori ATK dan Elektronik...">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Nama Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Stok Sistem</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase" style="width: 150px;">Jumlah Fisik</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Selisih</th>
                        </tr>
                    </thead>
                    <tbody id="opname-table-body" class="divide-y divide-slate-200">
                        @forelse ($barangs as $barang)
                        <tr class="hover:bg-slate-50 transition" 
                            data-barang-id="{{ $barang->barangID }}"
                            data-stok-sistem="{{ $barang->stok }}">
                            
                            <td class="px-6 py-4 font-mono font-bold text-slate-800">
                                {{ $barang->kode_barang ?? 'BRG-' . str_pad($barang->barangID, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $barang->namaBarang }}
                            </td>
                            
                            <td class="px-6 py-4 text-slate-600">
                                {{ $barang->kategori?->nama_kategori ?? 'Lain-lain' }}
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <span class="font-semibold text-slate-700">{{ $barang->stok }}</span>
                                <span class="text-slate-500 text-xs">{{ $barang->satuan ?? 'unit' }}</span>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <input type="number" 
                                    name="stok_fisik[{{ $barang->barangID }}]" 
                                    class="input-stok-fisik w-full px-3 py-2 border border-slate-200 rounded-lg text-center text-sm font-medium focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition" 
                                    value="{{ old('stok_fisik.' . $barang->barangID) }}" 
                                    min="0"
                                    placeholder="...">
                                @if ($errors->has('stok_fisik.' . $barang->barangID))
                                    <p class="mt-1 text-xs text-red-600">{{ $errors->first('stok_fisik.' . $barang->barangID) }}</p>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 text-center font-semibold text-slate-400 selisih-output">
                                —
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <i class="fas fa-box-open text-4xl mb-3 opacity-50"></i>
                                <p class="font-medium">Tidak ada data barang yang tersedia untuk opname</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-between items-center">
                <a href="{{ route('admin.stock-opname.index') }}" class="inline-flex items-center px-5 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 font-semibold rounded-lg text-sm transition">
                    <i class="fas fa-arrow-left mr-2"></i> Batal
                </a>
                <button type="button" id="open-modal-btn" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white font-semibold rounded-lg text-sm transition shadow-md hover:shadow-lg">
                    <i class="fas fa-save mr-2"></i> Simpan & Sesuaikan Stok
                </button>
            </div>

        </form>
    </div>
    
    <!-- Modal Konfirmasi -->
    <div id="confirmation-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal()"></div>
        
        <div class="relative bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-lg">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="h-12 w-12 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-xl text-yellow-600"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Konfirmasi Penyesuaian Stok</h3>
                        <p class="text-sm text-slate-600 mb-4">Anda akan menyimpan hasil stock opname dengan detail:</p>
                        
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 mb-4">
                            <ul class="space-y-2 text-sm">
                                <li class="flex justify-between">
                                    <span class="text-slate-600">Total item diperiksa:</span>
                                    <span class="font-bold text-slate-800"><span id="total-diperiksa-modal">0</span> dari {{ $barangs->count() }}</span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-slate-600">Item dengan selisih:</span>
                                    <span class="font-bold text-orange-600"><span id="item-selisih-modal">0</span> item</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                            <p class="text-xs text-yellow-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                <strong>Perhatian:</strong> Hanya <strong><span id="items-saved-count">0</span> item</strong> yang telah Anda periksa akan disesuaikan. 
                                Stok item yang belum diisi (<strong><span id="items-remaining-modal-final">0</span></strong>) akan tetap pada stok sistem saat ini.
                            </p>
                        </div>
                        
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                            <p class="text-xs text-red-700 font-medium">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Tindakan penyesuaian stok tidak dapat dibatalkan.
                            </p>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-xs font-medium text-slate-600 mb-1">Catatan yang akan disimpan:</label>
                            <p id="modal-catatan-view" class="text-sm text-slate-800 p-2 border border-slate-200 rounded bg-slate-50 italic min-h-[40px]">Tidak ada catatan</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex gap-3 justify-end rounded-b-xl">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-slate-700 bg-white border border-slate-200 hover:bg-slate-100 rounded-lg font-semibold text-sm transition">
                    Batal
                </button>
                <button type="submit" form="opname-form" id="confirm-submit-btn" class="px-4 py-2 text-white bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 rounded-lg font-semibold text-sm transition shadow-md">
                    <i class="fas fa-check mr-1"></i> Ya, Simpan & Sesuaikan
                </button>
            </div>
        </div>
    </div>
    
</div>

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
    const progressBar = document.getElementById('progress-bar');
    const progressPercentage = document.getElementById('progress-percentage');
    
    const errorNotification = document.getElementById('error-notification');
    const errorMessage = document.getElementById('error-message');

    const modal = document.getElementById('confirmation-modal');
    const openModalBtn = document.getElementById('open-modal-btn');
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
            const isFilledAndValid = !isNaN(stokFisik) && inputValue !== '' && stokFisik >= 0;
            const barangId = row.dataset.barangId;

            if (isFilledAndValid) { 
                checkedCount++;
                const selisih = stokFisik - stokSistem; 
                
                if (selisih > 0) {
                    selisihOutput.textContent = '+' + selisih;
                    selisihOutput.className = 'px-6 py-4 text-center font-bold text-green-600 selisih-output';
                } else if (selisih < 0) {
                    selisihOutput.textContent = selisih;
                    selisihOutput.className = 'px-6 py-4 text-center font-bold text-red-600 selisih-output';
                } else {
                    selisihOutput.textContent = '0';
                    selisihOutput.className = 'px-6 py-4 text-center font-bold text-slate-500 selisih-output';
                }
                
                if (selisih !== 0) {
                    differenceCount++;
                }
                
                if (!input.hasAttribute('name') && barangId) {
                    input.setAttribute('name', `stok_fisik[${barangId}]`);
                }

            } else {
                selisihOutput.textContent = '—';
                selisihOutput.className = 'px-6 py-4 text-center font-semibold text-slate-400 selisih-output';
            }
        });
        
        // Update KPI
        const progress = totalItems > 0 ? (checkedCount / totalItems) * 100 : 0;
        countChecked.textContent = checkedCount;
        countDifference.textContent = differenceCount;
        progressText.textContent = `${progress.toFixed(0)}% selesai`;
        progressBar.style.width = `${progress}%`;
        progressPercentage.textContent = `${progress.toFixed(0)}%`;

        // Update modal info
        totalDiperiksaModal.textContent = checkedCount;
        itemSelisihModal.textContent = differenceCount;
        itemsSavedCount.textContent = checkedCount;
        itemsRemainingModalFinal.textContent = totalItems - checkedCount; 
        modalCatatanView.textContent = catatanInput.value.trim() || 'Tidak ada catatan';
    }

    // Event Listeners
    inputFields.forEach(input => {
        input.addEventListener('input', updateSummary);
    });
    catatanInput.addEventListener('input', updateSummary);

    openModalBtn.addEventListener('click', openModal);
    
    form.addEventListener('submit', function(e) {
        inputFields.forEach(input => {
            const value = input.value.trim();
            const numValue = Number(value);
            
            if (value === '' || isNaN(numValue) || numValue < 0) {
                input.removeAttribute('name');
            } else {
                const row = input.closest('tr');
                const barangId = row.dataset.barangId;
                input.setAttribute('name', `stok_fisik[${barangId}]`);
            }
        });
    });

    function openModal() {
        const checkedCount = parseInt(countChecked.textContent);

        if (checkedCount === 0) {
            errorNotification.classList.remove('hidden');
            openModalBtn.classList.add('ring-4', 'ring-red-400');
            
            setTimeout(() => {
                openModalBtn.classList.remove('ring-4', 'ring-red-400');
                errorNotification.classList.add('hidden');
            }, 3000); 
            
            return; 
        }
        
        errorNotification.classList.add('hidden');
        updateSummary(); 
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    window.closeModal = function() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // Initial call
    updateSummary();
});
</script>
@endsection