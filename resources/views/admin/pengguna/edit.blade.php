<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Pengguna
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('admin.pengguna.update', $pengguna->id) }}" method="POST">
@extends('layouts.admin')
@section('title', 'Edit Pengguna')
@section('header', 'Edit Pengguna')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('admin.pengguna.update', $pengguna->userID) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $pengguna->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <input type="text" name="name" id="name" value="{{ old('name', $pengguna->pegawai->nama_lengkap ?? $pengguna->operator->nama_lengkap ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $pengguna->email) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div>
                            <label for="jabatan" class="block mb-2 text-sm font-medium text-gray-900">Jabatan *</label>
                            <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $pengguna->jabatan) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $pengguna->pegawai->jabatan ?? $pengguna->operator->jabatan ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div>
                            <label for="nip" class="block mb-2 text-sm font-medium text-gray-900">NIP *</label>
                            <input type="text" name="nip" id="nip" value="{{ old('nip', $pengguna->pegawai->nip ?? $pengguna->operator->nip ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div id="divisi-field" style="display: {{ old('role', $pengguna->role) == 'pegawai' ? 'block' : 'none' }};">
                            <label for="divisi" class="block mb-2 text-sm font-medium text-gray-900">Divisi *</label>
                            <input type="text" name="divisi" id="divisi" value="{{ old('divisi', $pengguna->pegawai->divisi ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" {{ old('role', $pengguna->role) == 'pegawai' ? 'required' : '' }}>
                        </div>
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role *</label>
                            <select id="role" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="pegawai" {{ old('role', $pengguna->role) == 'pegawai' ? 'selected' : '' }}>Pegawai BPS</option>
                                <option value="operator" {{ old('role', $pengguna->role) == 'operator' ? 'selected' : '' }}>Operator BMN</option>
                            </select>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>
                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Update Pengguna</button>
                        <a href="{{ route('admin.pengguna.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Update Pengguna</button>
                        <a href="{{ route('admin.pengguna.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

    <script>
        document.getElementById('role').addEventListener('change', function() {
            var divisiField = document.getElementById('divisi-field');
            var divisiInput = document.getElementById('divisi');
            if (this.value === 'pegawai') {
                divisiField.style.display = 'block';
                divisiInput.setAttribute('required', 'required');
            } else {
                divisiField.style.display = 'none';
                divisiInput.removeAttribute('required');
            }
        });
    </script>
@endsection
