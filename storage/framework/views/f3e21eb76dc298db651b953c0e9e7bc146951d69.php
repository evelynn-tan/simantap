

<?php $__env->startSection('title', 'Tambah Data Barang - SIMANTAP'); ?>
<?php $__env->startSection('header', 'Tambah Data Barang Baru'); ?>
<?php $__env->startSection('subtitle', 'Tambahkan barang baru ke dalam sistem inventori'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;" x-data="createBarangForm()">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Form Column -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800">📝 Form Tambah Barang</h2>
                    <p class="text-sm text-slate-500 mt-1">Isi semua informasi barang yang akan ditambahkan</p>
                </div>

                <form action="<?php echo e(route('admin.barang.store')); ?>" method="POST" class="p-6 space-y-5">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Nama Barang with Duplicate Check -->
                    <div>
                        <label for="namaBarang" class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang *</label>
                        <input 
                            type="text" 
                            name="namaBarang" 
                            id="namaBarang" 
                            x-model="namaBarang"
                            @input.debounce.500ms="checkDuplicate"
                            class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                            placeholder="Contoh: Kertas HVS A4 80 gram" 
                            value="<?php echo e(old('namaBarang')); ?>" 
                            required
                        >
                        <?php $__errorArgs = ['namaBarang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1.5"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <!-- Duplicate Warning -->
                        <div x-show="duplicates.length > 0" x-transition class="mt-3 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-exclamation-triangle text-amber-500 mt-0.5"></i>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-amber-800 mb-2">⚠️ Barang dengan nama serupa sudah ada!</p>
                                    <p class="text-xs text-amber-700 mb-3">Apakah Anda ingin menambah stok ke barang yang sudah ada? Atau lanjutkan buat barang baru?</p>
                                    
                                    <div class="space-y-2">
                                        <template x-for="item in duplicates" :key="item.barangID">
                                            <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-amber-200">
                                                <div>
                                                    <p class="font-semibold text-slate-800" x-text="item.namaBarang"></p>
                                                    <p class="text-xs text-slate-500">
                                                        <span class="font-mono bg-slate-100 px-1 rounded" x-text="item.kode_barang"></span> • 
                                                        <span x-text="item.kategori?.nama_kategori || '-'"></span> • 
                                                        Stok: <span x-text="item.stok"></span> <span x-text="item.satuan"></span>
                                                    </p>
                                                </div>
                                                <a :href="'/admin/barang/' + item.barangID + '/edit'" 
                                                   class="px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-xs font-semibold transition">
                                                    <i class="fas fa-edit mr-1"></i> Edit/Tambah Stok
                                                </a>
                                            </div>
                                        </template>
                                    </div>
                                    
                                    <button type="button" @click="ignoreDuplicate = true; duplicates = []" 
                                            class="mt-3 text-xs text-amber-600 hover:text-amber-800 font-medium">
                                        <i class="fas fa-arrow-right mr-1"></i> Lanjutkan buat barang baru
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori & Satuan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="kategori_id" class="block text-sm font-semibold text-slate-700 mb-2">Kategori *</label>
                            <select 
                                id="kategori_id" 
                                name="kategori_id" 
                                x-model="kategoriId"
                                class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                required
                            >
                                <option value="">-- Pilih Kategori --</option>
                                <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($kategori->categoryID); ?>" <?php echo e(old('kategori_id') == $kategori->categoryID ? 'selected' : ''); ?>>
                                        <?php echo e($kategori->nama_kategori); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <!-- Suggestion from duplicate -->
                            <p x-show="suggestedKategori" class="text-xs text-blue-600 mt-1">
                                💡 Saran: <span x-text="suggestedKategori"></span>
                            </p>
                            <?php $__errorArgs = ['kategori_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1.5"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="satuan" class="block text-sm font-semibold text-slate-700 mb-2">Satuan *</label>
                            <select 
                                id="satuan" 
                                name="satuan" 
                                x-model="satuan"
                                class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                required
                            >
                                <option value="">-- Pilih Satuan --</option>
                                <option value="rim" <?php echo e(old('satuan') == 'rim' ? 'selected' : ''); ?>>Rim</option>
                                <option value="pcs" <?php echo e(old('satuan') == 'pcs' ? 'selected' : ''); ?>>PCS</option>
                                <option value="buah" <?php echo e(old('satuan') == 'buah' ? 'selected' : ''); ?>>Buah</option>
                                <option value="box" <?php echo e(old('satuan') == 'box' ? 'selected' : ''); ?>>Box</option>
                                <option value="pack" <?php echo e(old('satuan') == 'pack' ? 'selected' : ''); ?>>Pack</option>
                                <option value="set" <?php echo e(old('satuan') == 'set' ? 'selected' : ''); ?>>Set</option>
                                <option value="lembar" <?php echo e(old('satuan') == 'lembar' ? 'selected' : ''); ?>>Lembar</option>
                                <option value="meter" <?php echo e(old('satuan') == 'meter' ? 'selected' : ''); ?>>Meter</option>
                                <option value="kg" <?php echo e(old('satuan') == 'kg' ? 'selected' : ''); ?>>Kg</option>
                                <option value="liter" <?php echo e(old('satuan') == 'liter' ? 'selected' : ''); ?>>Liter</option>
                            </select>
                            <!-- Suggestion from duplicate -->
                            <p x-show="suggestedSatuan" class="text-xs text-blue-600 mt-1">
                                💡 Saran: <span x-text="suggestedSatuan"></span>
                            </p>
                            <?php $__errorArgs = ['satuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1.5"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stok" class="block text-sm font-semibold text-slate-700 mb-2">Stok Awal *</label>
                        <input 
                            type="number" 
                            name="stok" 
                            id="stok" 
                            class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                            placeholder="0" 
                            min="0" 
                            value="<?php echo e(old('stok', 0)); ?>" 
                            required
                        >
                        <?php $__errorArgs = ['stok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1.5"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi (Opsional)</label>
                        <textarea 
                            id="deskripsi" 
                            name="deskripsi" 
                            rows="3" 
                            class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none" 
                            placeholder="Deskripsi tambahan tentang barang..."
                        ><?php echo e(old('deskripsi')); ?></textarea>
                        <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1.5"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-slate-200">
                        <button 
                            type="submit" 
                            class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200"
                        >
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                        <button 
                            type="reset" 
                            @click="resetForm"
                            class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition duration-200"
                        >
                            Reset
                        </button>
                        <a 
                            href="<?php echo e(route('admin.barang.index')); ?>" 
                            class="px-6 py-2.5 bg-slate-100 text-slate-700 hover:bg-slate-200 font-semibold rounded-lg transition duration-200 text-center"
                        >
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Column -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center gap-2 mb-4">
                    <div class="h-10 w-10 bg-blue-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-lg text-blue-700"></i>
                    </div>
                    <h3 class="font-bold text-slate-900">Tips Pengisian</h3>
                </div>

                <ul class="space-y-3 text-sm text-slate-700">
                    <li class="flex gap-2">
                        <span class="text-blue-600 font-bold">•</span>
                        <span><strong>Nama Barang:</strong> Masukkan nama yang jelas dan deskriptif</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-blue-600 font-bold">•</span>
                        <span><strong>Kategori:</strong> Pilih kategori yang sesuai untuk pengelompokan</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-blue-600 font-bold">•</span>
                        <span><strong>Satuan:</strong> Sesuaikan dengan unit pengukuran barang</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-blue-600 font-bold">•</span>
                        <span><strong>Stok Awal:</strong> Input jumlah barang yang tersedia saat ini</span>
                    </li>
                </ul>

                <div class="mt-6 p-4 bg-white rounded-lg border border-blue-200">
                    <p class="text-xs text-slate-600 mb-2">📌 <strong>Catatan:</strong></p>
                    <p class="text-xs text-slate-600">Kode barang akan otomatis di-generate oleh sistem</p>
                </div>

                <div class="mt-4 p-4 bg-amber-50 rounded-lg border border-amber-200">
                    <p class="text-xs text-amber-800">
                        <i class="fas fa-lightbulb mr-1"></i>
                        <strong>Tip:</strong> Jika barang dengan nama yang sama sudah ada, sistem akan memberi peringatan agar tidak terjadi duplikasi data.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
function createBarangForm() {
    return {
        namaBarang: '',
        kategoriId: '',
        satuan: '',
        duplicates: [],
        ignoreDuplicate: false,
        suggestedKategori: '',
        suggestedSatuan: '',
        
        async checkDuplicate() {
            if (this.namaBarang.length < 3 || this.ignoreDuplicate) {
                this.duplicates = [];
                return;
            }
            
            try {
                const response = await fetch(`<?php echo e(route('admin.barang.search')); ?>?q=${encodeURIComponent(this.namaBarang)}&limit=5`);
                const data = await response.json();
                
                if (data.length > 0) {
                    this.duplicates = data;
                    // Set suggestions from first match
                    if (data[0].kategori) {
                        this.suggestedKategori = data[0].kategori.nama_kategori;
                    }
                    if (data[0].satuan) {
                        this.suggestedSatuan = data[0].satuan;
                    }
                } else {
                    this.duplicates = [];
                    this.suggestedKategori = '';
                    this.suggestedSatuan = '';
                }
            } catch (error) {
                console.error('Error checking duplicate:', error);
            }
        },
        
        resetForm() {
            this.namaBarang = '';
            this.kategoriId = '';
            this.satuan = '';
            this.duplicates = [];
            this.ignoreDuplicate = false;
            this.suggestedKategori = '';
            this.suggestedSatuan = '';
        }
    }
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\FILE TINGKAT 3\SEMESTER 5\REKAYASA PERANGKAT LUNAK (RPL)\simantap\resources\views\admin\barang\create.blade.php ENDPATH**/ ?>