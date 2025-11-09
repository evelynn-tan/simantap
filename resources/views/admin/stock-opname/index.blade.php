<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Stock Opname
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 md:p-12 flex flex-col items-center text-center">
                    
                    <svg class="w-16 h-16 text-blue-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h3.75c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-3.75A1.125 1.125 0 013 16.875v-3.75zM3 4.125C3 3.504 3.504 3 4.125 3h3.75c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-3.75A1.125 1.125 0 013 7.875V4.125zM13.125 3C12.504 3 12 3.504 12 4.125v3.75c0 .621.504 1.125 1.125 1.125h3.75c.621 0 1.125-.504 1.125-1.125V4.125c0-.621-.504-1.125-1.125-1.125h-3.75zM13.125 12c-.621 0-1.125.504-1.125 1.125v3.75c0 .621.504 1.125 1.125 1.125h3.75c.621 0 1.125-.504 1.125-1.125v-3.75c0-.621-1.125-1.125-1.125-1.125h-3.75z" />
                    </svg>

                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Mulai Sesi Stock Opname</h3>
                    <p class="text-gray-600 mb-4">Pastikan Anda siap untuk melakukan pengecekan fisik semua barang dalam sistem.</p>

                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800 text-sm" role="alert">
                        <span class="font-medium">Perhatian!</span> Stock opname akan mengunci sementara transaksi barang. Pastikan tidak ada aktivitas lain yang sedang berlangsung.
                    </div>

                    <p class="text-sm text-gray-500 my-4">
                        Total barang yang akan diperiksa: **{{ \App\Models\Barang::count() }} item**
                    </p>

                    <a href="{{ route('admin.stock-opname.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Mulai Sesi Opname Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>