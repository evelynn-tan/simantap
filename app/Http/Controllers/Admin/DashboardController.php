<?php
// app/Http/Controllers/Admin/DashboardController.php

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
        // Data untuk KPI Cards
        $jumlahJenisAset = Barang::count();
        $permintaanBaru = Pengajuan::where('status', 'menunggu')->count();
        $barangStokRendah = Barang::where('stok_sekarang', '<', 5)->count();
        $totalPermintaan = Pengajuan::count();

        // PERBAIKAN: Hitung total stok semua barang
        $totalStok = Barang::sum('stok_sekarang');

        // Data untuk charts/tables
        $permintaanTerbaru = Pengajuan::with(['pegawai', 'pengajuanDetails.barang'])
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $barangTeratas = Barang::withCount(['pengajuanDetails as total_permintaan' => function ($query) {
            $query->whereHas('pengajuan', function ($q) {
                $q->where('status', 'disetujui');
            });
        }])
            ->orderBy('total_permintaan', 'desc')
            ->take(5)
            ->get();

        // Hitung permintaan disetujui dan ditolak
        $permintaanDisetujui = Pengajuan::where('status', 'disetujui')->count();
        $permintaanDitolak = Pengajuan::where('status', 'ditolak')->count();

        return view('admin.dashboard', compact(
            'jumlahJenisAset',
            'permintaanBaru',
            'barangStokRendah',
            'totalPermintaan',
            'totalStok', // TAMBAHKAN INI
            'permintaanTerbaru',
            'barangTeratas',
            'permintaanDisetujui',
            'permintaanDitolak'
        ));
    }
}
