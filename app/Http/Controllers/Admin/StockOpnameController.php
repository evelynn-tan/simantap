<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\StockOpname;
use App\Models\StockOpnameDetail;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Exception; 

class StockOpnameController extends Controller
{
    public function index()
    {
        // Anda bisa tambahkan logic untuk mengambil riwayat opname di sini
        return view('admin.stock-opname.index');
    }

    public function create()
    {
        $barangs = Barang::with('kategori')->orderBy('nama_barang')->get();
        return view('admin.stock-opname.create', compact('barangs'));
    }


    /**
     * Menyimpan hasil stock opname.
     * Sesuai Activity Diagram: Melakukan Stock Opname
     */
    public function store(Request $request)
    {
        $request->validate([
            'stok_fisik' => 'required|array',
            'stok_fisik.*' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat record StockOpname induk
            $opname = StockOpname::create([
                'operator_id' => auth()->id(),
                'tanggal_opname' => now(),
                'catatan' => $request->catatan, 
            ]);

            $stokFisikData = $request->stok_fisik;

            foreach ($stokFisikData as $barang_id => $stok_fisik) {
                $barang = Barang::find($barang_id);
                if (!$barang) continue; 

                $stok_sistem = $barang->stok;
                $selisih = $stok_fisik - $stok_sistem;

                StockOpnameDetail::create([
                    'stock_opname_id' => $opname->id,
                    'barang_id' => $barang_id,
                    'stok_sistem' => $stok_sistem,
                    'stok_fisik' => $stok_fisik,
                    'selisih' => $selisih,
                ]);

                if ($selisih != 0) {
                    // Update stok barang
                    $barang->stok = $stok_fisik;
                    $barang->save();

                    // Catat transaksi penyesuaian
                    Transaksi::create([
                        'barang_id' => $barang_id,
                        'operator_id' => auth()->id(),
                        'jenis' => 'penyesuaian',
                        'jumlah' => $selisih,
                        'stok_sebelum' => $stok_sistem,
                        'stok_sesudah' => $stok_fisik,
                    ]);
                }
            }

            DB::commit();

            // Mengubah redirect: Arahkan ke halaman rincian (show)
            return redirect()->route('admin.stock-opname.show', $opname->id)
                             ->with('success', 'Stock Opname berhasil disimpan dan stok telah disesuaikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
            'details.barang.kategori' // Eager loading untuk detail barang dan kategori
        ])->findOrFail($id);

        // Tampilkan view rincian
        return view('admin.stock-opname.detail', compact('opname')); // Menggunakan nama 'detail' sesuai konvensi Blade yang kita gunakan
    }
}