<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Sesi Stock Opname - SIMANTAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .min-h-full-screen {
            min-height: 100vh;
        }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-full-screen">
        
        <div class="w-64 bg-blue-800 text-white min-h-full-screen">
            <div class="p-4 pt-6">
                <h1 class="text-2xl font-bold">SIMANTAP</h1>
                <p class="text-sm text-blue-200">Sistem Informasi Manajemen Aset Negara</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                
                <a href="{{ route('admin.manajemen-permintaan') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-clipboard-list mr-3"></i>Manajemen Permintaan
                </a>
                
                <a href="{{ route('admin.data-barang') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-boxes mr-3"></i>Data Barang
                </a>
                
                <a href="{{ route('admin.tambah-barang') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-plus-circle mr-3"></i>Tambah Barang Baru
                </a>
                
                <a href="{{ route('admin.stock-opname') }}" class="block py-3 px-4 bg-blue-700 border-l-4 border-yellow-400">
                    <i class="fas fa-clipboard-check mr-3"></i>Stock Opname
                </a>
                
                <a href="{{ route('admin.manajemen-pengguna') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-users mr-3"></i>Manajemen Pengguna
                </a>
                
                <a href="{{ route('admin.laporan') }}" class="block py-3 px-4 hover:bg-blue-700 border-l-4 border-transparent hover:border-yellow-400">
                    <i class="fas fa-chart-bar mr-3"></i>Laporan
                </a>
            </nav>
        </div>

        <div class="flex-1 bg-gray-50 p-8">
            
            <header class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Stock Opname</h1>
                <p class="text-gray-500">Lakukan pengecekan dan penyesuaian stok fisik barang</p>
            </header>
            
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
                                <tr class="bg-white border-b hover:bg-gray-50" data-stok-sistem="{{ $barang->stok_sekarang }}">
                                    
                                    <td class="py-4 px-4 font-semibold text-gray-800 whitespace-nowrap">
                                        {{ $barang->kode_barang ?? 'ATK000' . $barang->id }}
                                    </td>
                                    
                                    <th scope="row" class="py-4 px-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $barang->nama_barang }}
                                    </th>
                                    
                                    <td class="py-4 px-4">
                                        {{ $barang->kategori->nama_kategori ?? 'N/A' }}
                                    </td>
                                    
                                    <td class="py-4 px-4 font-medium text-gray-700">
                                        {{ $barang->stok_sekarang }} {{ $barang->satuan ?? 'Unit' }}
                                    </td>
                                    
                                    <td class="py-4 px-4 text-center" style="width: 150px;">
                                        <input type="number" 
                                                name="stok_fisik[{{ $barang->id }}]" 
                                                class="input-stok-fisik bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 text-center" 
                                                value="{{ old('stok_fisik.' . $barang->id) }}" 
                                                min="0">
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
        </div>
    </div>

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
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" form="opname-form" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Ya, Simpan & Sesuaikan
                    </button>
                    <button type="button" id="close-modal-btn" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('opname-form');
        const tableBody = document.getElementById('opname-table-body');
        const inputFields = tableBody.querySelectorAll('.input-stok-fisik');
        const totalItems = inputFields.length;
        
        const countChecked = document.getElementById('count-checked');
        const countDifference = document.getElementById('count-difference');
        const progressText = document.getElementById('progress-text');

        // Modal Elements
        const modal = document.getElementById('confirmation-modal');
        const openModalBtn = document.getElementById('open-modal-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const totalDiperiksaModal = document.getElementById('total-diperiksa-modal');
        const itemSelisihModal = document.getElementById('item-selisih-modal');
        const itemsSavedCount = document.getElementById('items-saved-count');
        
        // Element baru untuk menampung hasil pengurangan di modal
        const itemsRemainingModalFinal = document.getElementById('items-remaining-modal-final');

        
        function updateSummary() {
            let checkedCount = 0;
            let differenceCount = 0;

            inputFields.forEach(input => {
                const row = input.closest('tr');
                const stokSistem = parseInt(row.dataset.stokSistem) || 0; 
                
                const inputValue = input.value.trim();
                const stokFisik = inputValue === '' ? NaN : parseInt(inputValue);
                
                const selisihOutput = row.querySelector('.selisih-output');
                
                const isFilled = !isNaN(stokFisik) && inputValue !== '';
                
                // Mendapatkan ID Barang dari atribut name saat ini (sebelum dihapus)
                const currentName = input.name; 
                const barangIdMatch = currentName ? currentName.match(/\[(.*?)\]/) : null;
                const barangId = barangIdMatch ? barangIdMatch[1] : null;

                if (isFilled) {
                    checkedCount++;
                    const selisih = stokFisik - stokSistem; 
                    
                    selisihOutput.textContent = selisih;
                    selisihOutput.className = 'py-4 px-4 text-center font-semibold selisih-output';
                    
                    if (selisih !== 0) {
                        differenceCount++;
                        selisihOutput.classList.add(selisih > 0 ? 'text-green-600' : 'text-red-600');
                    } else {
                         selisihOutput.classList.add('text-gray-700');
                    }
                    
                    // MEMASTIKAN ATTRIBUTE NAME ADA JIKA DIISI (PENTING UNTUK SUBMIT)
                    // Jika name attribute hilang, buat kembali.
                    if (!input.hasAttribute('name') && barangId) {
                        input.setAttribute('name', `stok_fisik[${barangId}]`);
                    }


                } else {
                    // Jika tidak diisi, hapus atribut 'name' agar tidak terkirim ke controller
                    input.removeAttribute('name');
                    
                    selisihOutput.textContent = 'Belum diisi';
                    selisihOutput.className = 'py-4 px-4 text-center font-semibold text-gray-500 selisih-output';
                }
            });
            
            // Update KPI Cards
            const progress = totalItems > 0 ? (checkedCount / totalItems) * 100 : 0;
            countChecked.textContent = checkedCount;
            countDifference.textContent = differenceCount;
            progressText.textContent = `${progress.toFixed(0)}% selesai`;
        }

        function openModal() {
            const checkedCount = parseInt(countChecked.textContent);
            const remainingCount = totalItems - checkedCount; // HITUNG SELISIH DI SINI

            // Cek minimum: harus ada setidaknya 1 item yang diperiksa.
            if (checkedCount === 0) {
                alert("Gagal menyimpan: Anda harus mengisi setidaknya satu item sebelum menyimpan.");
                openModalBtn.classList.add('animate-pulse', 'ring-4', 'ring-red-400');
                setTimeout(() => {
                    openModalBtn.classList.remove('animate-pulse', 'ring-4', 'ring-red-400');
                }, 1000);
                return; 
            }

            // Update data di dalam modal
            totalDiperiksaModal.textContent = checkedCount;
            itemSelisihModal.textContent = countDifference.textContent;
            itemsSavedCount.textContent = checkedCount;
            // UPDATE BARU UNTUK JUMLAH ITEM SISA
            itemsRemainingModalFinal.textContent = remainingCount; 

            // Tampilkan modal
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }


        // Event Listeners
        // Diperlukan sebuah loop awal untuk menyimpan ID barang di atribut input karena kita menghapusnya
        inputFields.forEach(input => {
            const row = input.closest('tr');
            // Simpan ID barang di atribut 'id' jika belum ada, atau gunakan logic lain.
            // Saat ini kita tidak perlu memodifikasi atribut name jika kosong saat load, 
            // cukup simpan ID-nya dan biarkan name terhapus di updateSummary jika input kosong.
        });


        inputFields.forEach(input => {
            input.addEventListener('input', updateSummary);
        });

        openModalBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);
        // Menutup modal ketika mengklik di luar area modal
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Panggil sekali saat load
        updateSummary();
    });
</script>
</body>
</html>