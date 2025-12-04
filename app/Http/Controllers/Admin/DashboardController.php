<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pengajuan;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Operator;

class DashboardController extends Controller
{
    public function index()
    {
        // KPI Cards
        $jumlahJenisAset = Barang::count();
        $permintaanBaru = Pengajuan::where('status', 'menunggu')->count();
        $barangHabis = Barang::habis()->count();
        $barangRendah = Barang::rendah()->count();
        $totalStok = Barang::sum('stok');
        $totalPermintaan = Pengajuan::count();

        // Recent Requests (waiting for approval)
        $permintaanTerbaru = Pengajuan::with(['pegawai', 'pengajuanDetails.barang'])
            ->where('status', 'menunggu')
            ->orderBy('requested_at', 'desc')
            ->take(5)
            ->get();

        // Top 5 Most Requested Items
        $barangTeratas = Barang::withCount(['pengajuanDetails as total_permintaan' => function ($query) {
            $query->whereHas('pengajuan', function ($q) {
                $q->where('status', 'disetujui');
            });
        }])
            ->orderBy('total_permintaan', 'desc')
            ->take(5)
            ->get();

        // Request Statistics
        $permintaanDisetujui = Pengajuan::where('status', 'disetujui')->count();
        $permintaanDitolak = Pengajuan::where('status', 'ditolak')->count();

        return view('admin.dashboard', compact(
            'jumlahJenisAset',
            'permintaanBaru',
            'barangHabis',
            'barangRendah',
            'totalStok',
            'totalPermintaan',
            'permintaanTerbaru',
            'barangTeratas',
            'permintaanDisetujui',
            'permintaanDitolak'
        ));
    }
}
