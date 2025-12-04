<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\StockOpname;
use App\Models\StockOpnameDetail;
use App\Models\DetailRangging;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    /**
     * Display list of stock opname records
     */
    public function index()
    {
        $riwayatOpname = StockOpname::with('user')
            ->orderByDesc('tanggal_opname')
            ->paginate(10);

        return view('admin.stock-opname.index', compact('riwayatOpname'));
    }

    /**
     * Show form to create new stock opname
     */
    public function create()
    {
        $barangs = Barang::with('kategori')
            ->orderBy('kode_barang')
            ->get();

        return view('admin.stock-opname.create', compact('barangs'));
    }

    /**
     * Save stock opname and adjust inventory
     */
    public function store(Request $request)
    {
        $request->validate([
            'stok_fisik' => 'required|array',
            'stok_fisik.*' => 'required|integer|min:0',
            'keterangan' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $userID = Auth::id();
            $now = now();

            // Create stock opname header
            $opname = StockOpname::create([
                'userID' => $userID,
                'tanggal_opname' => $now->toDateString(),
                'keterangan' => $request->keterangan,
            ]);

            $stokFisikData = $request->stok_fisik;
            $totalSelisih = 0;

            // Process each item
            foreach ($stokFisikData as $barang_id => $stok_fisik) {
                $barangID = (int) $barang_id;

                // Skip invalid IDs
                if ($barangID <= 0) {
                    continue;
                }

                $barang = Barang::where('barangID', $barangID)->first();

                if (!$barang) {
                    continue;
                }

                $stok_sistem = $barang->stok;
                $stok_fisik = (int) $stok_fisik;
                $selisih = $stok_fisik - $stok_sistem;

                // Record stock opname detail
                StockOpnameDetail::create([
                    'opnameID' => $opname->opnameID,
                    'barangID' => $barangID,
                    'stok_sistem' => $stok_sistem,
                    'stok_fisik' => $stok_fisik,
                    'stok_selisih' => $selisih,
                    'keterangan' => $request->keterangan ?? null,
                ]);

                // If difference exists, create adjustment transaction
                if ($selisih !== 0) {
                    $totalSelisih += $selisih;

                    // Update barang stok
                    $barang->update(['stok' => $stok_fisik]);

                    // Create adjustment transaction (penyesuaian)
                    $transaksi = Transaksi::create([
                        'userID' => $userID,
                        'tanggal' => $now->toDateString(),
                        'jenis' => 'penyesuaian',
                        'sumber' => 'Stock Opname #' . $opname->opnameID,
                        'keterangan' => 'Penyesuaian stok dari opname',
                    ]);

                    // Create detail entry
                    DetailRangging::create([
                        'transaksiID' => $transaksi->transaksiID,
                        'barangID' => $barangID,
                        'jumlah' => abs($selisih),
                        'stok_sebelum' => $stok_sistem,
                        'stok_sesudah' => $stok_fisik,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.stock-opname.show', $opname->opnameID)
                ->with('success', "Stock Opname berhasil disimpan. Total selisih: {$totalSelisih} item");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Show stock opname details
     */
    public function show(StockOpname $opname)
    {
        $opname->load(['user', 'details.barang.kategori']);

        return view('admin.stock-opname.show', compact('opname'));
    }

    /**
     * Delete stock opname (only draft/unclosed)
     */
    public function destroy(StockOpname $opname)
    {
        try {
            // Delete related details first
            StockOpnameDetail::where('opnameID', $opname->opnameID)->delete();

            // Delete the opname record
            $opname->delete();

            return redirect()->route('admin.stock-opname.index')
                ->with('success', 'Stock Opname berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}