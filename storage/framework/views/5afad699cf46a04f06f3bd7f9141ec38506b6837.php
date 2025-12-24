<?php $__env->startPush('styles'); ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Global */
    body { 
        font-family: 'Poppins', sans-serif !important; 
        margin: 0;
        padding: 0;
    }
    
    :root{
        --bps-blue:#0057B7;
        --bps-blue-2:#0072d4;
        --bps-green:#28A745;
        --bps-orange:#F6921E;
        --card-bg: rgba(255,255,255,0.95);
    }

    /* Page background: signature BPS gradient + subtle pattern */
    .page-bg{
        min-height:100vh;
        background:
            radial-gradient(1200px 500px at 10% 10%, rgba(0,87,183,0.08), transparent 8%),
            radial-gradient(900px 400px at 95% 90%, rgba(246,146,30,0.06), transparent 8%),
            linear-gradient(135deg, #eef4fb 0%, #f9fbfe 100%);
        position: relative;
        overflow: hidden;
    }

    /* Animated background shapes */
    .bg-shapes {
        position: absolute;
        inset: 0;
        pointer-events: none;
        overflow: hidden;
    }
    
    .bg-shape {
        position: absolute;
        border-radius: 50%;
        opacity: 0.05;
        animation: float 20s ease-in-out infinite;
    }
    
    .bg-shape-1 {
        width: 400px;
        height: 400px;
        background: var(--bps-blue);
        top: -100px;
        right: -100px;
        animation-delay: 0s;
    }
    
    .bg-shape-2 {
        width: 300px;
        height: 300px;
        background: var(--bps-green);
        bottom: -50px;
        left: -50px;
        animation-delay: -5s;
    }
    
    .bg-shape-3 {
        width: 200px;
        height: 200px;
        background: var(--bps-orange);
        top: 50%;
        right: 20%;
        animation-delay: -10s;
    }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -30px) scale(1.05); }
        66% { transform: translate(-20px, 20px) scale(0.95); }
    }

    /* Left panel styling */
    .left-panel {
        background: linear-gradient(160deg, var(--bps-blue) 0%, #004494 40%, var(--bps-green) 100%);
        position: relative;
        overflow: hidden;
    }
    
    .left-panel::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        animation: pulse-bg 4s ease-in-out infinite;
    }
    
    @keyframes pulse-bg {
        0%, 100% { opacity: 0.5; transform: scale(1); }
        50% { opacity: 0.8; transform: scale(1.1); }
    }

    /* Glass card effect */
    .v3-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 1.8rem;
        border: 1px solid rgba(255,255,255,0.6);
        box-shadow: 
            0 25px 50px rgba(8,15,35,0.1),
            0 10px 20px rgba(0,87,183,0.05),
            inset 0 1px 0 rgba(255,255,255,0.8);
        transition: transform .4s cubic-bezier(.2,.9,.2,1), box-shadow .4s;
    }
    .v3-card:hover { 
        transform: translateY(-8px); 
        box-shadow: 
            0 35px 60px rgba(8,15,35,0.15),
            0 15px 30px rgba(0,87,183,0.08);
    }

    /* Gradient glow effect */
    .v3-glow {
        position: relative;
        overflow: visible;
    }
    .v3-glow::before {
        content: "";
        position: absolute;
        inset: -3px;
        border-radius: 2rem;
        background: linear-gradient(135deg, var(--bps-blue), var(--bps-green), var(--bps-orange), var(--bps-blue));
        background-size: 300% 300%;
        animation: gradient-shift 6s ease infinite;
        opacity: 0;
        filter: blur(15px);
        transition: opacity .4s;
        z-index: -1;
    }
    .v3-glow:hover::before { opacity: 0.6; }
    
    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    /* inputs & interactions */
    .v3-input {
        background: rgba(255,255,255,0.9);
        border: 2px solid rgba(15,23,42,0.08);
        padding: .85rem 1rem .85rem 3.2rem;
        border-radius: 1rem;
        transition: all .25s ease;
        outline: none;
        width: 100%;
        font-size: 1rem;
        box-sizing: border-box;
    }
    .v3-input:focus {
        box-shadow: 0 0 0 4px rgba(0,87,183,0.1), 0 8px 20px rgba(0,87,183,0.08);
        border-color: var(--bps-blue);
        transform: translateY(-2px);
        background: #fff;
    }
    .v3-input::placeholder {
        color: #9ca3af;
    }

    .v3-label { 
        display:block; 
        margin-bottom:.5rem; 
        color: #1f2937; 
        font-weight:600; 
        font-size:.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .v3-label i {
        color: var(--bps-blue);
        font-size: 0.85rem;
    }

    /* icon container */
    .v3-icon {
        position: absolute; 
        left: 1.1rem; 
        top: 50%; 
        transform: translateY(-50%); 
        color: #6b7280;
        pointer-events: none;
        transition: color .2s;
    }
    
    .v3-input:focus + .v3-icon,
    .input-wrapper:focus-within .v3-icon {
        color: var(--bps-blue);
    }

    /* button */
    .v3-btn {
        border-radius: 1rem;
        padding: 1rem 1.5rem;
        font-weight: 700;
        letter-spacing:.3px;
        transition: all .3s ease;
        box-shadow: 0 10px 25px rgba(0,87,183,0.25);
        border: none;
        cursor: pointer;
        font-size: 1.05rem;
        width: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .v3-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left .5s ease;
    }
    
    .v3-btn:hover::before {
        left: 100%;
    }
    
    .v3-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0,87,183,0.35);
    }
    
    .v3-btn:active { 
        transform: translateY(0); 
        box-shadow: 0 5px 15px rgba(0,87,183,0.2);
    }

    /* micro helper text */
    .v3-hint { 
        color:#6b7280; 
        font-size:.85rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    
    .v3-hint i {
        font-size: 0.75rem;
        color: var(--bps-blue);
    }

    /* small screens: compact the card */
    @media (max-width: 1024px) {
        .v3-card { padding: 1.5rem; border-radius: 1.3rem; }
        .left-panel { display: none; }
    }

    /* subtle decoration under title */
    .v3-accent {
        height: 5px; 
        width: 80px; 
        border-radius: 999px;
        background: linear-gradient(90deg, var(--bps-blue), var(--bps-green), var(--bps-orange));
        margin: .75rem auto 0;
        opacity: .95;
        box-shadow: 0 4px 15px rgba(0,87,183,0.15);
    }

    /* password toggle button */
    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #6b7280;
        padding: 0.3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        transition: all .2s;
    }
    
    .password-toggle:hover {
        color: var(--bps-blue);
        background: rgba(0,87,183,0.08);
    }

    /* input wrapper */
    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    /* Feature cards on left panel */
    .feature-card {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        border: 1px solid rgba(255,255,255,0.2);
        transition: all .3s ease;
        cursor: default;
    }
    
    .feature-card:hover {
        background: rgba(255,255,255,0.2);
        transform: translateX(5px);
        border-color: rgba(255,255,255,0.4);
    }
    
    /* Stats section */
    .stat-item {
        text-align: center;
        padding: 0.75rem;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        display: block;
        background: linear-gradient(135deg, #fff 0%, rgba(255,255,255,0.8) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .stat-label {
        font-size: 0.75rem;
        opacity: 0.85;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* error styling */
    .validation-errors {
        color: #dc2626;
        font-size: 0.875rem;
        margin-bottom: 1rem;
        padding: 0.85rem 1rem;
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border-radius: 0.75rem;
        border-left: 4px solid #dc2626;
        animation: shake 0.5s ease;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .validation-errors ul {
        margin: 0;
        padding-left: 1rem;
    }
    
    /* Logo animation */
    .logo-container {
        animation: fadeInDown 0.8s ease;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Footer links */
    .footer-link {
        color: #6b7280;
        font-size: 0.8rem;
        transition: color .2s;
    }
    
    .footer-link:hover {
        color: var(--bps-blue);
    }
    
    /* Live clock */
    .live-clock {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-family: 'Poppins', monospace;
        background: rgba(255,255,255,0.15);
        padding: 0.4rem 0.8rem;
        border-radius: 0.6rem;
        font-size: 0.85rem;
    }
    
    /* Typing animation */
    .typing-text {
        overflow: hidden;
        white-space: nowrap;
        animation: typing 3s steps(40) 1s forwards;
        width: 0;
    }
    
    @keyframes typing {
        from { width: 0; }
        to { width: 100%; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php if (isset($component)) { $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015 = $component; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="page-bg min-h-screen">
        <!-- Animated Background Shapes -->
        <div class="bg-shapes" aria-hidden="true">
            <div class="bg-shape bg-shape-1"></div>
            <div class="bg-shape bg-shape-2"></div>
            <div class="bg-shape bg-shape-3"></div>
        </div>

        <div class="min-h-screen w-full grid lg:grid-cols-2">

            
            <aside class="left-panel hidden lg:flex items-center justify-center px-10 py-12">
                <div class="text-white max-w-md w-full relative z-10">
                    <!-- Logo & Title -->
                    <div class="flex items-center gap-4 mb-8 logo-container">
                        <div class="bg-white/20 p-3.5 rounded-2xl backdrop-blur-sm border border-white/20 shadow-lg">
                            <img src="<?php echo e(asset('images/logo-bps.png')); ?>" class="h-14 w-auto" alt="Logo BPS Kota Tanjungpinang"/>
                        </div>
                        <div>
                            <h1 class="text-4xl font-extrabold tracking-tight drop-shadow-lg">SIMANTAP</h1>
                            <div class="text-sm opacity-90 mt-1 flex items-center gap-2">
                                <i class="fas fa-building text-xs"></i>
                                Sistem Informasi Manajemen Aset Negara
                            </div>
                        </div>
                    </div>

                    <!-- Tagline -->
                    <div class="mb-8">
                        <p class="text-xl font-medium opacity-95 leading-relaxed">
                            Mendukung <span class="font-bold text-yellow-300">Sensus Ekonomi 2026</span>
                        </p>
                        <p class="text-sm opacity-80 mt-1">Aplikasi resmi BPS Kota Tanjungpinang</p>
                    </div>

                    <!-- Feature Cards -->
                    <div class="space-y-3 mb-8">
                        <div class="feature-card flex items-center gap-4">
                            <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-boxes-stacked text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold">Manajemen Aset Digital</p>
                                <p class="text-xs opacity-80">Kelola inventaris secara terintegrasi</p>
                            </div>
                        </div>
                        
                        <div class="feature-card flex items-center gap-4">
                            <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-chart-line text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold">Monitoring Real-time</p>
                                <p class="text-xs opacity-80">Dashboard & laporan lengkap</p>
                            </div>
                        </div>
                        
                        <div class="feature-card flex items-center gap-4">
                            <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clipboard-check text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold">Stock Opname Otomatis</p>
                                <p class="text-xs opacity-80">Penyesuaian stok langsung tercatat</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats - Premium Design -->
                    <div class="grid grid-cols-3 gap-3 mb-8">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20 text-center hover:bg-white/20 transition-all duration-300 hover:scale-105 cursor-default group">
                            <div class="h-12 w-12 mx-auto mb-2 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-yellow-400/30 transition-shadow">
                                <i class="fas fa-bolt text-white text-xl"></i>
                            </div>
                            <span class="text-white font-bold text-sm block">Proses Cepat</span>
                            <span class="text-white/60 text-xs">Real-time</span>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20 text-center hover:bg-white/20 transition-all duration-300 hover:scale-105 cursor-default group">
                            <div class="h-12 w-12 mx-auto mb-2 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-emerald-400/30 transition-shadow">
                                <i class="fas fa-shield-alt text-white text-xl"></i>
                            </div>
                            <span class="text-white font-bold text-sm block">Data Aman</span>
                            <span class="text-white/60 text-xs">Terenkripsi</span>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20 text-center hover:bg-white/20 transition-all duration-300 hover:scale-105 cursor-default group">
                            <div class="h-12 w-12 mx-auto mb-2 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-blue-400/30 transition-shadow">
                                <i class="fas fa-cloud text-white text-xl"></i>
                            </div>
                            <span class="text-white font-bold text-sm block">Cloud Based</span>
                            <span class="text-white/60 text-xs">Akses Dimana Saja</span>
                        </div>
                    </div>

                    <!-- Footer Info -->
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-semibold flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-sm"></i>
                                BPS Kota Tanjungpinang
                            </div>
                            <div class="text-xs opacity-75 mt-1">Kepulauan Riau, Indonesia</div>
                        </div>
                        <div class="live-clock">
                            <i class="far fa-clock"></i>
                            <span id="live-clock-left">--:--:--</span>
                        </div>
                    </div>
                </div>
            </aside>

            
            <main class="flex items-center justify-center py-10 px-6 relative">
                <div class="w-full max-w-md v3-glow v3-card p-8 md:p-10">

                    
                    <div class="text-center mb-8">
                        <div class="logo-container inline-block mb-4">
                            <div class="bg-gradient-to-br from-[var(--bps-blue)] to-[var(--bps-green)] p-3 rounded-2xl inline-block shadow-lg">
                                <img src="<?php echo e(asset('images/logo-bps.png')); ?>" alt="Logo BPS" class="h-12" />
                            </div>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-900">Selamat Datang</h2>
                        <div class="v3-accent"></div>
                        <p class="text-gray-500 mt-3 text-sm">Masuk ke akun SIMANTAP Anda</p>
                    </div>

                    
                    <?php if(session('status')): ?>
                        <div role="status" class="mb-4 p-4 text-sm text-green-700 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200 flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>
                    
                    <?php if($errors->any()): ?>
                        <div class="validation-errors mb-4">
                            <div class="flex items-center gap-2 font-semibold mb-1">
                                <i class="fas fa-exclamation-triangle"></i>
                                Terjadi kesalahan
                            </div>
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    
                    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5" novalidate>
                        <?php echo csrf_field(); ?>

                        
                        <div>
                            <label for="email" class="v3-label">
                                <i class="fas fa-envelope"></i>
                                Alamat Email
                            </label>
                            <div class="input-wrapper">
                                <span class="v3-icon" aria-hidden="true">
                                    <i class="fas fa-at"></i>
                                </span>
                                <input id="email" name="email" type="email" required autofocus
                                    placeholder="nama@bps.go.id"
                                    class="v3-input"
                                    value="<?php echo e(old('email')); ?>"
                                    aria-describedby="emailHelp" />
                            </div>
                            <p id="emailHelp" class="v3-hint mt-2">
                                <i class="fas fa-info-circle"></i>
                                Gunakan akun resmi BPS Anda
                            </p>
                        </div>

                        
                        <div>
                            <label for="password" class="v3-label">
                                <i class="fas fa-lock"></i>
                                Password
                            </label>
                            <div class="input-wrapper">
                                <span class="v3-icon" aria-hidden="true">
                                    <i class="fas fa-key"></i>
                                </span>

                                <input id="password" name="password" type="password" required
                                    placeholder="••••••••"
                                    class="v3-input pr-12" />

                                
                                <button type="button" id="togglePassword" aria-label="Tampilkan password"
                                        class="password-toggle">
                                    <i id="eyeIcon" class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition">
                                <span class="text-sm text-gray-600">Ingat saya</span>
                            </label>
                            
                        </div>

                        
                        <div class="pt-2">
                            <button type="submit"
                                class="v3-btn bg-gradient-to-r from-[var(--bps-blue)] via-[var(--bps-blue-2)] to-[var(--bps-blue)] text-white flex items-center justify-center gap-2">
                                <i class="fas fa-sign-in-alt"></i>
                                Masuk ke Sistem
                            </button>
                        </div>
                    </form>

                    
                    <div class="flex items-center my-6">
                        <div class="flex-1 border-t border-gray-200"></div>
                        <span class="px-4 text-xs text-gray-400 uppercase">atau</span>
                        <div class="flex-1 border-t border-gray-200"></div>
                    </div>
                    
                    
                    <div class="text-center text-sm text-gray-500">
                        <p>Belum punya akun? <span class="text-blue-600 font-medium">Hubungi Operator</span></p>
                    </div>

                    
                    <div class="text-center mt-8 pt-6 border-t border-gray-100">
                        <p class="text-gray-400 text-xs">
                            © <?php echo e(now()->year); ?> BPS Kota Tanjungpinang. All rights reserved.
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    
    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle
            const toggle = document.getElementById('togglePassword');
            if(toggle) {
                const pwd = document.getElementById('password');
                const eyeIcon = document.getElementById('eyeIcon');

                toggle.addEventListener('click', function(){
                    if (pwd.type === 'password') {
                        pwd.type = 'text';
                        eyeIcon.classList.remove('fa-eye');
                        eyeIcon.classList.add('fa-eye-slash');
                        toggle.setAttribute('aria-label','Sembunyikan password');
                    } else {
                        pwd.type = 'password';
                        eyeIcon.classList.remove('fa-eye-slash');
                        eyeIcon.classList.add('fa-eye');
                        toggle.setAttribute('aria-label','Tampilkan password');
                    }
                });
            }

            // Live clock
            function updateClock() {
                const now = new Date();
                const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Jakarta' };
                const timeString = now.toLocaleTimeString('id-ID', options);
                
                const clockLeft = document.getElementById('live-clock-left');
                if(clockLeft) clockLeft.textContent = timeString;
            }
            setInterval(updateClock, 1000);
            updateClock();

            // Animate form elements on load
            const animateElements = document.querySelectorAll('.v3-input, .v3-btn, .v3-label');
            animateElements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(15px)';
                
                setTimeout(() => {
                    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 80 * index);
            });

            // Feature cards animation
            const featureCards = document.querySelectorAll('.feature-card');
            featureCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateX(0)';
                }, 200 + (100 * index));
            });
        });
    </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015)): ?>
<?php $component = $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015; ?>
<?php unset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015); ?>
<?php endif; ?><?php /**PATH E:\FILE TINGKAT 3\SEMESTER 5\REKAYASA PERANGKAT LUNAK (RPL)\simantap\resources\views/auth/login.blade.php ENDPATH**/ ?>