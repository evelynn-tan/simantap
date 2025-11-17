@extends('pegawai.layout')

@section('title', 'Edit Profil - SIMANTAP')
@section('page-title', 'Edit Profil Pegawai BPS')
@section('page-subtitle', 'Kelola profil dan keamanan akun Anda')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Informasi Profil -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Informasi Profil</h3>
            <p class="text-sm text-gray-600">Perbarui informasi profil Anda. Pastikan data yang diisi sudah benar.</p>
        </div>
        <div class="p-6">
            <form action="{{ route('pegawai.edit-profil.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="update_profile" value="1">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('nama_lengkap')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                        <input type="text" value="{{ $pegawai->nip }}"
                               class="w-full px-4 py-2 border rounded-lg bg-gray-50 text-gray-500" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" value="{{ Auth::user()->email }}"
                               class="w-full px-4 py-2 border rounded-lg bg-gray-50 text-gray-500" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('jabatan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Divisi</label>
                        <input type="text" name="divisi" value="{{ old('divisi', $pegawai->divisi) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('divisi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Informasi Akun & Ubah Password -->
    <div class="space-y-6">
        <!-- Informasi Akun -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Informasi Akun</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Role:</span>
                        <span class="text-sm font-medium text-gray-900">Pegawai BPS</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Email:</span>
                        <span class="text-sm font-medium text-gray-900">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Bergabung:</span>
                        <span class="text-sm font-medium text-gray-900">{{ Auth::user()->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ubah Password -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Ubah Password</h3>
                <p class="text-sm text-gray-600">Pastikan password baru Anda kuat dan aman. Minimal 6 karakter.</p>
            </div>
            <div class="p-6">
                <form action="{{ route('pegawai.edit-profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_password" value="1">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                            <input type="password" name="current_password" placeholder="Masukkan password lama"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                            <input type="password" name="password" placeholder="Masukkan password baru (minimal 8 karakter)"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @error('password_confirmation')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tips Keamanan -->
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">Tips Keamanan Password:</h4>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li>• Gunakan minimal 8 karakter</li>
                            <li>• Kombinasikan huruf besar, huruf kecil, dan angka</li>
                            <li>• Jangan gunakan informasi pribadi yang mudah ditebak</li>
                            <li>• Ubah password secara berkala</li>
                        </ul>
                    </div>

                    <div class="mt-6 flex space-x-3">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                            <i class="fas fa-key mr-2"></i>Ubah Password
                        </button>
                        <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                            <i class="fas fa-redo mr-2"></i>Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        alert('{{ session('success') }}');
    });
</script>
@endif
@endsection