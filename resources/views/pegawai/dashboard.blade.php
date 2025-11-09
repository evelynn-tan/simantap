<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Selamat Datang, {{ Auth::user()->name }}!
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $barangDigunakan }}</h5>
                    <p class="font-normal text-gray-700">Barang Sedang Digunakan</p>
                </div>
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $totalPermintaan }}</h5>
                    <p class="font-normal text-gray-700">Total Permintaan Diajukan</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium mb-4">Barang yang Sedang Saya Gunakan</h3>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Riwayat 5 Permintaan Terakhir</h3>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>