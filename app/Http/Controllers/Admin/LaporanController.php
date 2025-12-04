<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Pengajuan;
use App\Models\Laporan;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Display reports index with filters
     */
    public function index(Request $request)
    {
        $pegawais = User::where('role', 'pegawai')->orderBy('email')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        $hasilLaporan = collect([]);
        $jenisLaporan = $request->get('jenis_laporan', 'umum');

        if ($request->has('jenis_laporan') && in_array($jenisLaporan, ['umum', 'pegawai', 'stok'])) {

            // Base Query
            $query = Pengajuan::with(['pegawai', 'pengajuanDetails.barang', 'approver'])
                ->where('status', 'disetujui');

            // Filter by Request Type
            if ($jenisLaporan == 'pegawai') {
                if ($request->filled('pegawai_id')) {
                    $query->where('pegawaiID', $request->pegawai_id);
                }

                // Filter by Period
                if ($request->filled('periode')) {
                    $days = (int) $request->periode;
                    if ($days > 0) {
                        $query->where('approved_at', '>=', Carbon::now()->subDays($days));
                    }
                }
            } elseif ($jenisLaporan == 'umum') {
                // Date Range Filter
                if ($request->filled('tanggal_mulai')) {
                    $query->whereDate('approved_at', '>=', $request->tanggal_mulai);
                }
                if ($request->filled('tanggal_selesai')) {
                    $endDate = Carbon::parse($request->tanggal_selesai)->endOfDay();
                    $query->where('approved_at', '<=', $endDate);
                }
            } elseif ($jenisLaporan == 'stok') {
                // Stock Report by Category
                if ($request->filled('kategori_id')) {
                    $query->whereHas('pengajuanDetails.barang', function ($q) use ($request) {
                        $q->where('kategoriID', $request->kategori_id);
                    });
                }
            }

            $hasilLaporan = $query->orderBy('approved_at', 'desc')->get();
        }

        return view('admin.laporan.index', compact('pegawais', 'kategoris', 'hasilLaporan', 'jenisLaporan'));
    }

    /**
     * Generate and save report as permanent record
     */
    public function generate(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:pengajuan,stok,transaksi',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
        ]);

        $userID = Auth::id();
        $jenis = $request->jenis;
        $periodeAwal = $request->periode_awal;
        $periodeAkhir = $request->periode_akhir;

        // Build report data based on type
        $isi = [];
        $totalItems = 0;

        if ($jenis === 'pengajuan') {
            $items = Pengajuan::whereBetween('requested_at', [$periodeAwal, $periodeAkhir])
                ->where('status', 'disetujui')
                ->with(['pegawai', 'pengajuanDetails.barang'])
                ->get();

            $totalItems = $items->count();
            $isi = $items->map(fn($p) => [
                'pengajuanID' => $p->pengajuanID,
                'pegawai' => $p->pegawai->nama_lengkap,
                'tanggal' => $p->requested_at->format('Y-m-d'),
                'items_count' => $p->pengajuanDetails->count(),
                'total_jumlah' => $p->pengajuanDetails->sum('jumlah'),
                'status' => $p->status,
            ])->toArray();
        } elseif ($jenis === 'stok') {
            $items = Barang::with('kategori')->get();
            $totalItems = $items->count();
            $isi = $items->map(fn($b) => [
                'barangID' => $b->barangID,
                'kode_barang' => $b->kode_barang,
                'nama_barang' => $b->nama_barang,
                'kategori' => $b->kategori->nama_kategori,
                'stok' => $b->stok,
                'status' => $b->status,
                'satuan' => $b->satuan,
            ])->toArray();
        } elseif ($jenis === 'transaksi') {
            $items = Pengajuan::whereBetween('requested_at', [$periodeAwal, $periodeAkhir])
                ->with(['pengajuanDetails.barang'])
                ->get();

            $totalItems = $items->flatMap(fn($p) => $p->pengajuanDetails)->count();
            $isi = $items->flatMap(function ($p) {
                return $p->pengajuanDetails->map(fn($d) => [
                    'pengajuanID' => $p->pengajuanID,
                    'barang' => $d->barang->nama_barang,
                    'jumlah' => $d->jumlah,
                    'satuan' => $d->barang->satuan,
                    'tanggal' => $p->requested_at->format('Y-m-d'),
                ]);
            })->toArray();
        }

        // Save permanent report record
        Laporan::create([
            'userID' => $userID,
            'jenis' => $jenis,
            'periode_awal' => $periodeAwal,
            'periode_akhir' => $periodeAkhir,
            'total_items' => $totalItems,
            'isi' => json_encode($isi),
            'status' => 'draft',
        ]);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dibuat (status: draft)');
    }

    /**
     * Finalize a draft report
     */
    public function finalize(Laporan $laporan)
    {
        if ($laporan->status !== 'draft') {
            return redirect()->back()->with('error', 'Hanya laporan draft yang dapat diselesaikan.');
        }

        $laporan->update([
            'status' => 'final',
            'finalized_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Laporan telah diselesaikan.');
    }

    /**
     * Approve a finalized report
     */
    public function approve(Laporan $laporan)
    {
        if ($laporan->status !== 'final') {
            return redirect()->back()->with('error', 'Hanya laporan final yang dapat disetujui.');
        }

        $laporan->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Laporan telah disetujui.');
    }

    /**
     * View report details
     */
    public function show(Laporan $laporan)
    {
        $laporan->load('user');
        return view('admin.laporan.show', compact('laporan'));
    }

    /**
     * Legacy generate endpoint (redirect)
     */
    public function generateLegacy(Request $request)
    {
        return redirect()->route('admin.laporan.index', $request->except('action'));
    }
}