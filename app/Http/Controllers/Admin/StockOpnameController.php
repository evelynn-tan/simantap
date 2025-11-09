<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\StockOpname;
use App\Models\StockOpnameDetail;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Exception; // <-- TAMBAHKAN BARIS INI

class StockOpnameController extends Controller
{
    /**
     * Menampilkan halaman awal Stock Opname.
     * Sesuai mockup: image_f22b66.png
     */
    public function index()
    {
        // Anda bisa tambahkan logic untuk mengambil riwayat opname di sini
        return view('admin.stock-opname.index');
    }

    /**
     * Menampilkan halaman untuk memulai sesi opname baru.
     * Sesuai mockup: image_f222fe.png
     */
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
        // Validasi input. 'stok_fisik' adalah array.
        $request->validate([
            'stok_fisik' => 'required|array',
            'stok_fisik.*' => 'required|integer|min:0', // Pastikan semua input adalah angka 0 atau lebih
        ]);

        // Gunakan DB Transaction agar semua data tersimpan, atau tidak sama sekali
        DB::beginTransaction();
        try {
            // 1. Buat record StockOpname induk
            $opname = StockOpname::create([
                'operator_id' => auth()->id(),
                'tanggal_opname' => now(),
                'catatan' => $request->catatan, // Anda bisa tambahkan field catatan jika perlu
            ]);

            $stokFisikData = $request->stok_fisik;

            // 2. Loop setiap barang yang di-opname
            foreach ($stokFisikData as $barang_id => $stok_fisik) {
                $barang = Barang::find($barang_id);
                if (!$barang) continue; // Lewati jika barang tidak ditemukan

                $stok_sistem = $barang->stok;
                $selisih = $stok_fisik - $stok_sistem;

                // 3. Simpan ke StockOpnameDetail
                StockOpnameDetail::create([
                    'stock_opname_id' => $opname->id,
                    'barang_id' => $barang_id,
                    'stok_sistem' => $stok_sistem,
                    'stok_fisik' => $stok_fisik,
                    'selisih' => $selisih,
                ]);

                // 4. Jika ada selisih, update stok di tabel 'barangs'
                if ($selisih != 0) {
                    $barang->stok = $stok_fisik;
                    $barang->save();

                    // 5. Catat penyesuaian ini di tabel 'transaksis'
                    Transaksi::create([
                        'barang_id' => $barang_id,
                        'operator_id' => auth()->id(),
                        'jenis' => 'penyesuaian',
                        'jumlah' => $selisih, // Bisa positif (jika nambah) atau negatif (jika kurang)
                        'stok_sebelum' => $stok_sistem,
                        'stok_sesudah' => $stok_fisik,
                    ]);
                }
            }

            // Jika semua berhasil, commit
            DB::commit();

            return redirect()->route('admin.dashboard')->with('success', 'Stock Opname berhasil disimpan dan stok telah disesuaikan.');

        } catch (\Exception $e) {
            // Jika ada error, batalkan semua
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}