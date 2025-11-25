@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
        --card-bg: rgba(255,255,255,0.85);
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

    /* faint watermark (BPS emblem or dots) */
    .watermark {
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: .04;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .watermark svg { width: 520px; height: 520px; transform: rotate(-12deg); }

    /* card */
    .v3-card {
        background: var(--card-bg);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-radius: 1.6rem;
        border: 1px solid rgba(255,255,255,0.45);
        box-shadow: 0 10px 30px rgba(8,15,35,0.08), 0 3px 10px rgba(2,6,23,0.04);
        transition: transform .36s cubic-bezier(.2,.9,.2,1), box-shadow .36s;
    }
    .v3-card:hover { transform: translateY(-6px); box-shadow: 0 22px 48px rgba(8,15,35,0.12); }

    /* gradient border glow */
    .v3-glow {
        position: relative;
        overflow: visible;
    }
    .v3-glow::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 1.6rem;
        padding: 2px;
        background: linear-gradient(90deg, var(--bps-blue), var(--bps-green), var(--bps-orange));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: .35;
        filter: blur(6px);
        transition: opacity .3s;
    }
    .v3-glow:hover::before { opacity: .7; }

    /* inputs & interactions */
    .v3-input {
        background: rgba(255,255,255,0.85);
        border: 1px solid rgba(15,23,42,0.1);
        padding: .72rem 1rem .72rem 3rem;
        border-radius: .9rem;
        transition: box-shadow .18s, border-color .18s, transform .18s;
        outline: none;
        width: 100%;
        font-size: 1rem;
        box-sizing: border-box;
    }
    .v3-input:focus {
        box-shadow: 0 6px 18px rgba(0,87,183,0.08);
        border-color: var(--bps-blue);
        transform: translateY(-1px);
    }

    .v3-label { 
        display:block; 
        margin-bottom:.35rem; 
        color: #1f2937; 
        font-weight:600; 
        font-size:.92rem; 
    }

    /* icon container */
    .v3-icon {
        position: absolute; 
        left: 1rem; 
        top: 50%; 
        transform: translateY(-50%); 
        color: #6b7280;
        pointer-events: none;
    }

    /* button */
    .v3-btn {
        border-radius: 1rem;
        padding: .72rem 1rem;
        font-weight: 700;
        letter-spacing:.2px;
        transition: transform .18s, box-shadow .22s, filter .18s;
        box-shadow: 0 8px 20px rgba(3,55,102,0.12);
        border: none;
        cursor: pointer;
        font-size: 1rem;
        width: 100%;
    }
    .v3-btn:active { transform: translateY(1px); }
    .v3-btn:focus { outline: 3px solid rgba(0,87,183,0.14); outline-offset: 3px; }

    /* micro helper text */
    .v3-hint { color:#6b7280; font-size:.86rem; }

    /* small screens: compact the card */
    @media (max-width: 1024px) {
        .v3-card { padding: 1.25rem; border-radius: 1.1rem; }
    }

    /* subtle decoration under title */
    .v3-accent {
        height: 6px; 
        width: 72px; 
        border-radius: 999px;
        background: linear-gradient(90deg,var(--bps-blue),var(--bps-green));
        margin: .75rem auto 0;
        opacity: .95;
        box-shadow: 0 6px 18px rgba(3,55,102,0.06);
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
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .password-toggle:hover {
        color: #374151;
    }
    
    .password-toggle:focus {
        outline: 2px solid rgba(0,87,183,0.3);
        border-radius: 4px;
    }

    /* input wrapper */
    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    /* accessibility: high contrast focus fallback */
    :focus { outline: none; }
    
    /* error styling */
    .validation-errors {
        color: #dc2626;
        font-size: 0.875rem;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background-color: #fef2f2;
        border-radius: 0.5rem;
        border-left: 4px solid #dc2626;
    }
    
    .validation-errors ul {
        margin: 0;
        padding-left: 1rem;
    }
</style>
@endpush

<x-guest-layout>
    <div class="page-bg min-h-screen">
        {{-- watermark centered faint --}}
        <div class="watermark" aria-hidden="true">
            <!-- simple circular emblem / dots watermark -->
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor">
                <defs>
                    <linearGradient id="g1" x1="0" x2="1">
                        <stop offset="0" stop-color="#0057B7"/>
                        <stop offset="1" stop-color="#f6921e"/>
                    </linearGradient>
                </defs>
                <circle cx="100" cy="100" r="80" stroke="url(#g1)" stroke-width="2" opacity="0.08"/>
                <g transform="translate(50,50)" fill="none" stroke="url(#g1)" opacity="0.07">
                    <circle r="40" stroke-width="1.2"></circle>
                </g>
            </svg>
        </div>

        <div class="min-h-screen w-full grid lg:grid-cols-2">

            {{-- LEFT PANEL: Brand Info --}}
            <aside class="hidden lg:flex items-center justify-center px-12"
                   style="background: linear-gradient(135deg, var(--bps-blue), var(--bps-green) 50%, var(--bps-orange));">
                <div class="text-white max-w-lg w-full">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="bg-white/20 p-3 rounded-2xl">
                            <img src="{{ asset('images/logo-bps.png') }}" class="h-16 w-auto" alt="Logo BPS Kota Tanjungpinang"/>
                        </div>
                        <div>
                            <h1 class="text-4xl font-extrabold tracking-tight">SIMANTAP</h1>
                            <div class="text-sm opacity-90 mt-1">Sistem Informasi Manajemen Aset Negara</div>
                        </div>
                    </div>

                    <p class="mb-6 text-lg opacity-95">Mendukung Sensus Ekonomi 2026 — Aplikasi resmi BPS Kota Tanjungpinang</p>

                    <ul class="space-y-4 text-lg">
                        <li class="flex items-start gap-3">
                            <span class="rounded-full p-2 bg-white/20">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            <div>Manajemen Aset Digital Terintegrasi</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="rounded-full p-2 bg-white/20">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6-4h.01M12 16h.01"/>
                                </svg>
                            </span>
                            <div>Monitoring Real-time & Laporan Lengkap</div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="rounded-full p-2 bg-white/20">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </span>
                            <div>Sistem Approval & Stock Opname</div>
                        </li>
                    </ul>

                    <div class="mt-10 text-sm opacity-90">
                        <div class="font-semibold">BPS Kota Tanjungpinang</div>
                        <div class="mt-1">Siap mendukung sensus dan pengelolaan data aset BPS Kota Tanjungpinang.</div>
                    </div>
                </div>
            </aside>

            {{-- RIGHT PANEL: Login Form --}}
            <main class="flex items-center justify-center py-12 px-6">
                <div class="w-full max-w-lg v3-glow v3-card p-10">

                    {{-- Header --}}
                    <div class="text-center mb-6">
                        <div class="bg-gradient-to-r from-[var(--bps-blue)] to-[var(--bps-green)] p-2 rounded-2xl inline-block mb-3">
                            <img src="{{ asset('images/logo-bps.png') }}" alt="Logo BPS" class="h-12" />
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-900">Selamat Datang</h2>
                        <div class="v3-accent"></div>
                        <p class="text-gray-500 mt-2">Masuk ke akun SIMANTAP Anda</p>
                    </div>

                    {{-- Status / Errors --}}
                    @if (session('status'))
                        <div role="status" class="mb-4 p-3 text-sm text-green-700 bg-green-50 rounded-lg border border-green-200">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="validation-errors mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM --}}
                    <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email" class="v3-label">Alamat Email</label>
                            <div class="input-wrapper">
                                <span class="v3-icon" aria-hidden="true">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>

                                <input id="email" name="email" type="email" required autofocus
                                    placeholder="nama@bps.go.id"
                                    class="v3-input"
                                    value="{{ old('email') }}"
                                    aria-describedby="emailHelp" />
                            </div>
                            <p id="emailHelp" class="v3-hint mt-2">Gunakan akun BPS Anda (format: nama@bps.go.id)</p>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="v3-label">Password</label>
                            <div class="input-wrapper">
                                <span class="v3-icon" aria-hidden="true">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c-1.657 0-3 1.343-3 3v2h6v-2c0-1.657-1.343-3-3-3z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11V8a5 5 0 0110 0v3"/>
                                    </svg>
                                </span>

                                <input id="password" name="password" type="password" required
                                    placeholder="Masukkan password Anda"
                                    class="v3-input pr-12" />

                                {{-- show/hide button --}}
                                <button type="button" id="togglePassword" aria-label="Tampilkan password"
                                        class="password-toggle">
                                    <svg id="eyeOpen" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eyeClosed" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M3.53 2.47a.75.75 0 10-1.06 1.06l1.16 1.16A11.955 11.955 0 001.46 12c1.274 4.057 5.065 7 9.542 7 2.2 0 4.219-.64 5.96-1.73l1.02 1.02a.75.75 0 101.06-1.06L3.53 2.47zM7.1 9.02l1.34 1.34a3 3 0 004.06 4.06l1.34 1.34A8.008 8.008 0 0112 19c-3.31 0-6.14-1.99-7.41-4.88 1.18-2.35 3.17-4.25 5.51-5.1z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div>
                            <button type="submit"
                                class="v3-btn bg-gradient-to-r from-[var(--bps-blue)] via-[var(--bps-blue-2)] to-[var(--bps-blue)] text-white shadow-md hover:shadow-lg">
                                Masuk ke Sistem
                            </button>
                        </div>
                    </form>

                    {{-- Footer note --}}
                    <p class="text-center text-gray-400 text-xs mt-6">
                        © {{ now()->year }} BPS Kota Tanjungpinang. All rights reserved.
                    </p>
                </div>
            </main>
        </div>
    </div>

    {{-- Inline JS: show/hide password + small enhancements --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('togglePassword');
            if(!toggle) return;

            const pwd = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            toggle.addEventListener('click', function(){
                if (pwd.type === 'password') {
                    pwd.type = 'text';
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                    toggle.setAttribute('aria-label','Sembunyikan password');
                } else {
                    pwd.type = 'password';
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                    toggle.setAttribute('aria-label','Tampilkan password');
                }
            });

            // small accessibility: pressing Enter on toggle focuses password
            toggle.addEventListener('keydown', function(e){
                if(e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggle.click();
                }
            });

            // Add subtle animation to form elements on page load
            const formElements = document.querySelectorAll('.v3-input, .v3-btn');
            formElements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 100 * index);
            });
        });
    </script>
    @endpush

</x-guest-layout>