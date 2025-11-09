<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Pengguna Sistem
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
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
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $penggunaAktif }}</h5>
                    <p class="font-normal text-gray-700">Pengguna Aktif</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3>Filter & Pencarian</h3>
                    <a href="{{ route('admin.pengguna.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        + Tambah Pengguna
                    </a>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama / NIP</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Jabatan</th>
                                <th scope="col" class="px-6 py-3">Role</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="bg-white border-b">
                                <td class="px-6 py-4">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">{{ $user->jabatan ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($user->role == 'operator')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Operator BMN</span>
                                    @else
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Pegawai BPS</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Aktif</span>
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('admin.pengguna.edit', $user->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>