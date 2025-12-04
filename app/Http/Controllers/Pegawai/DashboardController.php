<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Pegawai;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Get pegawai data
        $pegawai = Pegawai::where('userID', $userId)->firstOrFail();

        if (!$pegawai) {
            abort(404, 'Data pegawai tidak ditemukan');
        }

        $pegawaiID = $pegawai->pegawaiID;

        // KPI Cards
        $barangDigunakan = Pengajuan::where('pegawaiID', $pegawaiID)
            ->where('status', 'disetujui')
            ->count();

        $totalPermintaan = Pengajuan::where('pegawaiID', $pegawaiID)->count();

        $menungguPersetujuan = Pengajuan::where('pegawaiID', $pegawaiID)
            ->where('status', 'menunggu')
            ->count();

        $permintaanDitolak = Pengajuan::where('pegawaiID', $pegawaiID)
            ->where('status', 'ditolak')
            ->count();

        // Main Data - Approved Items (AJAX-supported pagination)
        $barangSedangDigunakan = Pengajuan::with(['pengajuanDetails.barang'])
            ->where('pegawaiID', $pegawaiID)
            ->where('status', 'disetujui')
            ->orderBy('requested_at', 'desc')
            ->paginate(5);

        if ($request->ajax()) {
            return view('pegawai.partials.barang-saya-table', compact('barangSedangDigunakan'))->render();
        }

        // Recent 5 Requests
        $riwayatPermintaan = Pengajuan::with(['pengajuanDetails.barang'])
            ->where('pegawaiID', $pegawaiID)
            ->orderBy('requested_at', 'desc')
            ->take(5)
            ->get();

        // Top 5 Most Requested Items
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

        // Monthly Statistics (12 months current year)
        $statistikBulanan = Pengajuan::selectRaw('MONTH(requested_at) as bulan, COUNT(*) as total')
            ->where('pegawaiID', $pegawaiID)
            ->whereYear('requested_at', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $bulanLabels = [];
        $bulanData = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanLabels[] = date('F', mktime(0, 0, 0, $i, 1));
            $bulanData[] = $statistikBulanan[$i] ?? 0;
        }

        // Status Summary
        $statusCounts = [
            'disetujui' => $barangDigunakan,
            'menunggu'  => $menungguPersetujuan,
            'ditolak'   => $permintaanDitolak,
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