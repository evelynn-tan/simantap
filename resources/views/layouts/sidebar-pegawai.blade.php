<aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50">
        <a href="{{ route('pegawai.dashboard') }}" class="flex items-center ps-2.5 mb-5">
            <img src="{{ asset('images/logo-bps.png') }}" class="h-6 me-3 sm:h-7" alt="Logo BPS" />
            <span class="self-center text-xl font-semibold whitespace-nowrap">SIMANTAP</span>
        </a>
        
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('pegawai.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pegawai.barang.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span>Daftar Barang Tersedia</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pegawai.permintaan.monitor') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span>Monitor Status Permintaan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pegawai.profil.edit') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span>Edit Profil</span>
                </a>
            </li>
        </ul>
    </div>
</aside>