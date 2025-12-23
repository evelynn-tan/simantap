@extends('layouts.pegawai-layout')

@section('title', 'Edit Profil - SIMANTAP')
@section('page-title', 'Edit Profil Pegawai BPS')
@section('page-subtitle', 'Kelola profil dan keamanan akun Anda')

@section('content')
<div class="space-y-6">
    
    {{-- Success/Error Notification (Inline, bukan alert JS) --}}
    @if(session('success'))
    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3 alert-auto-hide">
        <div class="h-10 w-10 bg-emerald-500 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-check text-white"></i>
        </div>
        <div class="flex-1">
            <p class="font-semibold text-emerald-800">Berhasil!</p>
            <p class="text-sm text-emerald-700">{{ session('success') }}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl p-4 flex items-center gap-3 alert-auto-hide">
        <div class="h-10 w-10 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-exclamation text-white"></i>
        </div>
        <div class="flex-1">
            <p class="font-semibold text-red-800">Terjadi Kesalahan</p>
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl p-4 alert-auto-hide">
        <div class="flex items-center gap-3 mb-2">
            <div class="h-10 w-10 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-white"></i>
            </div>
            <p class="font-semibold text-red-800">Terdapat kesalahan:</p>
        </div>
        <ul class="list-disc list-inside text-sm text-red-700 ml-12">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: Informasi Profil & Password --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Card Informasi Profil --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-edit text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Informasi Profil</h3>
                            <p class="text-sm text-emerald-100">Perbarui informasi profil Anda</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form action="{{ route('pegawai.edit-profil.update') }}" method="POST" id="formProfil">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="update_profile" value="1">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Nama Lengkap --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-user text-emerald-500 mr-1"></i> Nama Lengkap
                                </label>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}"
                                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('nama_lengkap') border-red-300 @enderror"
                                       placeholder="Masukkan nama lengkap">
                                @error('nama_lengkap')
                                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            {{-- NIP (Readonly) --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-id-card text-slate-400 mr-1"></i> NIP
                                </label>
                                <input type="text" value="{{ $pegawai->nip }}"
                                       class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-500 cursor-not-allowed" readonly>
                                <p class="text-xs text-slate-400 mt-1">NIP tidak dapat diubah</p>
                            </div>

                            {{-- Email (Readonly) --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-envelope text-slate-400 mr-1"></i> Email
                                </label>
                                <input type="email" value="{{ Auth::user()->email }}"
                                       class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-500 cursor-not-allowed" readonly>
                                <p class="text-xs text-slate-400 mt-1">Email tidak dapat diubah</p>
                            </div>

                            {{-- Jabatan --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-briefcase text-emerald-500 mr-1"></i> Jabatan
                                </label>
                                <input type="text" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}"
                                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('jabatan') border-red-300 @enderror"
                                       placeholder="Contoh: Statistisi Ahli Muda">
                                @error('jabatan')
                                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Divisi --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-building text-emerald-500 mr-1"></i> Divisi / Unit Kerja
                                </label>
                                <input type="text" name="divisi" value="{{ old('divisi', $pegawai->divisi) }}"
                                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('divisi') border-red-300 @enderror"
                                       placeholder="Contoh: Seksi IPDS">
                                @error('divisi')
                                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6 flex items-center gap-3">
                            <button type="submit" class="bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-6 py-3 rounded-xl font-semibold transition duration-200 flex items-center gap-2 shadow-lg shadow-emerald-200">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <button type="reset" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-semibold transition duration-200">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Card Ubah Password --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-key text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Ubah Password</h3>
                            <p class="text-sm text-amber-100">Pastikan password baru Anda kuat dan aman</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form action="{{ route('pegawai.edit-profil.update') }}" method="POST" id="formPassword">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="update_password" value="1">
                        
                        <div class="space-y-5">
                            {{-- Password Lama --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-lock text-amber-500 mr-1"></i> Password Lama
                                </label>
                                <div class="relative">
                                    <input type="password" name="current_password" id="current_password"
                                           class="w-full px-4 py-3 pr-12 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition @error('current_password') border-red-300 @enderror"
                                           placeholder="Masukkan password lama Anda">
                                    <button type="button" onclick="togglePassword('current_password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password Baru --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-key text-amber-500 mr-1"></i> Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="new_password"
                                           class="w-full px-4 py-3 pr-12 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition @error('password') border-red-300 @enderror"
                                           placeholder="Minimal 8 karakter">
                                    <button type="button" onclick="togglePassword('new_password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                                {{-- Password Strength Indicator --}}
                                <div class="mt-2">
                                    <div class="flex gap-1">
                                        <div id="str1" class="h-1 flex-1 bg-slate-200 rounded-full transition-all"></div>
                                        <div id="str2" class="h-1 flex-1 bg-slate-200 rounded-full transition-all"></div>
                                        <div id="str3" class="h-1 flex-1 bg-slate-200 rounded-full transition-all"></div>
                                        <div id="str4" class="h-1 flex-1 bg-slate-200 rounded-full transition-all"></div>
                                    </div>
                                    <p id="strengthText" class="text-xs text-slate-400 mt-1"></p>
                                </div>
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-check-double text-amber-500 mr-1"></i> Konfirmasi Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="confirm_password"
                                           class="w-full px-4 py-3 pr-12 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                                           placeholder="Ulangi password baru">
                                    <button type="button" onclick="togglePassword('confirm_password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <p id="matchText" class="text-xs mt-1 hidden"></p>
                            </div>
                        </div>

                        {{-- Tips Keamanan --}}
                        <div class="mt-5 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                            <h4 class="text-sm font-bold text-blue-800 mb-2 flex items-center gap-2">
                                <i class="fas fa-shield-alt"></i> Tips Keamanan Password
                            </h4>
                            <ul class="text-xs text-blue-700 space-y-1.5">
                                <li class="flex items-center gap-2"><i class="fas fa-check text-blue-500"></i> Gunakan minimal 8 karakter</li>
                                <li class="flex items-center gap-2"><i class="fas fa-check text-blue-500"></i> Kombinasikan huruf besar, kecil, dan angka</li>
                                <li class="flex items-center gap-2"><i class="fas fa-check text-blue-500"></i> Hindari informasi pribadi yang mudah ditebak</li>
                                <li class="flex items-center gap-2"><i class="fas fa-check text-blue-500"></i> Ubah password secara berkala</li>
                            </ul>
                        </div>

                        <div class="mt-6 flex items-center gap-3">
                            <button type="submit" class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white px-6 py-3 rounded-xl font-semibold transition duration-200 flex items-center gap-2 shadow-lg shadow-amber-200">
                                <i class="fas fa-key"></i> Ubah Password
                            </button>
                            <button type="reset" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-semibold transition duration-200">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Preview Profil & Upload Foto --}}
        <div class="space-y-6">
            
            {{-- Card Foto Profil --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-green-500 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-camera text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Foto Profil</h3>
                            <p class="text-sm text-green-100">Upload atau ganti foto Anda</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    {{-- Preview Foto --}}
                    <div class="flex flex-col items-center mb-6">
                        <div class="relative group">
                            @if($pegawai->foto)
                                <img src="{{ asset('storage/' . $pegawai->foto) }}" 
                                     alt="Foto Profil" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-orange-200 shadow-lg"
                                     id="previewImage">
                            @else
                                <div class="w-32 h-32 bg-gradient-to-br from-orange-400 to-yellow-500 rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-lg border-4 border-purple-200" id="avatarInitial">
                                    {{ strtoupper(substr($pegawai->nama_lengkap, 0, 1)) }}{{ strtoupper(substr(explode(' ', $pegawai->nama_lengkap)[1] ?? '', 0, 1)) }}
                                </div>
                                <img src="" alt="Foto Profil" class="w-32 h-32 rounded-full object-cover border-4 border-purple-200 shadow-lg hidden" id="previewImage">
                            @endif
                            <div class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer" onclick="document.getElementById('fotoInput').click()">
                                <i class="fas fa-camera text-white text-2xl"></i>
                            </div>
                        </div>
                        <p class="text-sm text-slate-600 font-medium mt-3">{{ $pegawai->nama_lengkap }}</p>
                        <p class="text-xs text-slate-400">{{ $pegawai->jabatan }}</p>
                    </div>

                    {{-- Upload Form --}}
                    <form action="{{ route('pegawai.edit-profil.update') }}" method="POST" enctype="multipart/form-data" id="formFoto">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="update_foto" value="1">
                        
                        <div class="space-y-4">
                            <div>
                                <input type="file" name="foto" id="fotoInput" accept="image/jpeg,image/jpg,image/png,image/webp" class="hidden" onchange="previewFoto(this)">
                                <button type="button" onclick="document.getElementById('fotoInput').click()" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-3 rounded-xl font-semibold transition flex items-center justify-center gap-2">
                                    <i class="fas fa-upload"></i> Pilih Foto
                                </button>
                                <p class="text-xs text-slate-400 text-center mt-2">JPG, PNG, atau WEBP. Maks 2MB</p>
                            </div>

                            <div id="selectedFileName" class="hidden text-sm text-center text-purple-600 font-medium bg-purple-50 py-2 px-3 rounded-lg">
                                <i class="fas fa-image mr-1"></i> <span id="fileName"></span>
                            </div>

                            <button type="submit" id="uploadBtn" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-3 rounded-xl font-semibold transition shadow-lg shadow-purple-200 hidden">
                                <i class="fas fa-cloud-upload-alt mr-2"></i> Upload Foto
                            </button>
                        </div>
                    </form>

                    {{-- Hapus Foto --}}
                    @if($pegawai->foto)
                    <form action="{{ route('pegawai.edit-profil.update') }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="hapus_foto" value="1">
                        <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2.5 rounded-xl font-medium transition text-sm" onclick="return confirm('Yakin ingin menghapus foto profil?')">
                            <i class="fas fa-trash-alt mr-2"></i> Hapus Foto
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            {{-- Card Preview Profil --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-gradient-to-br from-slate-700 to-slate-900 px-6 py-8 text-center relative">
                    <div class="absolute inset-0 opacity-10">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <defs>
                                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                                </pattern>
                            </defs>
                            <rect width="100" height="100" fill="url(#grid)"/>
                        </svg>
                    </div>
                    <div class="relative">
                        @if($pegawai->foto)
                            <img src="{{ asset('storage/' . $pegawai->foto) }}" 
                                 alt="Foto Profil" 
                                 class="w-20 h-20 rounded-full object-cover mx-auto border-4 border-white/20 shadow-lg">
                        @else
                            <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full mx-auto flex items-center justify-center text-white text-2xl font-bold shadow-lg border-4 border-white/20">
                                {{ strtoupper(substr($pegawai->nama_lengkap, 0, 1)) }}{{ strtoupper(substr(explode(' ', $pegawai->nama_lengkap)[1] ?? '', 0, 1)) }}
                            </div>
                        @endif
                        <h3 class="text-lg font-bold text-white mt-3">{{ $pegawai->nama_lengkap }}</h3>
                        <p class="text-slate-300 text-sm">{{ $pegawai->jabatan }}</p>
                        <span class="inline-flex items-center gap-1 mt-3 px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-xs font-medium">
                            <i class="fas fa-check-circle"></i> Pegawai Aktif
                        </span>
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <span class="text-sm text-slate-500 flex items-center gap-2">
                            <i class="fas fa-id-badge text-slate-400"></i> NIP
                        </span>
                        <span class="text-sm font-semibold text-slate-800 font-mono">{{ $pegawai->nip }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <span class="text-sm text-slate-500 flex items-center gap-2">
                            <i class="fas fa-envelope text-slate-400"></i> Email
                        </span>
                        <span class="text-xs font-medium text-slate-800">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <span class="text-sm text-slate-500 flex items-center gap-2">
                            <i class="fas fa-building text-slate-400"></i> Divisi
                        </span>
                        <span class="text-sm font-medium text-slate-800">{{ $pegawai->divisi }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-slate-500 flex items-center gap-2">
                            <i class="fas fa-calendar text-slate-400"></i> Bergabung
                        </span>
                        <span class="text-sm font-medium text-slate-800">{{ Auth::user()->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-5 text-white">
                <h4 class="font-bold mb-4 flex items-center gap-2 text-sm">
                    <i class="fas fa-chart-pie"></i> Statistik Akun
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-emerald-100 text-sm">Total Permintaan</span>
                        <span class="font-bold text-lg">{{ \App\Models\Pengajuan::where('pegawaiID', $pegawai->pegawaiID)->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-emerald-100 text-sm">Disetujui</span>
                        <span class="font-bold text-lg text-emerald-200">{{ \App\Models\Pengajuan::where('pegawaiID', $pegawai->pegawaiID)->where('status', 'disetujui')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-emerald-100 text-sm">Menunggu</span>
                        <span class="font-bold text-lg text-yellow-200">{{ \App\Models\Pengajuan::where('pegawaiID', $pegawai->pegawaiID)->where('status', 'menunggu')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>

<script>
    // Toggle Password Visibility
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Password Strength Checker
    document.getElementById('new_password').addEventListener('input', function(e) {
        const password = e.target.value;
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/\d/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-emerald-500'];
        const texts = ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat'];
        const textColors = ['text-red-500', 'text-orange-500', 'text-yellow-500', 'text-emerald-500'];

        for (let i = 1; i <= 4; i++) {
            const bar = document.getElementById('str' + i);
            bar.className = 'h-1 flex-1 rounded-full transition-all ' + (i <= strength ? colors[strength - 1] : 'bg-slate-200');
        }

        const strengthText = document.getElementById('strengthText');
        if (password.length > 0) {
            strengthText.textContent = texts[strength - 1] || 'Sangat Lemah';
            strengthText.className = 'text-xs mt-1 ' + (textColors[strength - 1] || 'text-red-500');
        } else {
            strengthText.textContent = '';
        }
    });

    // Password Match Checker
    document.getElementById('confirm_password').addEventListener('input', function(e) {
        const confirmPassword = e.target.value;
        const newPassword = document.getElementById('new_password').value;
        const matchText = document.getElementById('matchText');
        
        if (confirmPassword.length > 0) {
            matchText.classList.remove('hidden');
            if (confirmPassword === newPassword) {
                matchText.textContent = '✓ Password cocok';
                matchText.className = 'text-xs mt-1 text-emerald-500';
                e.target.classList.remove('border-red-300');
                e.target.classList.add('border-emerald-300');
            } else {
                matchText.textContent = '✗ Password tidak cocok';
                matchText.className = 'text-xs mt-1 text-red-500';
                e.target.classList.remove('border-emerald-300');
                e.target.classList.add('border-red-300');
            }
        } else {
            matchText.classList.add('hidden');
            e.target.classList.remove('border-red-300', 'border-emerald-300');
        }
    });

    // Preview Foto
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                input.value = '';
                return;
            }

            // Show file name
            document.getElementById('selectedFileName').classList.remove('hidden');
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('uploadBtn').classList.remove('hidden');

            // Preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = document.getElementById('previewImage');
                const avatarInitial = document.getElementById('avatarInitial');
                
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
                
                if (avatarInitial) {
                    avatarInitial.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    }

    // Auto-hide success notification after 5 seconds
    setTimeout(() => {
        const successNotif = document.querySelector('.bg-gradient-to-r.from-emerald-50');
        if (successNotif) {
            successNotif.style.transition = 'opacity 0.5s ease';
            successNotif.style.opacity = '0';
            setTimeout(() => successNotif.remove(), 500);
        }
    }, 5000);
</script>
@endsection