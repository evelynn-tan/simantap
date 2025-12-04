@extends('layouts.admin')

@section('title', 'Manajemen Permintaan - SIMANTAP')
@section('header', 'Manajemen Permintaan')
@section('subtitle', 'Kelola dan proses permintaan barang dari pegawai')

@section('content')
<div class="space-y-6" style="font-family: 'Poppins', sans-serif;">

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl p-6 text-white shadow-lg border border-blue-400">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-semibold uppercase mb-2">Total Permintaan</p>
                    <h3 class="text-4xl font-bold">{{ count($pengajuans) }}</h3>
                </div>
                <div class="h-12 w-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-xl p-6 text-white shadow-lg border border-yellow-400">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-semibold uppercase mb-2">Menunggu</p>
                    <h3 class="text-4xl font-bold">{{ count($pengajuans->where('status', 'menunggu')) }}</h3>
                </div>
                <div class="h-12 w-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hourglass text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-xl p-6 text-white shadow-lg border border-green-400">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-green-100 text-sm font-semibold uppercase mb-2">Disetujui</p>
                    <h3 class="text-4xl font-bold">{{ count($pengajuans->where('status', 'disetujui')) }}</h3>
                </div>
                <div class="h-12 w-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-xl p-6 text-white shadow-lg border border-red-400">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-red-100 text-sm font-semibold uppercase mb-2">Ditolak</p>
                    <h3 class="text-4xl font-bold">{{ count($pengajuans->where('status', 'ditolak')) }}</h3>
                </div>
                <div class="h-12 w-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-2xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Permintaan -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">📋 Daftar Permintaan Barang</h3>
            <p class="text-sm text-slate-500 mt-1">Kelola status permintaan yang masuk dari pegawai</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Barang Diminta</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Keperluan</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($pengajuans as $permintaan)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-700 font-medium whitespace-nowrap">
                            {{ $permintaan->requested_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-700 font-semibold">
                            {{ $permintaan->pegawai->nama_lengkap ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="space-y-1">
                                @foreach($permintaan->pengajuanDetails as $detail)
                                    <div class="text-slate-700">
                                        <span class="font-medium">{{ $detail->barang->namaBarang ?? 'N/A' }}</span>
                                        <span class="text-slate-500 text-xs">({{ $detail->jumlah }} {{ $detail->barang->satuan ?? 'unit' }})</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 max-w-xs">
                            <span class="line-clamp-1">{{ Str::limit($permintaan->description, 50) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($permintaan->status == 'menunggu')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-hourglass mr-1"></i> Menunggu
                                </span>
                            @elseif ($permintaan->status == 'disetujui')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i> Disetujui
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($permintaan->status == 'menunggu')
                                <div class="flex gap-2 justify-center">
                                    <button 
                                        onclick="openSetujuiModal({{ $permintaan->pengajuanID }})"
                                        class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 hover:bg-green-200 rounded-lg text-sm font-semibold transition duration-200"
                                        title="Setujui">
                                        <i class="fas fa-check mr-1"></i> Setujui
                                    </button>
                                    <button 
                                        onclick="openTolakModal({{ $permintaan->pengajuanID }})"
                                        class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-semibold transition duration-200"
                                        title="Tolak">
                                        <i class="fas fa-times mr-1"></i> Tolak
                                    </button>
                                </div>
                            @else
                                <span class="text-slate-400 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-slate-400">
                                <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                                <p class="font-medium">Belum ada permintaan barang</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ============ MODAL SETUJUI ============ -->
<div id="setujuiModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center px-6 py-5 border-b border-slate-200 sticky top-0 bg-white">
            <h3 class="text-lg font-bold text-slate-800">✅ Setujui Permintaan</h3>
            <button onclick="closeSetujuiModal()" class="text-slate-400 hover:text-slate-600 text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="formSetujui" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="pengajuanIDSetujui" name="pengajuan_id">
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Detail Barang</label>
                <div id="itemsContainer" class="bg-slate-50 border border-slate-200 rounded-lg p-4 space-y-3 max-h-64 overflow-y-auto">
                    <!-- Items akan di-populate oleh JavaScript -->
                </div>
            </div>

            <div class="flex gap-3 justify-end border-t border-slate-200 pt-4">
                <button type="button" onclick="closeSetujuiModal()" class="px-4 py-2 text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg font-semibold transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-lg font-semibold transition">
                    Setujui Semua
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============ MODAL TOLAK ============ -->
<div id="tolakModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-lg">
        <div class="flex justify-between items-center px-6 py-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">❌ Tolak Permintaan</h3>
            <button onclick="closeTolakModal()" class="text-slate-400 hover:text-slate-600 text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="formTolak" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="pengajuanIDTolak" name="pengajuan_id">
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Alasan Penolakan *</label>
                <textarea name="alasan" id="alasanTolak" required placeholder="Jelaskan alasan penolakan..." rows="5" class="block w-full border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none" style="font-family: 'Poppins', sans-serif;"></textarea>
            </div>

            <div class="flex gap-3 justify-end border-t border-slate-200 pt-4">
                <button type="button" onclick="closeTolakModal()" class="px-4 py-2 text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg font-semibold transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg font-semibold transition">
                    Tolak Permintaan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const pengajuanData = {
    @foreach($pengajuans as $p)
    {{ $p->pengajuanID }}: {
        id: {{ $p->pengajuanID }},
        pegawai: '{{ $p->pegawai->nama_lengkap ?? "Unknown" }}',
        details: [
            @foreach($p->pengajuanDetails as $detail)
            {
                id: {{ $detail->pengajuanDetailID }},
                nama: '{{ $detail->barang->namaBarang ?? "N/A" }}',
                jumlah: {{ $detail->jumlah }},
                satuan: '{{ $detail->barang->satuan ?? "unit" }}'
            },
            @endforeach
        ]
    },
    @endforeach
};

function openSetujuiModal(pengajuanID) {
    const data = pengajuanData[pengajuanID];
    if (!data) return;

    document.getElementById('pengajuanIDSetujui').value = pengajuanID;
    
    // Build items HTML
    let itemsHTML = '';
    data.details.forEach(item => {
        itemsHTML += `
            <div class="flex items-center justify-between py-3 border-b border-slate-200 last:border-0">
                <div class="flex-1">
                    <p class="font-medium text-slate-800">${item.nama}</p>
                    <p class="text-sm text-slate-500">Jumlah: ${item.jumlah} ${item.satuan}</p>
                </div>
                <input type="hidden" name="items[${item.id}][pengajuanDetailID]" value="${item.id}">
                <input type="checkbox" name="items[${item.id}][approve]" value="1" checked class="w-5 h-5 rounded text-blue-600 focus:ring-2 focus:ring-blue-500 cursor-pointer">
            </div>
        `;
    });
    
    document.getElementById('itemsContainer').innerHTML = itemsHTML;
    document.getElementById('formSetujui').action = `/admin/permintaan/setujui/${pengajuanID}`;
    document.getElementById('setujuiModal').style.display = 'flex';
}

function closeSetujuiModal() {
    document.getElementById('setujuiModal').style.display = 'none';
}

function openTolakModal(pengajuanID) {
    document.getElementById('pengajuanIDTolak').value = pengajuanID;
    document.getElementById('alasanTolak').value = '';
    document.getElementById('formTolak').action = `/admin/permintaan/tolak/${pengajuanID}`;
    document.getElementById('tolakModal').style.display = 'flex';
}

function closeTolakModal() {
    document.getElementById('tolakModal').style.display = 'none';
}

// Close modals on outside click
document.addEventListener('click', function(e) {
    const setujuiModal = document.getElementById('setujuiModal');
    const tolakModal = document.getElementById('tolakModal');
    
    if (e.target === setujuiModal) closeSetujuiModal();
    if (e.target === tolakModal) closeTolakModal();
});
</script>

@endsection