<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Operator BMN
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $jumlahJenisAset }}</h5>
                    <p class="font-normal text-gray-700">Jumlah Jenis Aset</p>
                    <p class="font-normal text-xs text-gray-500">Total stok: {{ $totalStok }}</p>
                </div>
                <div class="block p-6 bg-white border border-yellow-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-yellow-700">{{ $permintaanBaru }}</h5>
                    <p class="font-normal text-gray-700">Permintaan Baru</p>
                    <p class="font-normal text-xs text-yellow-500">Perlu Ditindaklanjuti</p>
                </div>
                <div class="block p-6 bg-white border border-red-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-red-700">{{ $perluRestock }}</h5>
                    <p class="font-normal text-gray-700">Perlu Restock</p>
                    <p class="font-normal text-xs text-gray-500">Stok kurang dari 5</p>
                </div>
                <div class="block p-6 bg-white border border-green-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-green-700">{{ $totalPermintaan }}</h5>
                    <p class="font-normal text-gray-700">Total Permintaan</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium mb-4">Permintaan Terbaru (Menunggu Persetujuan)</h3>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        </table>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Daftar Pegawai Teratas</h3>
                </div>

        </div>
    </div>
</x-app-layout>