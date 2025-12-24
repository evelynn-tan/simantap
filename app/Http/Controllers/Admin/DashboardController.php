<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pengajuan;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\StockOpname;
use Carbon\Carbon;

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
        $totalKategori = Kategori::count();
        $totalPegawai = Pegawai::count();

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

        // ========== DATA UNTUK CHARTS ==========

        // 1. Monthly Request Statistics (12 bulan tahun ini)
        $statistikBulanan = Pengajuan::selectRaw('MONTH(requested_at) as bulan, COUNT(*) as total')
            ->whereYear('requested_at', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $bulanLabels = [];
        $bulanData = [];
        $bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        for ($i = 1; $i <= 12; $i++) {
            $bulanLabels[] = $bulanNames[$i - 1];
            $bulanData[] = $statistikBulanan[$i] ?? 0;
        }

        // 2. Status Distribution (Pie Chart)
        $statusDistribution = [
            'menunggu' => $permintaanBaru,
            'disetujui' => $permintaanDisetujui,
            'ditolak' => $permintaanDitolak,
        ];

        // 3. Stok per Kategori (Bar Chart)
        $stokPerKategori = Kategori::withSum('barangs', 'stok')
            ->orderByDesc('barangs_sum_stok')
            ->take(6)
            ->get()
            ->map(fn($k) => [
                'nama' => $k->nama_kategori,
                'stok' => $k->barangs_sum_stok ?? 0
            ]);

        // 4. Top 5 Pegawai dengan Permintaan Terbanyak
        $topPegawai = Pegawai::withCount(['pengajuans as total_pengajuan' => function ($query) {
            $query->where('status', 'disetujui');
        }])
            ->orderByDesc('total_pengajuan')
            ->take(5)
            ->get();

        // 5. Trend Pengajuan 7 Hari Terakhir
        $trendHarian = [];
        $trendLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $trendLabels[] = $date->format('d/m');
            $trendHarian[] = Pengajuan::whereDate('requested_at', $date)->count();
        }

        // 6. Status Stok (Donut chart)
        $stokTersedia = Barang::tersedia()->count();
        $statusStok = [
            'tersedia' => $stokTersedia,
            'rendah' => $barangRendah,
            'habis' => $barangHabis,
        ];

        // 7. Recent Stock Opname
        $recentOpname = StockOpname::with('user')
            ->orderByDesc('tanggal_opname')
            ->take(3)
            ->get();
        
        // Total Opname (untuk KPI card)
        $totalOpname = StockOpname::count();

        return view('admin.dashboard', compact(
            'jumlahJenisAset',
            'permintaanBaru',
            'barangHabis',
            'barangRendah',
            'totalStok',
            'totalPermintaan',
            'totalKategori',
            'totalPegawai',
            'permintaanTerbaru',
            'barangTeratas',
            'permintaanDisetujui',
            'permintaanDitolak',
            // Chart Data
            'bulanLabels',
            'bulanData',
            'statusDistribution',
            'stokPerKategori',
            'topPegawai',
            'trendLabels',
            'trendHarian',
            'statusStok',
            'recentOpname',
            'totalOpname'
        ));
    }
}
