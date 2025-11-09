<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Monitor Status Permintaan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filter -->
            <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                <form action="{{ route('pegawai.permintaan.monitor') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                            <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="">Semua Status</option>
                                <option value="menunggu" @if(request('status') == 'menunggu') selected @endif>Menunggu</option>
                                <option value="disetujui" @if(request('status') == 'disetujui') selected @endif>Disetujui</option>
                                <option value="ditolak" @if(request('status') == 'ditolak') selected @endif>Ditolak</option>
                            </select>
                        </div>
                        <div>
                            <label for="tanggal_mulai" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ request('tanggal_mulai') }}">
                        </div>
                        <div>
                            <label for="tanggal_selesai" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ request('tanggal_selesai') }}">
                        </div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 h-10 self-end">Filter</button>
                    </div>
                </form>
            </div>

            <!-- Tabel Riwayat Permintaan -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Tanggal Pengajuan</th>
                                <th scope="col" class="px-6 py-3">Barang</th>
                                <th scope="col" class="px-6 py-3">Jumlah</th>
                                <th scope="col" class="px-6 py-3">Keperluan</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permintaans as $permintaan)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">{{ $permintaan->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4">
                                        @foreach($permintaan->details as $detail)
                                            <div>{{ $detail->barang->nama_barang }}</div>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">
                                        @foreach($permintaan->details as $detail)
                                            <div>{{ $detail->jumlah_diminta }} unit</div>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">{{ $permintaan->keperluan }}</td>
                                    <td class="px-6 py-4">
                                        @if ($permintaan->status == 'menunggu')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Menunggu</span>
                                        @elseif ($permintaan->status == 'disetujui')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Disetujui</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b">
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada permintaan ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="p-4">
                    {{ $permintaans->links() }} <!-- Ini untuk pagination -->
                </div>
            </div>

        </div>
    </div>
</x-app-layout>