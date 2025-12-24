
<?php $__env->startSection('title', 'Manajemen Pengguna'); ?>
<?php $__env->startSection('header', 'Manajemen Pengguna'); ?>
<?php $__env->startSection('subtitle', 'Kelola akun pengguna sistem SIMANTAP'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">
        <!-- Total Pengguna -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl p-4 sm:p-5 lg:p-6 text-white shadow-lg border border-blue-400">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-blue-100 text-[10px] sm:text-xs lg:text-sm font-semibold uppercase mb-1 sm:mb-2">Total Pengguna</p>
                    <h3 class="text-2xl sm:text-3xl lg:text-4xl font-bold"><?php echo e($totalPengguna); ?></h3>
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
                    <h3 class="text-4xl font-bold"><?php echo e($pegawaiBPS); ?></h3>
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
                    <h3 class="text-4xl font-bold"><?php echo e($operatorBMN); ?></h3>
                </div>
                <div class="h-12 w-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-warehouse text-2xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Add Button -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-3 sm:p-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
        <div class="flex-1 flex items-center gap-2 bg-slate-50 rounded-lg px-3 sm:px-4 py-2 sm:py-2.5 border border-slate-200">
            <i class="fas fa-search text-slate-400 text-sm"></i>
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Cari nama atau email..." 
                class="bg-transparent flex-1 text-xs sm:text-sm text-slate-700 outline-none w-full"
                style="font-family: 'Poppins', sans-serif;"
            >
        </div>
        <button 
            type="button"
            onclick="openTambahPenggunaModal()"
            class="inline-flex items-center justify-center px-3 sm:px-4 py-2 sm:py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-xs sm:text-sm transition duration-200 whitespace-nowrap">
            <i class="fas fa-plus mr-1.5 sm:mr-2"></i> <span class="hidden xs:inline">Tambah</span> Pengguna
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="penggunaTable">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-[10px] sm:text-xs font-bold text-slate-600 uppercase">Nama</th>
                        <th class="hidden sm:table-cell px-3 sm:px-4 lg:px-6 py-3 text-left text-[10px] sm:text-xs font-bold text-slate-600 uppercase">Email</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-[10px] sm:text-xs font-bold text-slate-600 uppercase">Role</th>
                        <th class="hidden md:table-cell px-3 sm:px-4 lg:px-6 py-3 text-left text-[10px] sm:text-xs font-bold text-slate-600 uppercase">Jabatan</th>
                        <th class="hidden lg:table-cell px-3 sm:px-4 lg:px-6 py-3 text-left text-[10px] sm:text-xs font-bold text-slate-600 uppercase">NIP</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-center text-[10px] sm:text-xs font-bold text-slate-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50 transition pengguna-row" data-name="<?php echo e(strtolower($user->pegawai->nama_lengkap ?? $user->operator->nama_lengkap ?? '')); ?>" data-email="<?php echo e(strtolower($user->email)); ?>">
                        <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                            <div class="font-semibold text-slate-800 text-xs sm:text-sm"><?php echo e($user->pegawai->nama_lengkap ?? $user->operator->nama_lengkap ?? 'N/A'); ?></div>
                            <div class="text-[10px] sm:hidden text-slate-500 truncate"><?php echo e($user->email); ?></div>
                        </td>
                        <td class="hidden sm:table-cell px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-slate-700 text-xs sm:text-sm"><?php echo e($user->email); ?></td>
                        <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                            <span class="inline-flex items-center px-1.5 sm:px-2.5 py-0.5 rounded-full text-[10px] sm:text-xs font-semibold
                                <?php if($user->role_display === 'Admin'): ?> bg-red-100 text-red-800
                                <?php elseif($user->role_display === 'Pegawai BPS'): ?> bg-green-100 text-green-800
                                <?php else: ?> bg-blue-100 text-blue-800 <?php endif; ?>">
                                <?php echo e($user->role_display); ?>

                            </span>
                        </td>
                        <td class="hidden md:table-cell px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-slate-700 text-xs sm:text-sm"><?php echo e($user->pegawai->jabatan ?? $user->operator->jabatan ?? 'N/A'); ?></td>
                        <td class="hidden lg:table-cell px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-slate-700 font-mono text-xs"><?php echo e($user->pegawai->nip ?? $user->operator->nip ?? 'N/A'); ?></td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex gap-2 justify-center">
                                <button 
                                    type="button"
                                    onclick="openEditPenggunaModal(<?php echo e($user->userID); ?>)"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-sm font-semibold transition duration-200"
                                    title="Edit">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <button 
                                    type="button"
                                    onclick="openHapusPenggunaModal(<?php echo e($user->userID); ?>, '<?php echo e($user->pegawai->nama_lengkap ?? $user->operator->nama_lengkap ?? $user->email); ?>')"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-semibold transition duration-200"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fas fa-inbox text-4xl text-slate-300 mb-3"></i>
                            <p class="text-slate-500 font-medium">Belum ada data pengguna</p>
                        </td>
                    </tr>
                    <?php endif; ?>
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
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
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
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
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
    window.location.href = '<?php echo e(route("admin.pengguna.create")); ?>';
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\FILE TINGKAT 3\SEMESTER 5\REKAYASA PERANGKAT LUNAK (RPL)\simantap\resources\views/admin/pengguna/index.blade.php ENDPATH**/ ?>