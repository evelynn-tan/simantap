<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\StockOpname;
use App\Models\StockOpnameDetail;
use App\Models\Transaksi; // Asumsi model ini ada untuk mencatat penyesuaian
use Illuminate\Support\Facades\DB;
use Exception;

class StockOpnameController extends Controller
{
    /**
     * Menampilkan halaman indeks dan daftar riwayat Stock Opname.
     */
    public function index()
    {
        // Mengambil semua riwayat Stock Opname, diurutkan dari yang terbaru.
        // Menggunakan with('operator') untuk mengambil data operator/user yang melakukan SO.
        $riwayatOpname = StockOpname::with('operator') 
            ->orderByDesc('tanggal_opname')
            ->get();

        // Mengirimkan data ke view
        return view('admin.stock-opname.index', [
            'riwayatOpname' => $riwayatOpname
        ]);
    }

    /**
     * Menampilkan formulir untuk membuat Stock Opname baru.
     */
    public function create()
    {
        // Mengambil semua data barang beserta kategorinya
        $barangs = Barang::with('kategori')->orderBy('nama_barang')->get();
        return view('admin.stock-opname.create', compact('barangs'));
    }


    /**
     * Menyimpan hasil stock opname dan melakukan koreksi stok.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'stok_fisik' => 'required|array',
            'stok_fisik.*' => 'required|integer|min:0', // Memastikan stok fisik adalah integer non-negatif
            'catatan' => 'nullable|string|max:255',
        ]);

        // Memulai transaksi database untuk memastikan atomisitas
        DB::beginTransaction();
        try {
            
            // 1. Buat record StockOpname induk
            $opname = StockOpname::create([
                // PERBAIKAN KRUSIAL 1: operatorID (sesuai DB)
                'operatorID' => auth()->id(), 
                'tanggal_opname' => now(),
                
                // PERBAIKAN KRUSIAL 2: keterangan (sesuai DB, bukan 'catatan')
                'keterangan' => $request->catatan, 
            ]);

            $stokFisikData = $request->stok_fisik;

            // 2. Iterasi melalui setiap item barang yang di-opname
            foreach ($stokFisikData as $barang_id => $stok_fisik) {
                $barang = Barang::find($barang_id);
                if (!$barang) continue; // Lewati jika barang tidak ditemukan

                // Ambil stok dari sistem (stok_sekarang)
                $stok_sistem = $barang->stok_sekarang; 
                $selisih = (int)$stok_fisik - (int)$stok_sistem;

                // 2.1. Catat Stock Opname Detail
                StockOpnameDetail::create([
                    // PERBAIKAN KRUSIAL 3: opnameID (sesuai DB)
                    'opnameID' => $opname->id,
                    
                    // PERBAIKAN KRUSIAL 4: barangID (sesuai DB)
                    'barangID' => $barang_id, 

                    'stok_sistem' => $stok_sistem,
                    'stok_fisik' => (int)$stok_fisik,
                    'selisih' => $selisih,
                ]);

                // 2.2. Koreksi Stok dan Catat Transaksi Penyesuaian jika ada selisih
                if ($selisih != 0) {
                    // Update stok barang di tabel barangs
                    $barang->stok_sekarang = (int)$stok_fisik; 
                    $barang->save();

                    // Catat transaksi penyesuaian di tabel transaksis
                    Transaksi::create([
                        'barangID' => $barang_id, 
                        'operatorID' => auth()->id(), 
                        'jenis' => 'penyesuaian', 
                        'jumlah' => $selisih,
                        'stok_sebelum' => $stok_sistem,
                        'stok_sesudah' => (int)$stok_fisik,
                        'referensi_id' => $opname->id, 
                        'referensi_jenis' => 'StockOpname', 
                    ]);
                }
            }

            // Commit transaksi jika semua berhasil
            DB::commit();

            // Arahkan ke halaman rincian (show)
            return redirect()->route('admin.stock-opname.show', $opname->id)
                             ->with('success', 'Stock Opname berhasil disimpan dan stok telah disesuaikan.');

        } catch (\Exception $e) {
            // Rollback jika terjadi kesalahan
            DB::rollBack();
            // Tampilkan pesan error
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan Stock Opname: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman rincian Stock Opname.
     */
    public function show($id)
    {
        // Ambil data opname, beserta relasi operator dan details
        $opname = StockOpname::with([
            'operator', 
            // Memastikan eager loading untuk detail barang dan kategori berjalan
            'details.barang.kategori' 
        ])->findOrFail($id);

        return view('admin.stock-opname.show', compact('opname')); 
    }
}