<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Profil Pegawai BPS
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Sukses -->
            @if (session('success_profile'))
                <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                    <span class="font-medium">Sukses!</span> {{ session('success_profile') }}
                </div>
            @endif
            @if (session('success_password'))
                <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                    <span class="font-medium">Sukses!</span> {{ session('success_password') }}
                </div>
            @endif

            <!-- Tabs (Gunakan Alpine.js untuk state tab) -->
            <div x-data="{ tab: '{{ session('tab', 'profile') }}' }">
                <div class="mb-4 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                        <li class="mr-2">
                            <button @click="tab = 'profile'" :class="{ 'border-blue-600 text-blue-600': tab === 'profile', 'border-transparent hover:text-gray-600 hover:border-gray-300': tab !== 'profile' }" class="inline-block p-4 border-b-2 rounded-t-lg" type="button">
                                Informasi Profil
                            </button>
                        </li>
                        <li class="mr-2">
                            <button @click="tab = 'password'" :class="{ 'border-blue-600 text-blue-600': tab === 'password', 'border-transparent hover:text-gray-600 hover:border-gray-300': tab !== 'password' }" class="inline-block p-4 border-b-2 rounded-t-lg" type="button">
                                Ubah Password
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Konten Tab Informasi Profil -->
                <div x-show="tab === 'profile'" class="bg-white shadow-md rounded-lg p-6">
                    <form action="{{ route('pegawai.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="update_profile" value="1">
                        
                        <h3 class="text-lg font-semibold mb-4">Informasi Profil</h3>
                        <p class="text-sm text-gray-600 mb-6">Perbarui informasi profil Anda. Pastikan data yang diisi sudah benar.</p>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap *</label>
                                <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div>
                                <label for="nip" class="block mb-2 text-sm font-medium text-gray-900">NIP</label>
                                <input type="text" name="nip" id="nip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Masukkan NIP" value="{{ old('nip', $user->nip) }}">
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email *</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div>
                                <label for="jabatan" class="block mb-2 text-sm font-medium text-gray-900">Jabatan</label>
                                <input type="text" name="jabatan" id="jabatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Masukkan jabatan" value="{{ old('jabatan', $user->jabatan) }}">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Konten Tab Ubah Password -->
                <div x-show="tab === 'password'" class="bg-white shadow-md rounded-lg p-6">
                    <form action="{{ route('pegawai.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="update_password" value="1">
                        
                        <h3 class="text-lg font-semibold mb-4">Ubah Password</h3>
                        <p class="text-sm text-gray-600 mb-6">Pastikan password baru Anda kuat dan aman. Minimal 8 karakter.</p>

                        <div class="space-y-6">
                            <div>
                                <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900">Password Lama *</label>
                                <input type="password" name="current_password" id="current_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                @error('current_password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                             <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password Baru *</label>
                                <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                @error('password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                             <div>
                                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password Baru *</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                            </div>
                        </div>

                        <!-- Tips Keamanan Password -->
                        <div class="p-4 mt-6 text-sm text-blue-800 rounded-lg bg-blue-50">
                            <h4 class="font-medium">Tips Keamanan Password:</h4>
                            <ul class="mt-1.5 ml-4 list-disc list-inside">
                                <li>Gunakan minimal 8 karakter.</li>
                                <li>Kombinasikan huruf besar, huruf kecil, dan angka.</li>
                                <li>Ubah password secara berkala.</li>
                            </ul>
                        </div>

                        <div class="mt-6 flex justify-end gap-4">
                            <button type="reset" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Reset Form</button>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>