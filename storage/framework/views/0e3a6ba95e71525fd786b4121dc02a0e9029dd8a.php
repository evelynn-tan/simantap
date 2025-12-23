<aside id="sidebar" 
    x-data="{ open: false }" 
    x-show="true"
    @toggle-sidebar.window="open = !open"
    :class="open ? 'translate-x-0' : '-translate-x-full sm:translate-x-0'"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform bg-gradient-to-b from-blue-950 via-blue-900 to-slate-900 text-white" 
    aria-label="Sidebar">
    
    <!-- Mobile Overlay Backdrop -->
    <div x-show="open" 
         @click="open = false" 
         class="fixed inset-0 bg-black/50 z-[-1] sm:hidden"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <div class="h-full flex flex-col" style="font-family: 'Poppins', sans-serif;">
        <!-- Logo Header with Close Button for Mobile -->
        <div class="p-5 border-b border-blue-800 bg-gradient-to-r from-blue-950 to-blue-900 shadow-lg">
            <div class="flex items-center justify-between">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center space-x-3 hover:opacity-80 transition">
                    <div class="flex items-center gap-2">
                        <img src="<?php echo e(asset('images/logo-bps.png')); ?>" alt="Logo" class="w-8 h-8">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white tracking-wider">SIMANTAP</h1>
                        <p class="text-xs text-blue-200 font-medium hidden sm:block">BPS Kota Tanjungpinang</p>
                    </div>
                </a>
                <!-- Close Button (Mobile Only) -->
                <button @click="open = false" class="sm:hidden p-2 rounded-lg hover:bg-blue-800 transition">
                    <i class="fas fa-times text-white text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Menu Items -->
        <div class="px-3 py-5 overflow-y-auto flex-1 bg-gradient-to-b from-blue-900 to-blue-950 scrollbar-hide">
            <ul class="space-y-2 font-medium text-sm">
                <!-- Dashboard -->
                <li>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" @click="open = false" class="flex items-center px-4 py-3 text-blue-100 rounded-lg transition duration-200 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white'); ?>">
                        <i class="fas fa-chart-line w-5 h-5 text-yellow-300"></i>
                        <span class="ml-3 font-semibold">Dashboard</span>
                    </a>
                </li>

                <!-- Manajemen Permintaan -->
                <li>
                    <a href="<?php echo e(route('admin.permintaan.index')); ?>" @click="open = false" class="flex items-center px-4 py-3 text-blue-100 rounded-lg transition duration-200 <?php echo e(request()->routeIs('admin.permintaan.*') ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white'); ?>">
                        <i class="fas fa-file-alt w-5 h-5 text-emerald-300"></i>
                        <span class="ml-3 font-semibold">Proses Permintaan</span>
                    </a>
                </li>

                <!-- Data Barang -->
                <li>
                    <a href="<?php echo e(route('admin.barang.index')); ?>" @click="open = false" class="flex items-center px-4 py-3 text-blue-100 rounded-lg transition duration-200 <?php echo e(request()->routeIs('admin.barang.index') || (request()->routeIs('admin.barang.*') && !request()->routeIs('admin.barang.create')) ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white'); ?>">
                        <i class="fas fa-box w-5 h-5 text-cyan-300"></i>
                        <span class="ml-3 font-semibold">Data Barang</span>
                    </a>
                </li>

                <!-- Tambah Barang -->
                <li>
                    <a href="<?php echo e(route('admin.barang.create')); ?>" @click="open = false" class="flex items-center px-4 py-3 text-blue-100 rounded-lg transition duration-200 <?php echo e(request()->routeIs('admin.barang.create') ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white'); ?>">
                        <i class="fas fa-plus-circle w-5 h-5 text-lime-300"></i>
                        <span class="ml-3 font-semibold">Tambah Barang</span>
                    </a>
                </li>

                <!-- Divider -->
                <div class="my-3 border-t border-blue-800"></div>

                <!-- Stock Opname -->
                <li>
                    <a href="<?php echo e(route('admin.stock-opname.index')); ?>" @click="open = false" class="flex items-center px-4 py-3 text-blue-100 rounded-lg transition duration-200 <?php echo e(request()->routeIs('admin.stock-opname.*') ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white'); ?>">
                        <i class="fas fa-check-square w-5 h-5 text-orange-300"></i>
                        <span class="ml-3 font-semibold">Stock Opname</span>
                    </a>
                </li>

                <!-- Manajemen Pengguna -->
                <li>
                    <a href="<?php echo e(route('admin.pengguna.index')); ?>" @click="open = false" class="flex items-center px-4 py-3 text-blue-100 rounded-lg transition duration-200 <?php echo e(request()->routeIs('admin.pengguna.*') ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white'); ?>">
                        <i class="fas fa-users w-5 h-5 text-pink-300"></i>
                        <span class="ml-3 font-semibold">Manajemen Pengguna</span>
                    </a>
                </li>

                <!-- Laporan -->
                <li>
                    <a href="<?php echo e(route('admin.laporan.index')); ?>" @click="open = false" class="flex items-center px-4 py-3 text-blue-100 rounded-lg transition duration-200 <?php echo e(request()->routeIs('admin.laporan.*') ? 'bg-blue-700 border-l-4 border-yellow-400 shadow-lg text-white' : 'hover:bg-blue-800 border-l-4 border-transparent hover:text-white'); ?>">
                        <i class="fas fa-file-pdf w-5 h-5 text-red-300"></i>
                        <span class="ml-3 font-semibold">Buat Laporan</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Logout Button - Bottom Left -->
        <div class="p-4 border-t border-blue-800 bg-blue-950 mt-auto">
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-lg transition duration-200 shadow-lg border border-red-500">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar Sistem</span>
                </button>
            </form>
            <p class="text-xs text-blue-300 text-center mt-3">© 2025 SIMANTAP</p>
        </div>
    </div>
</aside><?php /**PATH E:\FILE TINGKAT 3\SEMESTER 5\REKAYASA PERANGKAT LUNAK (RPL)\simantap\resources\views\layouts\sidebar-admin.blade.php ENDPATH**/ ?>