<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Pengajuan Permintaan Barang
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Tampilkan error validasi -->
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
            <?php if(session('error')): ?>
                <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                    <span class="font-medium">Error!</span> <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('pegawai.permintaan.ajukan')); ?>" method="POST" class="bg-white shadow-md rounded-lg p-6" x-data="formPermintaan()">
                <?php echo csrf_field(); ?>
                <h3 class="text-lg font-semibold mb-6">Form Pengajuan</h3>

                <!-- Keperluan -->
                <div class="mb-6">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Keperluan *</label>
                    <textarea id="description" name="description" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan untuk apa barang ini dibutuhkan..." required><?php echo e(old('description')); ?></textarea>
                </div>
                
                <!-- Daftar Barang yang Diajukan -->
                <h3 class="text-lg font-semibold mb-4">Barang yang Diajukan</h3>
                <div id="items-container" class="space-y-4">
                    <!-- Baris Item akan ditambahkan oleh Alpine.js -->
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex items-center gap-4 p-4 border rounded-lg">
                            <div class="flex-1">
                                <label class="block mb-2 text-sm font-medium text-gray-900">Barang *</label>
                                <select :name="'items[' + index + '][barangID]'" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                    <option value="">-- Pilih Barang --</option>
                                    <?php $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($barang->barangID); ?>"><?php echo e($barang->namaBarang); ?> (Stok: <?php echo e($barang->stok_sekarang); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="w-1/4">
                                <label class="block mb-2 text-sm font-medium text-gray-900">Jumlah *</label>
                                <input type="number" :name="'items[' + index + '][jumlah]'" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="1" min="1" required>
                            </div>
                            <button type="button" @click="removeItem(index)" class="text-red-600 hover:text-red-800 self-end mb-2.5">
                                Hapus
                            </button>
                        </div>
                    </template>
                </div>

                <button type="button" @click="addItem" class="mt-4 text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">
                    + Tambah Barang Lain
                </button>

                <hr class="my-6">

                <div class="flex justify-end gap-4">
                    <a href="<?php echo e(route('pegawai.daftar-barang')); ?>" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Alpine.js untuk form dinamis -->
    <script>
        function formPermintaan() {
            return {
                items: [{}], // Mulai dengan 1 item kosong
                addItem() {
                    this.items.push({});
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                }
            }
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH E:\FILE TINGKAT 3\SEMESTER 5\REKAYASA PERANGKAT LUNAK (RPL)\simantap\resources\views\pegawai\create.blade.php ENDPATH**/ ?>