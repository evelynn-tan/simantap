<x-guest-layout>
    <div class="min-h-screen w-full grid lg:grid-cols-2 bg-white">
        {{-- LEFT PANEL --}}
        <aside class="hidden lg:flex items-center justify-center bg-gradient-to-br from-blue-600 to-indigo-700 px-12">
            <div class="text-white max-w-xl w-full">
                <div class="flex items-center mb-10">
                    <div class="bg-white/20 p-4 rounded-2xl mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4zM3 7v10l9 4 9-4V7" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-extrabold tracking-wide">SIMANTAP</h1>
                        <p class="text-sm opacity-80">v7.0</p>
                    </div>
                </div>

                <h2 class="text-2xl font-bold leading-snug">Sistem Informasi Manajemen Aset Negara</h2>
                <p class="mb-8 text-lg opacity-90">BPS Kota Tanjungpinang</p>

                <ul class="space-y-4">
                    <li class="flex items-center gap-3">
                        <span class="bg-white/20 rounded-full p-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        Manajemen Aset Digital Terintegrasi
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="bg-white/20 rounded-full p-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        Monitoring Real-time &amp; Laporan Lengkap
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="bg-white/20 rounded-full p-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        Sistem Approval &amp; Stock Opname
                    </li>
                </ul>
            </div>
        </aside>

        {{-- RIGHT PANEL --}}
        <main class="flex items-center justify-center py-10">
            <div class="w-full max-w-lg">
                <div class="bg-white rounded-2xl shadow-[0_10px_30px_rgba(2,6,23,0.08)] border border-gray-100 p-8">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang</h2>
                        <p class="text-gray-500 text-sm mt-1">Masuk ke akun SIMANTAP Anda untuk melanjutkan</p>
                    </div>

                    {{-- Alerts (error auth / status) --}}
                    @if (session('status'))
                        <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
                    @endif
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <x-label for="email" value="Email"/>
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8-4H8m10 8H6a2 2 0 01-2-2V7a2 2 0 012-2h12a2 2 0 012 2v7a2 2 0 01-2 2z"/>
                                    </svg>
                                </span>
                                <x-input id="email"
                                         class="pl-10 w-full"
                                         type="email"
                                         name="email"
                                         value="{{ old('email') }}"
                                         placeholder="nama@bps.go.id"
                                         required autofocus />
                            </div>
                        </div>

                        {{-- Password --}}
                        <div>
                            <x-label for="password" value="Password"/>
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c-1.657 0-3 1.343-3 3v3h6v-3c0-1.657-1.343-3-3-3zm0-7a5 5 0 00-5 5v2h10V9a5 5 0 00-5-5z"/>
                                    </svg>
                                </span>
                                <x-input id="password"
                                         class="pl-10 w-full"
                                         type="password"
                                         name="password"
                                         placeholder="Masukkan password Anda"
                                         required autocomplete="current-password" />
                            </div>
                        </div>

                        {{-- Submit --}}
                        <x-button class="w-full justify-center bg-blue-600 hover:bg-blue-700">
                            {{ __('Masuk ke Sistem') }}
                        </x-button>
                    </form>

                    {{-- Demo Credentials --}}
                    <div class="mt-6 bg-blue-50 border border-blue-100 p-4 rounded-lg">
                        <div class="flex items-center text-blue-600 mb-2">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                            </svg>
                            <h3 class="font-semibold">Demo Credentials</h3>
                        </div>
                        <div class="text-sm text-gray-700 space-y-2">
                            <div class="rounded-md border border-blue-100 bg-white px-3 py-2">
                                <strong>Pegawai BPS</strong>
                                <div class="text-gray-500">pegawai@bps.go.id / password</div>
                            </div>
                            <div class="rounded-md border border-blue-100 bg-white px-3 py-2">
                                <strong>Operator BMN</strong>
                                <div class="text-gray-500">operator@bps.go.id / password</div>
                            </div>
                        </div>
                    </div>

                    <p class="text-center text-gray-400 text-xs mt-6">
                        © {{ now()->year }} BPS Kota Tanjungpinang. All rights reserved.
                    </p>
                </div>
            </div>
        </main>
    </div>
</x-guest-layout>
