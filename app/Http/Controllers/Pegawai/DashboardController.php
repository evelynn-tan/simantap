<?php
// app/Http/Controllers/Pegawai/DashboardController.php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Pegawai;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Dapatkan data pegawai berdasarkan userID
        $pegawai = Pegawai::where('userID', $userId)->firstOrFail();

        if (!$pegawai) {
            abort(404, 'Data pegawai tidak ditemukan');
        }

        $pegawaiID = $pegawai->pegawaiID;

        // Data untuk KPI Cards
        $barangDigunakan = Pengajuan::where('pegawaiID', $pegawaiID)
            ->where('status', 'disetujui')
            ->count();

        $totalPermintaan = Pengajuan::where('pegawaiID', $pegawaiID)->count();

        $menungguPersetujuan = Pengajuan::where('pegawaiID', $pegawaiID)
            ->where('status', 'menunggu')
            ->count();

        // Barang yang sedang digunakan (detail)
        $barangSedangDigunakan = Pengajuan::with(['pengajuanDetails.barang'])
            ->where('pegawaiID', $pegawaiID)
            ->where('status', 'disetujui')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Riwayat 5 permintaan terakhir
        $riwayatPermintaan = Pengajuan::with(['pengajuanDetails.barang'])
            ->where('pegawaiID', $pegawaiID)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // TOP 5 barang paling sering diminta user
        $topBarang = Pengajuan::with('pengajuanDetails.barang')
            ->where('pegawaiID', $pegawaiID)
            ->whereHas('pengajuanDetails')
            ->get()
            ->flatMap->pengajuanDetails
            ->groupBy('barangID')
            ->map(function ($items) {
                return [
                    'nama_barang' => $items->first()->barang->nama_barang,
                    'total' => $items->sum('jumlah')
                ];
            })
            ->sortByDesc('total')
            ->take(5)
            ->values();

        // Grafik jumlah permintaan per bulan (12 bulan terakhir)
        $statistikBulanan = Pengajuan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('pegawaiID', $pegawaiID)
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Format array bulan 1–12
        $bulanLabels = [];
        $bulanData = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanLabels[] = date('F', mktime(0, 0, 0, $i, 1));
            $bulanData[] = $statistikBulanan[$i] ?? 0;
        }

        // Statistik status permintaan
        $statusCounts = [
            'disetujui' => Pengajuan::where('pegawaiID', $pegawaiID)->where('status', 'disetujui')->count(),
            'menunggu'  => Pengajuan::where('pegawaiID', $pegawaiID)->where('status', 'menunggu')->count(),
            'ditolak'   => Pengajuan::where('pegawaiID', $pegawaiID)->where('status', 'ditolak')->count(),
        ];

        return view('pegawai.dashboard', compact(
            'barangDigunakan',
            'totalPermintaan',
            'menungguPersetujuan',
            'barangSedangDigunakan',
            'riwayatPermintaan',
            'bulanLabels',
            'bulanData',
            'statusCounts',
            'pegawai',
            'topBarang'
        ));
    }
}
