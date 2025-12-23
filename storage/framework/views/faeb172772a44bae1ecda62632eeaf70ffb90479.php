
<?php $__env->startSection('title', 'Edit Pengguna'); ?>
<?php $__env->startSection('header', 'Edit Pengguna'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
                <form action="<?php echo e(route('admin.pengguna.update', $pengguna->userID)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap *</label>
                            <input type="text" name="name" id="name" value="<?php echo e(old('name', $pengguna->pegawai->nama_lengkap ?? $pengguna->operator->nama_lengkap ?? '')); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email *</label>
                            <input type="email" name="email" id="email" value="<?php echo e(old('email', $pengguna->email)); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div>
                            <label for="jabatan" class="block mb-2 text-sm font-medium text-gray-900">Jabatan *</label>
                            <input type="text" name="jabatan" id="jabatan" value="<?php echo e(old('jabatan', $pengguna->pegawai->jabatan ?? $pengguna->operator->jabatan ?? '')); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div>
                            <label for="nip" class="block mb-2 text-sm font-medium text-gray-900">NIP *</label>
                            <input type="text" name="nip" id="nip" value="<?php echo e(old('nip', $pengguna->pegawai->nip ?? $pengguna->operator->nip ?? '')); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div id="divisi-field" style="display: <?php echo e(old('role', $pengguna->role) == 'pegawai' ? 'block' : 'none'); ?>;">
                            <label for="divisi" class="block mb-2 text-sm font-medium text-gray-900">Divisi *</label>
                            <input type="text" name="divisi" id="divisi" value="<?php echo e(old('divisi', $pengguna->pegawai->divisi ?? '')); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" <?php echo e(old('role', $pengguna->role) == 'pegawai' ? 'required' : ''); ?>>
                        </div>
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role *</label>
                            <select id="role" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="pegawai" <?php echo e(old('role', $pengguna->role) == 'pegawai' ? 'selected' : ''); ?>>Pegawai BPS</option>
                                <option value="operator" <?php echo e(old('role', $pengguna->role) == 'operator' ? 'selected' : ''); ?>>Operator BMN</option>
                            </select>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Update Pengguna</button>
                        <a href="<?php echo e(route('admin.pengguna.index')); ?>" class="ml-4 text-gray-600 hover:text-gray-800">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function() {
            var divisiField = document.getElementById('divisi-field');
            var divisiInput = document.getElementById('divisi');
            if (this.value === 'pegawai') {
                divisiField.style.display = 'block';
                divisiInput.setAttribute('required', 'required');
            } else {
                divisiField.style.display = 'none';
                divisiInput.removeAttribute('required');
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\FILE TINGKAT 3\SEMESTER 5\REKAYASA PERANGKAT LUNAK (RPL)\simantap\resources\views\admin\pengguna\edit.blade.php ENDPATH**/ ?>