<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-blue-900 text-white" aria-label="Sidebar">
    <div class="h-full flex flex-col">
        <!-- Logo Header -->
        <div class="p-4 border-b border-blue-800 bg-blue-900">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                <img src="{{ asset('images/logo-bps.png') }}" class="h-10 w-10 bg-white rounded-full p-1" alt="Logo" onerror="this.style.display='none'"/>
                <div>
                    <h1 class="text-xl font-bold text-white tracking-wide">SIMANTAP</h1>
                    <p class="text-xs text-blue-200">Admin BMN</p>
                </div>
            </a>
        </div>

        <!-- Menu Items -->
        <div class="px-3 py-4 overflow-y-auto flex-1 bg-blue-900 scrollbar-hide">
             <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-blue-800 group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'border-l-4 border-transparent' }}">
                        <i class="fas fa-tachometer-alt w-5 h-5 text-blue-300 group-hover:text-white"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.permintaan.index') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-blue-800 group {{ request()->routeIs('admin.permintaan.*') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'border-l-4 border-transparent' }}">
                        <i class="fas fa-clipboard-list w-5 h-5 text-blue-300 group-hover:text-white"></i>
                        <span class="ml-3">Manajemen Permintaan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.barang.index') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-blue-800 group {{ request()->routeIs('admin.barang.*') && !request()->routeIs('admin.barang.create') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'border-l-4 border-transparent' }}">
                        <i class="fas fa-boxes w-5 h-5 text-blue-300 group-hover:text-white"></i>
                        <span class="ml-3">Data Barang</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.barang.create') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-blue-800 group {{ request()->routeIs('admin.barang.create') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'border-l-4 border-transparent' }}">
                        <i class="fas fa-plus-circle w-5 h-5 text-blue-300 group-hover:text-white"></i>
                        <span class="ml-3">Tambah Barang Baru</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.stock-opname.index') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-blue-800 group {{ request()->routeIs('admin.stock-opname.*') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'border-l-4 border-transparent' }}">
                        <i class="fas fa-clipboard-check w-5 h-5 text-blue-300 group-hover:text-white"></i>
                        <span class="ml-3">Stock Opname</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pengguna.index') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-blue-800 group {{ request()->routeIs('admin.pengguna.*') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'border-l-4 border-transparent' }}">
                        <i class="fas fa-users w-5 h-5 text-blue-300 group-hover:text-white"></i>
                        <span class="ml-3">Manajemen Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.laporan.index') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-blue-800 group {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'border-l-4 border-transparent' }}">
                        <i class="fas fa-chart-bar w-5 h-5 text-blue-300 group-hover:text-white"></i>
                        <span class="ml-3">Laporan</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>