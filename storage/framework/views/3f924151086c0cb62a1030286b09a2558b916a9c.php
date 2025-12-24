

<?php $__env->startSection('title', 'Monitor Status Permintaan - SIMANTAP'); ?>
<?php $__env->startSection('page-title', 'Monitor Status Permintaan'); ?>
<?php $__env->startSection('page-subtitle', 'Pantau status permintaan barang yang telah Anda ajukan'); ?>

<?php $__env->startPush('styles'); ?>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    
    .alert-auto-hide {
        animation: fadeInOut 5s ease-in-out forwards;
    }
    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateY(-20px); }
        10% { opacity: 1; transform: translateY(0); }
        90% { opacity: 1; transform: translateY(0); }
        100% { opacity: 0; transform: translateY(-20px); }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div x-data="{ showConfirmModal: false, cancelId: null }">
    
    <?php if(session('success')): ?>
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 flex items-center gap-3 alert-auto-hide">
        <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
        <p class="font-medium"><?php echo e(session('success')); ?></p>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 flex items-center gap-3 alert-auto-hide">
        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
        <p class="font-medium"><?php echo e(session('error')); ?></p>
    </div>
    <?php endif; ?>

    
    <div class="mb-6">
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Monitor Status Permintaan</h1>
                        <p class="text-emerald-100 text-sm">Pantau status permintaan barang yang telah Anda ajukan</p>
                    </div>
                </div>

                
                <form method="GET" action="<?php echo e(route('pegawai.monitor-permintaan')); ?>" class="flex flex-wrap items-center gap-2">
                    <select name="status" class="px-3 py-2 border-0 rounded-lg text-sm text-slate-700 focus:ring-2 focus:ring-white" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="menunggu" <?php echo e(request('status') == 'menunggu' ? 'selected' : ''); ?>>Menunggu</option>
                        <option value="disetujui" <?php echo e(request('status') == 'disetujui' ? 'selected' : ''); ?>>Disetujui</option>
                        <option value="ditolak" <?php echo e(request('status') == 'ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                        <option value="dibatalkan" <?php echo e(request('status') == 'dibatalkan' ? 'selected' : ''); ?>>Dibatalkan</option>
                    </select>
                    <div class="flex items-center gap-1">
                        <div class="relative">
                            <input type="date" name="tanggal_mulai" value="<?php echo e(request('tanggal_mulai')); ?>" 
                                class="px-3 py-2 border-0 rounded-lg text-sm text-slate-700 min-w-[130px]"
                                title="Tanggal Mulai">
                            <span class="absolute -top-2 left-2 text-[10px] text-white/80 bg-emerald-700 px-1 rounded hidden sm:inline">Dari</span>
                        </div>
                        <span class="text-white/70 px-1">-</span>
                        <div class="relative">
                            <input type="date" name="tanggal_selesai" value="<?php echo e(request('tanggal_selesai')); ?>" 
                                class="px-3 py-2 border-0 rounded-lg text-sm text-slate-700 min-w-[130px]"
                                title="Tanggal Selesai">
                            <span class="absolute -top-2 left-2 text-[10px] text-white/80 bg-emerald-700 px-1 rounded hidden sm:inline">Sampai</span>
                        </div>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition flex items-center gap-2">
                        <i class="fas fa-filter"></i> <span class="hidden sm:inline">Filter</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Barang</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Keperluan</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $permintaan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <?php echo e($p->created_at->timezone('Asia/Jakarta')->format('h:i A d M Y')); ?>

                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php $__currentLoopData = $p->pengajuanDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-1">
                                <span class="font-semibold text-slate-800"><?php echo e($detail->barang->namaBarang ?? 'Barang tidak ditemukan'); ?></span>
                                <br>
                                <span class="text-xs text-slate-400">Kode: <?php echo e($detail->barang->kode_barang ?? '-'); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <?php $__currentLoopData = $p->pengajuanDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-1">
                                <?php echo e($detail->jumlah); ?> <?php echo e($detail->barang->satuan ?? 'unit'); ?>

                                <?php if($detail->jumlah_disetujui && $detail->jumlah_disetujui != $detail->jumlah): ?>
                                    <span class="text-xs text-emerald-600">(Disetujui: <?php echo e($detail->jumlah_disetujui); ?>)</span>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 max-w-xs">
                            <?php echo e(Str::limit($p->description, 50)); ?>

                            <?php if($p->alasan_penolakan): ?>
                                <br><span class="text-xs text-red-500">Alasan: <?php echo e(Str::limit($p->alasan_penolakan, 30)); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if($p->status == 'menunggu'): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                    <i class="fas fa-clock mr-1.5"></i>Menunggu
                                </span>
                            <?php elseif($p->status == 'disetujui'): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    <i class="fas fa-check mr-1.5"></i>Disetujui
                                </span>
                            <?php elseif($p->status == 'dibatalkan'): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                    <i class="fas fa-ban mr-1.5"></i>Dibatalkan
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <i class="fas fa-times mr-1.5"></i>Ditolak
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if($p->status == 'menunggu'): ?>
                                <button 
                                    @click="cancelId = <?php echo e($p->pengajuanID); ?>; showConfirmModal = true"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition"
                                >
                                    <i class="fas fa-times-circle mr-1.5"></i>Batalkan
                                </button>
                            <?php else: ?>
                                <span class="text-slate-400 text-xs">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-clipboard-list text-5xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500 font-medium">Belum ada permintaan</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="px-6 py-4 border-t bg-slate-50">
            <?php echo e($permintaan->appends(request()->query())->links()); ?>

        </div>
    </div>

    
    <div 
        x-show="showConfirmModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        
        <div 
            x-show="showConfirmModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm"
            @click="showConfirmModal = false"
        ></div>

        
        <div 
            x-show="showConfirmModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden"
        >
            <div class="p-6 text-center">
                
                <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
                </div>

                
                <h3 class="text-xl font-bold text-slate-800 mb-2">Batalkan Pengajuan?</h3>
                <p class="text-slate-500 text-sm mb-6">
                    Anda yakin ingin membatalkan pengajuan ini? Tindakan ini tidak dapat dibatalkan.
                </p>

                
                <div class="flex gap-3">
                    <button 
                        @click="showConfirmModal = false"
                        class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition"
                    >
                        Tidak, Kembali
                    </button>
                    <form :action="'/pegawai/permintaan/' + cancelId + '/batal'" method="POST" class="flex-1">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button 
                            type="submit"
                            class="w-full px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition"
                        >
                            Ya, Batalkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pegawai-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\FILE TINGKAT 3\SEMESTER 5\REKAYASA PERANGKAT LUNAK (RPL)\simantap\resources\views/pegawai/monitor-permintaan.blade.php ENDPATH**/ ?>