<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Sesi Stock Opname - SIMANTAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Gaya dasar untuk memastikan layout full height */
        .min-h-full-screen {
            min-height: 100vh;
        }
        /* Mengganti font untuk estetika yang lebih modern */
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

                {{-- Tambahkan pesan error validasi (simulasi) --}}
                {{-- <div class="mb-4 text-sm text-red-600">Error validation here...</div> --}}

                <form action="{{ route('admin.stock-opname.store') }}" method="POST">
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
                                                required 
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
                            Batal
                        </a>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Simpan Hasil Opname
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tableBody = document.getElementById('opname-table-body');
        const inputFields = tableBody.querySelectorAll('.input-stok-fisik');
        const totalItems = inputFields.length;
        
        const countChecked = document.getElementById('count-checked');
        const countDifference = document.getElementById('count-difference');
        const progressText = document.getElementById('progress-text');

        function updateSummary() {
            let checkedCount = 0;
            let differenceCount = 0;

            inputFields.forEach(input => {
                const row = input.closest('tr');
                const stokSistem = parseInt(row.dataset.stokSistem) || 0;
                
                // Menggunakan parseInt untuk membaca nilai dan memeriksa kekosongan
                const inputValue = input.value.trim();
                const stokFisik = inputValue === '' ? NaN : parseInt(inputValue);
                
                const selisihOutput = row.querySelector('.selisih-output');
                
                // Cek apakah input sudah diisi (bukan NaN)
                const isFilled = !isNaN(stokFisik) && inputValue !== '';

                if (isFilled) {
                    checkedCount++;
                    const selisih = stokFisik - stokSistem;
                    
                    // Update tampilan selisih
                    selisihOutput.textContent = selisih;
                    selisihOutput.className = 'py-4 px-4 text-center font-semibold selisih-output';
                    
                    if (selisih !== 0) {
                        differenceCount++;
                        selisihOutput.classList.add(selisih > 0 ? 'text-green-600' : 'text-red-600');
                    } else {
                         selisihOutput.classList.add('text-gray-700');
                    }

                } else {
                    // Jika belum diisi, kembalikan ke default
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

        // Tambahkan event listener ke semua input
        inputFields.forEach(input => {
            input.addEventListener('input', updateSummary);
        });

        // Panggil sekali saat load untuk inisialisasi jika ada nilai old()
        updateSummary();
    });
</script>
</body>
</html>