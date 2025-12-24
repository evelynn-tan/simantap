

<?php $__env->startSection('title', 'Stock Opname - SIMANTAP'); ?>
<?php $__env->startSection('header', 'Stock Opname'); ?>
<?php $__env->startSection('subtitle', 'Pengecekan fisik dan penyesuaian stok barang'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

    <!-- Info Card - New Session -->
    <div class="bg-gradient-to-r from-teal-500 to-cyan-600 rounded-xl shadow-lg p-4 sm:p-5 lg:p-6 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="flex items-start gap-4">
                <div class="h-14 w-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-clipboard-check text-3xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-1">Mulai Sesi Stock Opname</h3>
                    <p class="text-teal-100 text-sm mb-2">
                        Lakukan pengecekan fisik untuk <strong class="text-white"><?php echo e(\App\Models\Barang::count()); ?> barang</strong> dalam sistem
                    </p>
                    <p class="text-teal-200 text-xs flex items-center gap-1">
                        <i class="fas fa-info-circle"></i>
                        Stock opname akan mencatat perbedaan stok dan membuat transaksi penyesuaian otomatis
                    </p>
                </div>
            </div>
            <a href="<?php echo e(route('admin.stock-opname.create')); ?>" class="inline-flex items-center px-6 py-3 bg-white text-teal-700 hover:bg-teal-50 font-bold rounded-xl text-sm transition duration-200 shadow-lg hover:shadow-xl whitespace-nowrap">
                <i class="fas fa-plus-circle mr-2 text-lg"></i> Mulai Opname Baru
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Total Opname</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1"><?php echo e($riwayatOpname->total()); ?></p>
                </div>
                <div class="h-12 w-12 bg-teal-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-xl text-teal-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Bulan Ini</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1">
                        <?php echo e(\App\Models\StockOpname::whereMonth('tanggal_opname', now()->month)->whereYear('tanggal_opname', now()->year)->count()); ?>

                    </p>
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-xl text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Total Barang</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1"><?php echo e(\App\Models\Barang::count()); ?></p>
                </div>
                <div class="h-12 w-12 bg-slate-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-boxes text-xl text-slate-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Opname -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
            <h3 class="text-lg font-bold text-slate-800">📋 Riwayat Stock Opname</h3>
            <p class="text-sm text-slate-500 mt-1">Daftar semua sesi stock opname yang telah dilakukan</p>
        </div>

        <?php if($riwayatOpname->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-[10px] sm:text-xs font-bold text-slate-600 uppercase">ID Opname</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-[10px] sm:text-xs font-bold text-slate-600 uppercase">Tanggal</th>
                        <th class="hidden md:table-cell px-3 sm:px-4 lg:px-6 py-3 text-left text-[10px] sm:text-xs font-bold text-slate-600 uppercase">Operator</th>
                        <th class="hidden sm:table-cell px-3 sm:px-4 lg:px-6 py-3 text-center text-[10px] sm:text-xs font-bold text-slate-600 uppercase">Total Item</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-center text-[10px] sm:text-xs font-bold text-slate-600 uppercase">Selisih</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-center text-[10px] sm:text-xs font-bold text-slate-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php $__currentLoopData = $riwayatOpname; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $selisihCount = $opname->details()->where('stok_selisih', '!=', 0)->count();
                        $totalItems = $opname->details()->count();
                    ?>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-teal-700 bg-teal-50 px-2 py-1 rounded">
                                OP-<?php echo e(str_pad($opname->opnameID, 4, '0', STR_PAD_LEFT)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-700">
    <div class="font-medium">
        <?php echo e($opname->tanggal_opname?->timezone('Asia/Jakarta')->format('d M Y') ?? 'N/A'); ?>

    </div>
    <div class="text-xs text-slate-500">
        <?php echo e($opname->created_at?->timezone('Asia/Jakarta')->format('H:i') ?? 'N/A'); ?> WIB
    </div>
</td>
                        <td class="px-6 py-4 text-slate-700 font-medium">
                            <?php echo e($opname->user->email ?? '-'); ?>

                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-semibold text-slate-800"><?php echo e($totalItems); ?></span>
                            <span class="text-slate-500 text-xs">barang</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if($selisihCount > 0): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                    <i class="fas fa-exclamation-circle mr-1"></i> <?php echo e($selisihCount); ?> item
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Sesuai
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex gap-2 justify-center">
                                <a 
                                    href="<?php echo e(route('admin.stock-opname.show', $opname->opnameID)); ?>"
                                    class="inline-flex items-center px-3 py-1.5 bg-teal-100 text-teal-700 hover:bg-teal-200 rounded-lg text-sm font-semibold transition duration-200"
                                    title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="<?php echo e(route('admin.stock-opname.destroy', $opname->opnameID)); ?>" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus record Stock Opname ini?\n\nPerhatian: Stok barang yang sudah disesuaikan tidak akan dikembalikan!')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button 
                                        type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-semibold transition duration-200"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            <?php echo e($riwayatOpname->links()); ?>

        </div>
        <?php else: ?>
        <div class="px-6 py-16 text-center">
            <div class="max-w-sm mx-auto">
                <div class="h-20 w-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clipboard-list text-4xl text-slate-400"></i>
                </div>
                <h4 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Riwayat</h4>
                <p class="text-sm text-slate-500 mb-4">Belum ada sesi stock opname yang tercatat. Mulai sesi opname pertama Anda!</p>
                <a href="<?php echo e(route('admin.stock-opname.create')); ?>" class="inline-flex items-center px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg text-sm transition">
                    <i class="fas fa-plus mr-2"></i> Mulai Opname
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\FILE TINGKAT 3\SEMESTER 5\REKAYASA PERANGKAT LUNAK (RPL)\simantap\resources\views/admin/stock-opname/index.blade.php ENDPATH**/ ?>