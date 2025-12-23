

<?php $__env->startSection('header', 'Edit Data Barang'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl">
    <div class="mb-6">
        <p class="text-gray-600"><?php echo e($barang->namaBarang); ?></p>
    </div>

    <?php if($errors->any()): ?>
        <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">Oops! Ada kesalahan:</span>
            <ul class="mt-1.5 ml-4 list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="<?php echo e(route('admin.barang.update', $barang->barangID)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="kode_barang" class="block mb-2 text-sm font-medium text-gray-900">Kode Barang (Auto-generated)</label>
                    <input type="text" id="kode_barang" class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" value="<?php echo e($barang->kode_barang); ?>" readonly disabled>
                    <p class="text-gray-500 text-xs mt-1">Kode barang dibuat otomatis</p>
                </div>

                <div>
                    <label for="namaBarang" class="block mb-2 text-sm font-medium text-gray-900">Nama Barang *</label>
                    <input type="text" name="namaBarang" id="namaBarang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?php echo e(old('namaBarang', $barang->namaBarang)); ?>" required>
                    <?php $__errorArgs = ['namaBarang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="kategori_id" class="block mb-2 text-sm font-medium text-gray-900">Kategori *</label>
                    <select id="kategori_id" name="kategori_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="">Pilih kategori barang</option>
                        <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kategori->categoryID); ?>" <?php if(old('kategori_id', $barang->categoryID) == $kategori->categoryID): echo 'selected'; endif; ?>>
                                <?php echo e($kategori->nama_kategori); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['kategori_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="satuan" class="block mb-2 text-sm font-medium text-gray-900">Satuan *</label>
                    <select name="satuan" id="satuan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="">Pilih satuan barang</option>
                        <?php $__currentLoopData = $satuanOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $satuan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($satuan); ?>" <?php if(old('satuan', $barang->satuan) == $satuan): echo 'selected'; endif; ?>>
                                <?php echo e(ucfirst($satuan)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['satuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="mb-6">
                <label for="stok" class="block mb-2 text-sm font-medium text-gray-900">Stok *</label>
                <div class="flex gap-3 items-end">
                    <div class="flex-1">
                        <input type="number" name="stok" id="stok" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?php echo e(old('stok', $barang->stok)); ?>" required min="0">
                        <?php $__errorArgs = ['stok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="px-3 py-2 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-700 font-medium">
                        Status: <span class="font-bold"><?php echo e(ucfirst($barang->status)); ?></span>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi (Opsional)</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('deskripsi', $barang->deskripsi)); ?></textarea>
                <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Perubahan</button>
                <a href="<?php echo e(route('admin.barang.index')); ?>" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\FILE TINGKAT 3\SEMESTER 5\REKAYASA PERANGKAT LUNAK (RPL)\simantap\resources\views\admin\barang\edit.blade.php ENDPATH**/ ?>