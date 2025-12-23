
<?php $__env->startSection('title', 'Detail Stock Opname - SIMANTAP'); ?>
<?php $__env->startSection('header', 'Detail Stock Opname'); ?>
<?php $__env->startSection('subtitle', 'Rincian hasil pengecekan stok barang'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

    <a href="<?php echo e(route('admin.stock-opname.index')); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
    </a>

    <div class="bg-gradient-to-r from-teal-500 to-cyan-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="h-12 w-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-clipboard-check text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">OP-<?php echo e(str_pad($opname->opnameID ?? 0, 4, '0', STR_PAD_LEFT)); ?></h2>
                        <p class="text-teal-100 text-sm">ID Stock Opname</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-4 text-sm">
                <div class="bg-white/20 rounded-lg px-4 py-2 backdrop-blur-sm">
                    <p class="text-teal-100 text-xs">Tanggal Opname</p>
                    <p class="font-semibold"><?php echo e($opname->tanggal_opname?->timezone('Asia/Jakarta')->format('d M Y') ?? 'N/A'); ?></p>
                </div>
                <div class="bg-white/20 rounded-lg px-4 py-2 backdrop-blur-sm">
                    <p class="text-teal-100 text-xs">Operator</p>
                    <p class="font-semibold"><?php echo e($opname->user->email ?? 'Unknown'); ?></p>
                </div>
                <div class="bg-white/20 rounded-lg px-4 py-2 backdrop-blur-sm">
                    <p class="text-teal-100 text-xs">Total Diperiksa</p>
                    <p class="font-semibold"><?php echo e($opname->details->count()); ?> barang</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Total Barang Diperiksa</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1"><?php echo e($opname->details->count()); ?></p>
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-boxes text-xl text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <?php
            $selisihCount = $opname->details->where('stok_selisih', '!=', 0)->count();
            $sesuaiCount = $opname->details->where('stok_selisih', 0)->count();
        ?>
        
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Stok Sesuai</p>
                    <p class="text-3xl font-bold text-green-600 mt-1"><?php echo e($sesuaiCount); ?></p>
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
                    <p class="text-3xl font-bold <?php echo e($selisihCount > 0 ? 'text-orange-600' : 'text-slate-800'); ?> mt-1"><?php echo e($selisihCount); ?></p>
                </div>
                <div class="h-12 w-12 <?php echo e($selisihCount > 0 ? 'bg-orange-100' : 'bg-slate-100'); ?> rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-xl <?php echo e($selisihCount > 0 ? 'text-orange-600' : 'text-slate-400'); ?>"></i>
                </div>
            </div>
        </div>
    </div>

    <?php if($opname->keterangan): ?>
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <i class="fas fa-sticky-note text-blue-500 mt-1"></i>
            <div>
                <p class="font-semibold text-blue-800 text-sm">Catatan Opname:</p>
                <p class="text-blue-700 text-sm mt-1"><?php echo e($opname->keterangan); ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
            <h3 class="text-lg font-bold text-slate-800">📋 Daftar Barang yang Diperiksa</h3>
            <p class="text-sm text-slate-500 mt-1">Rincian stok sistem vs stok fisik</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Nama Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Stok Sistem</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Stok Fisik</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Selisih</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php $__currentLoopData = $opname->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-medium text-slate-600"><?php echo e($loop->iteration); ?></td>
                        <td class="px-6 py-4 font-mono font-bold text-slate-800"><?php echo e($detail->barang->kode_barang ?? '-'); ?></td>
                        <td class="px-6 py-4 font-medium text-slate-800"><?php echo e($detail->barang->namaBarang ?? 'Barang Dihapus'); ?></td>
                        <td class="px-6 py-4 text-slate-600"><?php echo e($detail->barang->kategori->nama_kategori ?? '-'); ?></td>
                        <td class="px-6 py-4 text-center font-semibold text-slate-700"><?php echo e($detail->stok_sistem); ?></td>
                        <td class="px-6 py-4 text-center font-semibold text-blue-600"><?php echo e($detail->stok_fisik); ?></td>
                        <td class="px-6 py-4 text-center font-bold 
                            <?php if($detail->stok_selisih > 0): ?>
                                text-green-600
                            <?php elseif($detail->stok_selisih < 0): ?>
                                text-red-600
                            <?php else: ?>
                                text-slate-500
                            <?php endif; ?>
                        ">
                            <?php if($detail->stok_selisih > 0): ?>
                                +<?php echo e($detail->stok_selisih); ?>

                            <?php else: ?>
                                <?php echo e($detail->stok_selisih); ?>

                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if($detail->stok_selisih == 0): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Sesuai
                                </span>
                            <?php elseif($detail->stok_selisih > 0): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    <i class="fas fa-plus-circle mr-1"></i> Lebih
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-minus-circle mr-1"></i> Kurang
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end gap-3">
        <a href="<?php echo e(route('admin.stock-opname.index')); ?>" class="inline-flex items-center px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg text-sm transition">
            <i class="fas fa-list mr-2"></i> Lihat Semua Opname
        </a>
        <a href="<?php echo e(route('admin.stock-opname.create')); ?>" class="inline-flex items-center px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg text-sm transition">
            <i class="fas fa-plus mr-2"></i> Opname Baru
        </a>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\FILE TINGKAT 3\SEMESTER 5\REKAYASA PERANGKAT LUNAK (RPL)\simantap\resources\views\admin\stock-opname\show.blade.php ENDPATH**/ ?>