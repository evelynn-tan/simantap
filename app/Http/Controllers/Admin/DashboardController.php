<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pengajuan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk KPI Cards
        $jumlahJenisAset = Barang::count();
        $permintaanBaru = Pengajuan::where('status', 'menunggu')->count();
        $perluRestock = Barang::where('stok', '<', 5)->count(); // Asumsi stok kritis < 5
        $totalPermintaan = Pengajuan::count();
        $totalStok = Barang::sum('stok');

        // Data untuk tabel "Permintaan Terbaru"
        $permintaanTerbaru = Pengajuan::with('user', 'details.barang')
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Data untuk "Daftar Pegawai Teratas"
        $pegawaiTeratas = User::where('role', 'pegawai')
            ->withCount('pengajuans') // Menghitung jumlah pengajuan
            ->orderBy('pengajuans_count', 'desc')
            ->take(3)
            ->get();

        return view('admin.dashboard', compact(
            'jumlahJenisAset',
            'permintaanBaru',
            'perluRestock',
            'totalPermintaan',
            'totalStok',
            'permintaanTerbaru',
            'pegawaiTeratas'
        ));
    }
}
