@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('header', 'Manajemen Pengguna')

@section('content')
    <div class="max-w-7xl mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $totalPengguna }}</h5>
                    <p class="font-normal text-gray-700">Total Pengguna</p>
                </div>
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $pegawaiBPS }}</h5>
                    <p class="font-normal text-gray-700">Pegawai BPS</p>
                </div>
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $operatorBMN }}</h5>
                    <p class="font-normal text-gray-700">Operator BMN</p>
                </div>
            </div>

            <div class="flex justify-between items-center mb-4">
                <div class="w-1/2">
                    <form method="GET" action="{{ route('admin.pengguna.index') }}">
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Cari...</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="search" name="search" id="default-search" value="{{ request('search') }}" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari berdasarkan nama atau email...">
                            <button type="submit" class="absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-4 py-2">Cari</button>
                        </div>
                    </form>
                </div>
                <a href="{{ route('admin.pengguna.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    + Tambah Pengguna Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama_lengkap', 'sort_dir' => request('sort_by') == 'nama_lengkap' && request('sort_dir') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center hover:text-blue-600 cursor-pointer">
                                        Nama Lengkap
                                        <svg class="w-4 h-4 ml-1 {{ request('sort_by') == 'nama_lengkap' ? 'text-blue-600' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                            @if(request('sort_by') == 'nama_lengkap' && request('sort_dir') == 'asc')
                                                <path d="M5 10l5-5 5 5H5z"/>
                                            @elseif(request('sort_by') == 'nama_lengkap' && request('sort_dir') == 'desc')
                                                <path d="M5 10l5 5 5-5H5z"/>
                                            @else
                                                <path d="M5 10l5-5 5 5H5z"/>
                                            @endif
                                        </svg>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'email', 'sort_dir' => request('sort_by') == 'email' && request('sort_dir') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center hover:text-blue-600 cursor-pointer">
                                        Email
                                        <svg class="w-4 h-4 ml-1 {{ request('sort_by') == 'email' ? 'text-blue-600' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                            @if(request('sort_by') == 'email' && request('sort_dir') == 'asc')
                                                <path d="M5 10l5-5 5 5H5z"/>
                                            @elseif(request('sort_by') == 'email' && request('sort_dir') == 'desc')
                                                <path d="M5 10l5 5 5-5H5z"/>
                                            @else
                                                <path d="M5 10l5-5 5 5H5z"/>
                                            @endif
                                        </svg>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'role', 'sort_dir' => request('sort_by') == 'role' && request('sort_dir') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center hover:text-blue-600 cursor-pointer">
                                        Role
                                        <svg class="w-4 h-4 ml-1 {{ request('sort_by') == 'role' ? 'text-blue-600' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                            @if(request('sort_by') == 'role' && request('sort_dir') == 'asc')
                                                <path d="M5 10l5-5 5 5H5z"/>
                                            @elseif(request('sort_by') == 'role' && request('sort_dir') == 'desc')
                                                <path d="M5 10l5 5 5-5H5z"/>
                                            @else
                                                <path d="M5 10l5-5 5 5H5z"/>
                                            @endif
                                        </svg>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'jabatan', 'sort_dir' => request('sort_by') == 'jabatan' && request('sort_dir') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center hover:text-blue-600 cursor-pointer">
                                        Jabatan
                                        <svg class="w-4 h-4 ml-1 {{ request('sort_by') == 'jabatan' ? 'text-blue-600' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                            @if(request('sort_by') == 'jabatan' && request('sort_dir') == 'asc')
                                                <path d="M5 10l5-5 5 5H5z"/>
                                            @elseif(request('sort_by') == 'jabatan' && request('sort_dir') == 'desc')
                                                <path d="M5 10l5 5 5-5H5z"/>
                                            @else
                                                <path d="M5 10l5-5 5 5H5z"/>
                                            @endif
                                        </svg>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nip', 'sort_dir' => request('sort_by') == 'nip' && request('sort_dir') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center hover:text-blue-600 cursor-pointer">
                                        NIP
                                        <svg class="w-4 h-4 ml-1 {{ request('sort_by') == 'nip' ? 'text-blue-600' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                            @if(request('sort_by') == 'nip' && request('sort_dir') == 'asc')
                                                <path d="M5 10l5-5 5 5H5z"/>
                                            @elseif(request('sort_by') == 'nip' && request('sort_dir') == 'desc')
                                                <path d="M5 10l5 5 5-5H5z"/>
                                            @else
                                                <path d="M5 10l5-5 5 5H5z"/>
                                            @endif
                                        </svg>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $user->pegawai->nama_lengkap ?? $user->operator->nama_lengkap ?? 'N/A' }}</th>
                                    <td class="px-6 py-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4">{{ $user->role_display }}</td>
                                    <td class="px-6 py-4">{{ $user->pegawai->jabatan ?? $user->operator->jabatan ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $user->pegawai->nip ?? $user->operator->nip ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 flex gap-2">
                                        <a href="{{ route('admin.pengguna.edit', $user->userID) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('admin.pengguna.destroy', $user->userID) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b">
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

    </div>
@endsection