

<?php $__env->startSection('title', 'Dashboard Admin'); ?>
<?php $__env->startSection('header', 'Dashboard Operator BMN'); ?>
<?php $__env->startSection('subtitle', 'Ringkasan status aset dan permintaan barang'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">
    
    <!-- Welcome Banner (Fixed: tidak overlap dengan header) -->
    <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 rounded-2xl shadow-xl p-5 text-white relative overflow-hidden">
        <div class="absolute right-0 top-0 opacity-10">
            <svg width="200" height="120" viewBox="0 0 200 120">
                <circle cx="150" cy="60" r="50" fill="white"/>
                <circle cx="180" cy="30" r="25" fill="white"/>
            </svg>
        </div>
        <div class="relative z-10 flex items-center gap-4">
            <div class="hidden sm:flex h-12 w-12 bg-white/20 rounded-xl items-center justify-center backdrop-blur-sm flex-shrink-0">
                <i class="fas fa-chart-pie text-2xl"></i>
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold">Selamat Datang, Operator!</h2>
                <p class="text-blue-200 text-xs mt-0.5">SIMANTAP - BPS Kota Tanjungpinang</p>
                <p class="text-blue-100 text-xs mt-2 flex flex-wrap items-center gap-3">
                    <span>📅 <?php echo e(\Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y')); ?></span>
                    <span>🕐 <span id="live-clock"></span> WIB</span>
                </p>
            </div>
        </div>
    </div>

    <!-- KPI Cards Row 1 (dengan Tooltip Info) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Jenis Aset -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl shadow-sm border border-blue-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-300 cursor-pointer group relative">
            <!-- Info Tooltip -->
            <div class="absolute top-3 right-3 group/tooltip">
                <span class="h-5 w-5 bg-blue-200 hover:bg-blue-300 rounded-full flex items-center justify-center cursor-help transition">
                    <i class="fas fa-info text-xs text-blue-700"></i>
                </span>
                <div class="absolute right-0 top-6 w-56 bg-slate-800 text-white text-xs rounded-lg p-3 hidden group-hover/tooltip:block z-20 shadow-xl">
                    <p class="font-semibold mb-1">📦 Jenis Barang</p>
                    <p class="text-slate-300">Menampilkan total jenis barang yang terdaftar dalam sistem inventaris dan total keseluruhan unit stok.</p>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-xs font-semibold uppercase tracking-wider">Jenis Barang</p>
                    <p class="text-3xl font-bold text-blue-900 mt-1 group-hover:text-blue-700 transition"><?php echo e($jumlahJenisAset ?? 0); ?></p>
                    <p class="text-xs text-blue-700 mt-2">Total: <span class="font-bold"><?php echo e(number_format($totalStok ?? 0)); ?> unit</span></p>
                </div>
                <div class="h-12 w-12 bg-blue-200 group-hover:bg-blue-300 rounded-xl flex items-center justify-center transition">
                    <i class="fas fa-boxes text-2xl text-blue-700"></i>
                </div>
            </div>
        </div>

        <!-- Menunggu Proses -->
        <a href="<?php echo e(route('admin.permintaan.index')); ?>" class="bg-gradient-to-br from-yellow-50 to-amber-100 p-5 rounded-xl shadow-sm border border-yellow-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-300 group relative <?php echo e(($permintaanBaru ?? 0) > 0 ? 'animate-pulse' : ''); ?>">
            <!-- Info Tooltip -->
            <div class="absolute top-3 right-3 group/tooltip" onclick="event.preventDefault(); event.stopPropagation();">
                <span class="h-5 w-5 bg-yellow-200 hover:bg-yellow-300 rounded-full flex items-center justify-center cursor-help transition">
                    <i class="fas fa-info text-xs text-yellow-700"></i>
                </span>
                <div class="absolute right-0 top-6 w-56 bg-slate-800 text-white text-xs rounded-lg p-3 hidden group-hover/tooltip:block z-20 shadow-xl">
                    <p class="font-semibold mb-1">⏳ Menunggu Proses</p>
                    <p class="text-slate-300">Jumlah permintaan barang dari pegawai yang belum ditinjau. Klik untuk langsung memproses.</p>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-700 text-xs font-semibold uppercase tracking-wider">Menunggu Proses</p>
                    <p class="text-3xl font-bold text-yellow-900 mt-1"><?php echo e($permintaanBaru ?? 0); ?></p>
                    <p class="text-xs text-yellow-800 mt-2 font-semibold">⚠️ Perlu tindakan</p>
                </div>
                <div class="h-12 w-12 bg-yellow-200 group-hover:bg-yellow-300 rounded-xl flex items-center justify-center transition">
                    <i class="fas fa-hourglass-half text-2xl text-yellow-700"></i>
                </div>
            </div>
        </a>

        <!-- Stok Rendah -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 p-5 rounded-xl shadow-sm border border-red-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-300 cursor-pointer group relative">
            <!-- Info Tooltip -->
            <div class="absolute top-3 right-3 group/tooltip">
                <span class="h-5 w-5 bg-red-200 hover:bg-red-300 rounded-full flex items-center justify-center cursor-help transition">
                    <i class="fas fa-info text-xs text-red-700"></i>
                </span>
                <div class="absolute right-0 top-6 w-56 bg-slate-800 text-white text-xs rounded-lg p-3 hidden group-hover/tooltip:block z-20 shadow-xl">
                    <p class="font-semibold mb-1">🚨 Stok Kritis</p>
                    <p class="text-slate-300">Barang dengan stok habis (0) atau rendah (&lt;5 unit). Perlu segera ditambah stoknya untuk mencegah kekosongan.</p>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-700 text-xs font-semibold uppercase tracking-wider">Stok Kritis</p>
                    <p class="text-3xl font-bold text-red-900 mt-1"><?php echo e(($barangRendah ?? 0) + ($barangHabis ?? 0)); ?></p>
                    <p class="text-xs text-red-800 mt-2"><span class="font-bold"><?php echo e($barangHabis ?? 0); ?></span> habis · <span class="font-bold"><?php echo e($barangRendah ?? 0); ?></span> rendah</p>
                </div>
                <div class="h-12 w-12 bg-red-200 group-hover:bg-red-300 rounded-xl flex items-center justify-center transition">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-700"></i>
                </div>
            </div>
        </div>

        <!-- Total Permintaan -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-100 p-5 rounded-xl shadow-sm border border-green-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-300 cursor-pointer group relative">
            <!-- Info Tooltip -->
            <div class="absolute top-3 right-3 group/tooltip">
                <span class="h-5 w-5 bg-green-200 hover:bg-green-300 rounded-full flex items-center justify-center cursor-help transition">
                    <i class="fas fa-info text-xs text-green-700"></i>
                </span>
                <div class="absolute right-0 top-6 w-56 bg-slate-800 text-white text-xs rounded-lg p-3 hidden group-hover/tooltip:block z-20 shadow-xl">
                    <p class="font-semibold mb-1">📊 Total Permintaan</p>
                    <p class="text-slate-300">Total seluruh permintaan barang yang masuk, dengan rincian jumlah yang disetujui (✓) dan ditolak (✗).</p>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-700 text-xs font-semibold uppercase tracking-wider">Total Permintaan</p>
                    <p class="text-3xl font-bold text-green-900 mt-1"><?php echo e($totalPermintaan ?? 0); ?></p>
                    <p class="text-xs text-green-800 mt-2">
                        <span class="text-green-600 font-bold">✓<?php echo e($permintaanDisetujui ?? 0); ?></span> · 
                        <span class="text-red-600 font-bold">✗<?php echo e($permintaanDitolak ?? 0); ?></span>
                    </p>
                </div>
                <div class="h-12 w-12 bg-green-200 group-hover:bg-green-300 rounded-xl flex items-center justify-center transition">
                    <i class="fas fa-chart-line text-2xl text-green-700"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards Row 2 (Mini dengan Tooltip) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 hover:border-purple-300 transition relative group/card">
            <div class="absolute top-2 right-2 group/tooltip">
                <span class="h-4 w-4 bg-slate-100 hover:bg-slate-200 rounded-full flex items-center justify-center cursor-help">
                    <i class="fas fa-info text-[8px] text-slate-500"></i>
                </span>
                <div class="absolute right-0 top-5 w-48 bg-slate-800 text-white text-xs rounded-lg p-2.5 hidden group-hover/tooltip:block z-20 shadow-xl">
                    <p class="text-slate-300">Total pegawai yang terdaftar dan dapat mengajukan permintaan barang.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800"><?php echo e($totalPegawai ?? 0); ?></p>
                    <p class="text-xs text-slate-500">Pegawai</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 hover:border-teal-300 transition relative group/card">
            <div class="absolute top-2 right-2 group/tooltip">
                <span class="h-4 w-4 bg-slate-100 hover:bg-slate-200 rounded-full flex items-center justify-center cursor-help">
                    <i class="fas fa-info text-[8px] text-slate-500"></i>
                </span>
                <div class="absolute right-0 top-5 w-48 bg-slate-800 text-white text-xs rounded-lg p-2.5 hidden group-hover/tooltip:block z-20 shadow-xl">
                    <p class="text-slate-300">Jumlah kategori untuk pengelompokan jenis barang inventaris.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-teal-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-layer-group text-teal-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800"><?php echo e($totalKategori ?? 0); ?></p>
                    <p class="text-xs text-slate-500">Kategori</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 hover:border-orange-300 transition relative group/card">
            <div class="absolute top-2 right-2 group/tooltip">
                <span class="h-4 w-4 bg-slate-100 hover:bg-slate-200 rounded-full flex items-center justify-center cursor-help">
                    <i class="fas fa-info text-[8px] text-slate-500"></i>
                </span>
                <div class="absolute right-0 top-5 w-48 bg-slate-800 text-white text-xs rounded-lg p-2.5 hidden group-hover/tooltip:block z-20 shadow-xl">
                    <p class="text-slate-300">Jumlah sesi stock opname yang tercatat untuk audit stok fisik.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-check text-orange-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800"><?php echo e($totalOpname ?? 0); ?></p>
                    <p class="text-xs text-slate-500">Opname</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 hover:border-pink-300 transition relative group/card">
            <div class="absolute top-2 right-2 group/tooltip">
                <span class="h-4 w-4 bg-slate-100 hover:bg-slate-200 rounded-full flex items-center justify-center cursor-help">
                    <i class="fas fa-info text-[8px] text-slate-500"></i>
                </span>
                <div class="absolute right-0 top-5 w-48 bg-slate-800 text-white text-xs rounded-lg p-2.5 hidden group-hover/tooltip:block z-20 shadow-xl">
                    <p class="text-slate-300">Persentase permintaan yang disetujui dari total permintaan. Indikator kinerja pelayanan.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-pink-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-percentage text-pink-600"></i>
                </div>
                <div>
                    <?php $approvalRate = $totalPermintaan > 0 ? round(($permintaanDisetujui / $totalPermintaan) * 100) : 0; ?>
                    <p class="text-2xl font-bold text-slate-800"><?php echo e($approvalRate); ?>%</p>
                    <p class="text-xs text-slate-500">Approval</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row (DIPERKECIL) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Trend 7 Hari Terakhir -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-200 flex justify-between items-center">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">📈 Trend Permintaan (7 Hari)</h3>
                </div>
                <span class="text-xs text-slate-400">Real-time</span>
            </div>
            <div class="p-4">
                <canvas id="trendChart" height="70"></canvas>
            </div>
        </div>

        <!-- Status Distribution (Donut) -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-200">
                <h3 class="text-sm font-bold text-slate-800">📊 Status Permintaan</h3>
            </div>
            <div class="p-4 flex items-center justify-center">
                <div style="width: 150px; height: 150px;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
            <div class="px-4 pb-3 flex justify-center gap-3 text-xs">
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span> Menunggu</span>
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Disetujui</span>
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Ditolak</span>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 (DIPERKECIL) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Statistik Bulanan -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-200">
                <h3 class="text-sm font-bold text-slate-800">📅 Statistik Bulanan <?php echo e(date('Y')); ?></h3>
            </div>
            <div class="p-4">
                <canvas id="monthlyChart" height="100"></canvas>
            </div>
        </div>

        <!-- Stok per Kategori -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-200">
                <h3 class="text-sm font-bold text-slate-800">📦 Stok per Kategori (Top 6)</h3>
            </div>
            <div class="p-4">
                <canvas id="kategoriChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Two Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        
        <!-- Permintaan Terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-200 bg-gradient-to-r from-yellow-50 to-amber-50">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <span class="h-6 w-6 bg-yellow-400 rounded-lg flex items-center justify-center text-white text-xs">
                        <i class="fas fa-bell"></i>
                    </span>
                    Permintaan Menunggu
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-2.5 text-left text-xs font-bold text-slate-600 uppercase">Tanggal</th>
                            <th class="px-4 py-2.5 text-left text-xs font-bold text-slate-600 uppercase">Pegawai</th>
                            <th class="px-4 py-2.5 text-center text-xs font-bold text-slate-600 uppercase">Item</th>
                            <th class="px-4 py-2.5 text-center text-xs font-bold text-slate-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php $__empty_1 = true; $__currentLoopData = $permintaanTerbaru ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permintaan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-yellow-50 transition">
                            <td class="px-4 py-2.5 text-slate-700 font-medium whitespace-nowrap">
                                <div><?php echo e($permintaan->requested_at->timezone('Asia/Jakarta')->format('d M')); ?></div>
                                <div class="text-xs text-slate-400"><?php echo e($permintaan->requested_at->timezone('Asia/Jakarta')->format('H:i')); ?></div>
                            </td>
                            <td class="px-4 py-2.5 text-slate-700">
                                <div class="font-medium text-sm"><?php echo e($permintaan->pegawai->nama_lengkap ?? '-'); ?></div>
                                <div class="text-xs text-slate-400"><?php echo e($permintaan->pegawai->divisi ?? ''); ?></div>
                            </td>
                            <td class="px-4 py-2.5 text-center">
                                <span class="inline-flex items-center justify-center h-5 w-5 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                                    <?php echo e($permintaan->pengajuanDetails->count()); ?>

                                </span>
                            </td>
                            <td class="px-4 py-2.5 text-center">
                                <a href="<?php echo e(route('admin.permintaan.index')); ?>" class="text-blue-600 hover:text-blue-800 font-semibold text-xs">
                                    Tinjau <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-slate-400">
                                <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-check text-xl text-green-500"></i>
                                </div>
                                <p class="font-medium text-green-600 text-sm">Semua sudah diproses!</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if(($permintaanTerbaru ?? collect())->count() > 0): ?>
            <div class="px-5 py-2.5 border-t border-slate-200 text-right bg-slate-50">
                <a href="<?php echo e(route('admin.permintaan.index')); ?>" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition">
                    Lihat Semua (<?php echo e($permintaanBaru); ?>) <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Barang Paling Sering Diminta -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-200 bg-gradient-to-r from-orange-50 to-amber-50">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <span class="h-6 w-6 bg-orange-500 rounded-lg flex items-center justify-center text-white text-xs">
                        <i class="fas fa-fire"></i>
                    </span>
                    Barang Populer (Top 5)
                </h3>
            </div>
            <div class="p-3 space-y-2">
                <?php $__empty_1 = true; $__currentLoopData = $barangTeratas ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center gap-3 p-2.5 bg-gradient-to-r from-slate-50 to-white rounded-lg border border-slate-100 hover:border-orange-200 hover:shadow transition-all duration-200">
                    <div class="flex-shrink-0">
                        <?php if($index == 0): ?>
                            <span class="inline-flex items-center justify-center h-8 w-8 bg-gradient-to-br from-yellow-400 to-orange-500 text-white text-xs font-bold rounded-full shadow">
                                🥇
                            </span>
                        <?php elseif($index == 1): ?>
                            <span class="inline-flex items-center justify-center h-8 w-8 bg-gradient-to-br from-slate-300 to-slate-400 text-white text-xs font-bold rounded-full">
                                🥈
                            </span>
                        <?php elseif($index == 2): ?>
                            <span class="inline-flex items-center justify-center h-8 w-8 bg-gradient-to-br from-amber-600 to-amber-700 text-white text-xs font-bold rounded-full">
                                🥉
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center justify-center h-8 w-8 bg-blue-600 text-white text-xs font-bold rounded-full">
                                <?php echo e($index + 1); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-800 text-sm truncate"><?php echo e($barang->namaBarang ?? 'N/A'); ?></p>
                        <p class="text-xs text-slate-500">
                            Stok: <span class="font-semibold <?php echo e($barang->stok < 5 ? 'text-red-600' : 'text-green-600'); ?>"><?php echo e($barang->stok ?? 0); ?></span> <?php echo e($barang->satuan ?? 'unit'); ?>

                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-orange-100 text-orange-800 rounded-lg text-xs font-bold">
                            <i class="fas fa-fire text-orange-500"></i>
                            <?php echo e($barang->total_permintaan ?? 0); ?>x
                        </span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-6 text-slate-400">
                    <i class="fas fa-chart-bar text-2xl mb-2 opacity-50"></i>
                    <p class="text-sm">Belum ada data</p>
                </div>
                <?php endif; ?>
            </div>
            <div class="px-5 py-2.5 border-t border-slate-200 text-right bg-slate-50">
                <a href="<?php echo e(route('admin.barang.index')); ?>" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition">
                    Kelola Barang <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-xl shadow-lg p-5 text-white">
        <h3 class="text-sm font-bold mb-3">⚡ Aksi Cepat</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <a href="<?php echo e(route('admin.barang.create')); ?>" class="flex items-center gap-3 p-3 bg-white/10 hover:bg-white/20 rounded-lg transition group">
                <div class="h-9 w-9 bg-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                    <i class="fas fa-plus text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-semibold text-sm">Tambah Barang</p>
                    <p class="text-xs text-slate-400">Input barang baru</p>
                </div>
            </a>
            <a href="<?php echo e(route('admin.permintaan.index')); ?>" class="flex items-center gap-3 p-3 bg-white/10 hover:bg-white/20 rounded-lg transition group">
                <div class="h-9 w-9 bg-yellow-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                    <i class="fas fa-clipboard-list text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-semibold text-sm">Proses Permintaan</p>
                    <p class="text-xs text-slate-400"><?php echo e($permintaanBaru); ?> menunggu</p>
                </div>
            </a>
            <a href="<?php echo e(route('admin.stock-opname.create')); ?>" class="flex items-center gap-3 p-3 bg-white/10 hover:bg-white/20 rounded-lg transition group">
                <div class="h-9 w-9 bg-teal-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                    <i class="fas fa-clipboard-check text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-semibold text-sm">Stock Opname</p>
                    <p class="text-xs text-slate-400">Cek stok fisik</p>
                </div>
            </a>
            <a href="<?php echo e(route('admin.laporan.index')); ?>" class="flex items-center gap-3 p-3 bg-white/10 hover:bg-white/20 rounded-lg transition group">
                <div class="h-9 w-9 bg-purple-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                    <i class="fas fa-file-alt text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-semibold text-sm">Buat Laporan</p>
                    <p class="text-xs text-slate-400">Export PDF/Excel</p>
                </div>
            </a>
        </div>
    </div>

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Live Clock
function updateClock() {
    const now = new Date();
    const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
    document.getElementById('live-clock').textContent = now.toLocaleTimeString('id-ID', options);
}
setInterval(updateClock, 1000);
updateClock();

// Chart Color Palette
const colors = {
    primary: 'rgb(59, 130, 246)',
    primaryLight: 'rgba(59, 130, 246, 0.1)',
    success: 'rgb(34, 197, 94)',
    warning: 'rgb(250, 204, 21)',
    danger: 'rgb(239, 68, 68)',
    purple: 'rgb(168, 85, 247)',
    teal: 'rgb(20, 184, 166)',
    orange: 'rgb(249, 115, 22)',
    pink: 'rgb(236, 72, 153)',
    slate: 'rgb(100, 116, 139)'
};

// 1. Trend Chart (Line - 7 days)
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($trendLabels); ?>,
        datasets: [{
            label: 'Permintaan',
            data: <?php echo json_encode($trendHarian); ?>,
            borderColor: colors.primary,
            backgroundColor: colors.primaryLight,
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: colors.primary,
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10 } } },
            x: { ticks: { font: { size: 10 } } }
        }
    }
});

// 2. Status Chart (Doughnut)
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Menunggu', 'Disetujui', 'Ditolak'],
        datasets: [{
            data: [<?php echo e($statusDistribution['menunggu']); ?>, <?php echo e($statusDistribution['disetujui']); ?>, <?php echo e($statusDistribution['ditolak']); ?>],
            backgroundColor: [colors.warning, colors.success, colors.danger],
            borderWidth: 0,
            hoverOffset: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '65%',
        plugins: { legend: { display: false } }
    }
});

// 3. Monthly Chart (Bar)
new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($bulanLabels); ?>,
        datasets: [{
            label: 'Permintaan',
            data: <?php echo json_encode($bulanData); ?>,
            backgroundColor: [
                colors.primary, colors.teal, colors.success, colors.warning,
                colors.orange, colors.pink, colors.purple, colors.danger,
                colors.primary, colors.teal, colors.success, colors.slate
            ],
            borderRadius: 4,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10 } } },
            x: { ticks: { font: { size: 9 } } }
        }
    }
});

// 4. Kategori Chart (Horizontal Bar)
new Chart(document.getElementById('kategoriChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($stokPerKategori->pluck('nama')); ?>,
        datasets: [{
            label: 'Total Stok',
            data: <?php echo json_encode($stokPerKategori->pluck('stok')); ?>,
            backgroundColor: [colors.primary, colors.teal, colors.purple, colors.orange, colors.pink, colors.success],
            borderRadius: 4
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { beginAtZero: true, ticks: { font: { size: 10 } } },
            y: { ticks: { font: { size: 10 } } }
        }
    }
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\FILE TINGKAT 3\SEMESTER 5\REKAYASA PERANGKAT LUNAK (RPL)\simantap\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>