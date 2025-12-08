<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;

class DataBarangController extends Controller
{
    /**
     * Menampilkan halaman "Data Barang" (Read)
     */
    public function index()
    {
        $barangs = Barang::with('kategori')->orderBy('namaBarang')->get();
        $totalBarang = $barangs->count();
        $totalKategori = Kategori::count();
        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        // KPI Metrics
        $barangHabis = $barangs->where('stok', 0)->count();
        $stokRendah = $barangs->where('stok', '>', 0)->where('stok', '<', 5)->count();

        return view('admin.barang.index', compact(
            'barangs',
            'totalBarang',
            'totalKategori',
            'barangHabis',
            'stokRendah',
            'kategoriList'
        ));
    }

    /**
     * Menampilkan halaman "Tambah Data Barang Baru" (Create)
     */
    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $satuanOptions = ['rim', 'pcs', 'buah', 'box', 'pack', 'set', 'lembar', 'meter', 'kg', 'liter'];

        return view('admin.barang.create', compact('kategoris', 'satuanOptions'));
    }

    /**
     * Menyimpan data barang baru (Create)
     * - Auto-generate kode barang (BRG-001, dst)
     * - Cek duplikasi nama barang & suggest duplicate
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'namaBarang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,categoryID',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
        ]);

        // CEK DUPLIKASI BARANG
        $existingBarang = Barang::where('namaBarang', $request->namaBarang)
            ->where('categoryID', $request->kategori_id)
            ->where('satuan', $request->satuan)
            ->first();

        if ($existingBarang) {
            return redirect()->back()
                ->withInput()
                ->with('warning', "Barang '{$existingBarang->namaBarang}' ({$existingBarang->kode_barang}) sudah ada. Stok ditambah? Hubungi operator.");
        }

        // CREATE BARANG BARU
        // Kode barang auto-generate di Model::booted()
        $barang = Barang::create([
            'namaBarang' => $request->namaBarang,
            'categoryID' => $request->kategori_id,
            'satuan' => $request->satuan,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi ?? null,
        ]);

        return redirect()->route('admin.barang.index')
            ->with('success', "Barang baru '{$barang->namaBarang}' ({$barang->kode_barang}) berhasil ditambahkan.");
    }

    /**
     * Menampilkan detail barang (Show)
     * Redirect ke edit karena tidak ada halaman show khusus
     */
    public function show(Barang $barang)
    {
        // Redirect ke edit page karena tidak ada halaman detail khusus
        return redirect()->route('admin.barang.edit', $barang->barangID);
    }

    /**
     * Menampilkan halaman "Edit Data Barang" (Update)
     */
    public function edit(Barang $barang)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $satuanOptions = ['rim', 'pcs', 'buah', 'box', 'pack', 'set', 'lembar', 'meter', 'kg', 'liter'];

        return view('admin.barang.edit', compact('barang', 'kategoris', 'satuanOptions'));
    }

    /**
     * Memperbarui data barang (Update)
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'namaBarang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,categoryID',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
        ]);

        $barang->update([
            'namaBarang' => $request->namaBarang,
            'categoryID' => $request->kategori_id,
            'satuan' => $request->satuan,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi ?? null,
        ]);

        return redirect()->route('admin.barang.index')
            ->with('success', "Data barang '{$barang->namaBarang}' berhasil diperbarui.");
    }

    /**
     * Menghapus data barang (Delete)
     * CHECK: Jika barang digunakan di pengajuan_details, tidak boleh dihapus
     */
    public function destroy(Barang $barang)
    {
        $nama = $barang->namaBarang;
        $kode = $barang->kode_barang;

        // CEK apakah barang digunakan di pengajuan_details atau transaksi
        $pengajuanDetailsCount = $barang->pengajuanDetails()->count();
        $detailRanggingCount = $barang->detailRangggings()->count();
        $stockOpnameDetailsCount = $barang->stockOpnameDetails()->count();

        if ($pengajuanDetailsCount > 0 || $detailRanggingCount > 0 || $stockOpnameDetailsCount > 0) {
            return redirect()->route('admin.barang.index')
                ->with('error', "Barang '{$nama}' ({$kode}) tidak dapat dihapus karena sudah digunakan dalam permintaan, transaksi, atau stock opname.");
        }

        $barang->delete();

        return redirect()->route('admin.barang.index')
            ->with('success', "Barang '{$nama}' ({$kode}) berhasil dihapus.");
    }

    /**
     * AJAX Search endpoint
     */
    public function search(Request $request)
    {
        $search = $request->get('q', '');

        $barangs = Barang::where('namaBarang', 'like', "%{$search}%")
            ->orWhere('kode_barang', 'like', "%{$search}%")
            ->with('kategori')
            ->limit(10)
            ->get();

        return response()->json([
            'data' => $barangs->map(fn($b) => [
                'barangID' => $b->barangID,
                'kode_barang' => $b->kode_barang,
                'namaBarang' => $b->namaBarang,
                'stok' => $b->stok,
                'status' => $b->status,
                'satuan' => $b->satuan,
            ])
        ]);
    }
}
