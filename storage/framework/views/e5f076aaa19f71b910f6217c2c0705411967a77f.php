<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'SIMANTAP - Pegawai'); ?></title>
    
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom Scrollbar agar lebih rapi */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        [x-cloak] { display: none !important; }
        
        /* Auto-dismiss alerts */
        .alert-auto-hide {
            animation: fadeInOut 6s ease-in-out forwards;
        }
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-20px); }
            10% { opacity: 1; transform: translateY(0); }
            85% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-20px); pointer-events: none; }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false, profileOpen: false, showPhotoModal: false }">

    <div class="lg:hidden flex justify-between items-center bg-white p-4 shadow-sm sticky top-0 z-20">
        <div class="flex items-center gap-2">
            <img src="<?php echo e(asset('images/logo-bps.png')); ?>" alt="Logo" class="w-8 h-8">
            <span class="font-bold text-emerald-700">SIMANTAP</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-600 hover:text-emerald-600 focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>

    <div class="flex h-screen overflow-hidden">
        
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-slate-100 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col h-full shadow-lg lg:shadow-none">
            
            <div class="h-20 flex items-center px-6 border-b border-slate-50">
                <div class="flex items-center gap-3">
                    <img src="<?php echo e(asset('images/logo-bps.png')); ?>" alt="Logo BPS" class="w-9 h-9 object-contain">
                    <div class="leading-tight">
                        <h1 class="text-xl font-extrabold text-emerald-700 tracking-tight">SIMANTAP</h1>
                        <p class="text-[10px] font-medium text-slate-400 uppercase tracking-wider">Aset Negara</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden ml-auto text-slate-400 hover:text-red-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                
                
                <?php
                    function getMenuClass($routeName) {
                        $isActive = request()->routeIs($routeName);
                        $baseClass = "flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group";
                        
                        if ($isActive) {
                            return "$baseClass bg-emerald-50 text-emerald-700 shadow-sm";
                        }
                        return "$baseClass text-slate-500 hover:bg-slate-50 hover:text-emerald-600";
                    }
                ?>
                
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Menu Utama</p>

                <a href="<?php echo e(route('pegawai.dashboard')); ?>" class="<?php echo e(getMenuClass('pegawai.dashboard')); ?>">
                    <i class="<?php echo e(request()->routeIs('pegawai.dashboard') ? 'fas' : 'far'); ?> fa-compass w-5 text-center"></i>
                    Dashboard
                </a>
                
                <a href="<?php echo e(route('pegawai.daftar-barang')); ?>" class="<?php echo e(getMenuClass('pegawai.daftar-barang')); ?>">
                    <i class="<?php echo e(request()->routeIs('pegawai.daftar-barang') ? 'fas' : 'far'); ?> fa-folder-open w-5 text-center"></i>
                    Daftar Barang
                </a>
                
                <a href="<?php echo e(route('pegawai.monitor-permintaan')); ?>" class="<?php echo e(getMenuClass('pegawai.monitor-permintaan')); ?>">
                    <i class="<?php echo e(request()->routeIs('pegawai.monitor-permintaan') ? 'fas' : 'far'); ?> fa-eye w-5 text-center"></i>
                    Monitor Status
                </a>

                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-6 mb-2">Pengaturan</p>
                
                <a href="<?php echo e(route('pegawai.edit-profil')); ?>" class="<?php echo e(getMenuClass('pegawai.edit-profil')); ?>">
                    <i class="<?php echo e(request()->routeIs('pegawai.edit-profil') ? 'fas' : 'far'); ?> fa-user-circle w-5 text-center"></i>
                    Edit Profil
                </a>
            </nav>

            <div class="p-4 border-t border-slate-50">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar Aplikasi</span>
                    </button>
                </form>
            </div>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-slate-900/50 z-20 lg:hidden" x-cloak></div>

        <div class="flex-1 flex flex-col h-full overflow-hidden relative">
            
            <header class="bg-white/80 backdrop-blur-md sticky top-0 z-10 border-b border-slate-100 h-20 hidden lg:flex items-center justify-between px-8">
                
                <div>
                    <h2 class="text-lg font-bold text-slate-800"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                    <p class="text-xs text-slate-500 font-medium mt-0.5"><?php echo $__env->yieldContent('page-subtitle', 'Overview & Statistik'); ?></p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-bold text-slate-800"><?php echo e($pegawai->nama_lengkap ?? 'Pegawai'); ?></p>
                        <p class="text-xs text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded-full inline-block">
                            Pegawai BPS
                        </p>
                    </div>
                    
                    
                    <div class="relative">
                        <button @click="profileOpen = !profileOpen" class="focus:outline-none">
                            <?php if(isset($pegawai) && $pegawai->foto): ?>
                                <img src="<?php echo e(asset('storage/' . $pegawai->foto)); ?>" 
                                     alt="Foto Profil" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-emerald-200 shadow-sm hover:border-emerald-400 transition cursor-pointer">
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 border-2 border-white shadow-sm flex items-center justify-center text-white font-bold text-lg hover:from-emerald-500 hover:to-teal-600 transition cursor-pointer">
                                    <?php echo e(substr($pegawai->nama_lengkap ?? 'P', 0, 1)); ?>

                                </div>
                            <?php endif; ?>
                        </button>

                        
                        <div x-show="profileOpen" 
                             @click.away="profileOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50"
                             style="display: none;">
                            
                            
                            <div class="px-4 py-3 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <?php if(isset($pegawai) && $pegawai->foto): ?>
                                        <img src="<?php echo e(asset('storage/' . $pegawai->foto)); ?>" 
                                             alt="Foto Profil" 
                                             class="w-12 h-12 rounded-full object-cover border-2 border-emerald-200 cursor-pointer hover:opacity-80 transition"
                                             @click="profileOpen = false; showPhotoModal = true">
                                    <?php else: ?>
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-xl">
                                            <?php echo e(substr($pegawai->nama_lengkap ?? 'P', 0, 1)); ?>

                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-slate-800 truncate"><?php echo e($pegawai->nama_lengkap ?? 'Pegawai'); ?></p>
                                        <p class="text-xs text-slate-500 truncate"><?php echo e(Auth::user()->email); ?></p>
                                    </div>
                                </div>
                            </div>

                            
                            <?php if(isset($pegawai) && $pegawai->foto): ?>
                            <button @click="profileOpen = false; showPhotoModal = true" class="w-full px-4 py-2.5 text-left text-sm text-slate-600 hover:bg-slate-50 flex items-center gap-3">
                                <i class="fas fa-image w-5 text-center text-slate-400"></i>
                                Lihat Foto Profil
                            </button>
                            <?php endif; ?>
                            <a href="<?php echo e(route('pegawai.edit-profil')); ?>" class="block px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 flex items-center gap-3">
                                <i class="fas fa-user-edit w-5 text-center text-slate-400"></i>
                                Edit Profil
                            </a>
                            <a href="<?php echo e(route('pegawai.dashboard')); ?>" class="block px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 flex items-center gap-3">
                                <i class="fas fa-tachometer-alt w-5 text-center text-slate-400"></i>
                                Dashboard
                            </a>
                            <div class="border-t border-slate-100 mt-2 pt-2">
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full px-4 py-2.5 text-left text-sm text-red-600 hover:bg-red-50 flex items-center gap-3">
                                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 bg-slate-50">
                <div class="max-w-7xl mx-auto">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>

        </div>
    </div>

    
    <?php if(isset($pegawai) && $pegawai->foto): ?>
    <div x-show="showPhotoModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         x-cloak>
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" @click="showPhotoModal = false"></div>
        <div class="relative z-10 max-w-lg w-full"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            <button @click="showPhotoModal = false" class="absolute -top-12 right-0 text-white hover:text-red-400 transition text-xl">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <img src="<?php echo e(asset('storage/' . $pegawai->foto)); ?>" 
                 alt="Foto Profil" 
                 class="w-full rounded-2xl shadow-2xl border-4 border-white">
            <div class="text-center mt-4">
                <p class="text-white font-bold text-lg"><?php echo e($pegawai->nama_lengkap); ?></p>
                <p class="text-white/70 text-sm"><?php echo e($pegawai->jabatan); ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH E:\FILE TINGKAT 3\SEMESTER 5\REKAYASA PERANGKAT LUNAK (RPL)\simantap\resources\views/layouts/pegawai-layout.blade.php ENDPATH**/ ?>