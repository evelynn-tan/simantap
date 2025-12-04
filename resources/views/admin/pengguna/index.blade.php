@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('header', 'Manajemen Pengguna')
@section('subtitle', 'Kelola akun pengguna sistem SIMANTAP')

@section('content')
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Pengguna -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl p-6 text-white shadow-lg border border-blue-400">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-semibold uppercase mb-2">Total Pengguna</p>
                    <h3 class="text-4xl font-bold">{{ $totalPengguna }}</h3>
                </div>
                <div class="h-12 w-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Pegawai BPS -->
        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-xl p-6 text-white shadow-lg border border-green-400">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-green-100 text-sm font-semibold uppercase mb-2">Pegawai BPS</p>
                    <h3 class="text-4xl font-bold">{{ $pegawaiBPS }}</h3>
                </div>
                <div class="h-12 w-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-tie text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Operator BMN -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl p-6 text-white shadow-lg border border-orange-400">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-semibold uppercase mb-2">Operator BMN</p>
                    <h3 class="text-4xl font-bold">{{ $operatorBMN }}</h3>
                </div>
                <div class="h-12 w-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-warehouse text-2xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Add Button -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 flex items-center gap-4">
        <div class="flex-1 flex items-center gap-2 bg-slate-50 rounded-lg px-4 py-2.5 border border-slate-200">
            <i class="fas fa-search text-slate-400"></i>
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Cari nama atau email..." 
                class="bg-transparent flex-1 text-sm text-slate-700 outline-none"
                style="font-family: 'Poppins', sans-serif;"
            >
        </div>
        <button 
            type="button"
            onclick="openTambahPenggunaModal()"
            class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-sm transition duration-200">
            <i class="fas fa-plus mr-2"></i> Tambah Pengguna
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="penggunaTable">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">NIP</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($users as $user)
                    <tr class="hover:bg-slate-50 transition pengguna-row" data-name="{{ strtolower($user->pegawai->nama_lengkap ?? $user->operator->nama_lengkap ?? '') }}" data-email="{{ strtolower($user->email) }}">
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            {{ $user->pegawai->nama_lengkap ?? $user->operator->nama_lengkap ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-slate-700">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                @if($user->role_display === 'Admin') bg-red-100 text-red-800
                                @elseif($user->role_display === 'Pegawai BPS') bg-green-100 text-green-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ $user->role_display }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-700">{{ $user->pegawai->jabatan ?? $user->operator->jabatan ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-slate-700 font-mono">{{ $user->pegawai->nip ?? $user->operator->nip ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex gap-2 justify-center">
                                <button 
                                    type="button"
                                    onclick="openEditPenggunaModal({{ $user->userID }})"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-sm font-semibold transition duration-200"
                                    title="Edit">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <button 
                                    type="button"
                                    onclick="openHapusPenggunaModal({{ $user->userID }}, '{{ $user->pegawai->nama_lengkap ?? $user->operator->nama_lengkap ?? $user->email }}')"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-semibold transition duration-200"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fas fa-inbox text-4xl text-slate-300 mb-3"></i>
                            <p class="text-slate-500 font-medium">Belum ada data pengguna</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Edit Pengguna -->
<div id="editPenggunaModal" x-cloak style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-edit"></i> Edit Pengguna
            </h3>
            <button onclick="closeEditPenggunaModal()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-1 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <form id="editPenggunaForm" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input type="email" id="editEmail" name="email" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" style="font-family: 'Poppins', sans-serif;">
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeEditPenggunaModal()" class="flex-1 px-4 py-2.5 border border-slate-300 text-slate-700 font-semibold rounded-lg hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus Pengguna -->
<div id="hapusPenggunaModal" x-cloak style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-exclamation-triangle"></i> Hapus Pengguna
            </h3>
            <button onclick="closeHapusPenggunaModal()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-1 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <p class="text-sm text-red-800">
                    <strong>⚠️ Perhatian!</strong> Anda akan menghapus pengguna:
                </p>
                <p class="font-bold text-red-900 mt-2" id="hapusNamaPengguna">-</p>
            </div>
            <form id="hapusPenggunaForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeHapusPenggunaModal()" class="flex-1 px-4 py-2.5 border border-slate-300 text-slate-700 font-semibold rounded-lg hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i> Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengguna (redirect ke create page) -->
<script style="font-family: 'Poppins', sans-serif;">
function openEditPenggunaModal(userId) {
    // Redirect to edit page
    window.location.href = `/admin/pengguna/${userId}/edit`;
}

function closeEditPenggunaModal() {
    document.getElementById('editPenggunaModal').style.display = 'none';
}

function openHapusPenggunaModal(userId, nama) {
    document.getElementById('hapusNamaPengguna').textContent = nama;
    document.getElementById('hapusPenggunaForm').action = `/admin/pengguna/${userId}`;
    document.getElementById('hapusPenggunaModal').style.display = 'flex';
}

function closeHapusPenggunaModal() {
    document.getElementById('hapusPenggunaModal').style.display = 'none';
}

function openTambahPenggunaModal() {
    window.location.href = '{{ route("admin.pengguna.create") }}';
}

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.pengguna-row');
    
    rows.forEach(row => {
        const name = row.getAttribute('data-name');
        const email = row.getAttribute('data-email');
        
        if (name.includes(searchTerm) || email.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Close modals on outside click
document.addEventListener('click', function(event) {
    const editModal = document.getElementById('editPenggunaModal');
    const hapusModal = document.getElementById('hapusPenggunaModal');
    
    if (event.target === editModal) {
        closeEditPenggunaModal();
    }
    if (event.target === hapusModal) {
        closeHapusPenggunaModal();
    }
});
</script>

@endsection