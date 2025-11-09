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
     * Sesuai mockup: screencapture-fabric-camel-47506428-figma-site-2025-11-05-09_32_57.jpg
     */
    public function index()
    {
        // Ambil semua data
        $barangs = Barang::with('kategori')->orderBy('nama_barang')->get();
        $totalBarang = $barangs->count();
        $totalKategori = Kategori::count();

        // Logika untuk KPI Card "Barang Habis" dan "Stok Rendah" (misal: rendah < 10)
        $barangHabis = $barangs->where('stok', 0)->count();
        $stokRendah = $barangs->where('stok', '>', 0)->where('stok', '<', 10)->count();

        // Kirim data ke view
        return view('admin.barang.index', compact(
            'barangs',
            'totalBarang',
            'totalKategori',
            'barangHabis',
            'stokRendah'
        ));
    }

    /**
     * Menampilkan halaman "Tambah Data Barang Baru" (Create)
     * Sesuai mockup: screencapture-fabric-camel-47506428-figma-site-2025-11-05-09_33_10.png
     */
    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('admin.barang.create', compact('kategoris'));
    }

    /**
     * Menyimpan data barang baru (Create)
     */
    public function store(Request $request)
    {
        // Validasi data (sesuai mockup "Status Validasi")
        $request->validate([
            'kode_barang' => 'required|string|max:255|unique:barangs',
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'satuan' => 'required|string|max:50',
            'stok_awal' => 'required|integer|min:0',
        ]);

        // Simpan data ke database
        Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'satuan' => $request->satuan,
            'stok' => $request->stok_awal,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.barang.index')->with('success', 'Barang baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman "Edit Data Barang" (Update)
     */
    public function edit(Barang $barang)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    /**
     * Memperbarui data barang (Update)
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:255|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
        ]);

        $barang->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'satuan' => $request->satuan,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.barang.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Menghapus data barang (Delete)
     */
    public function destroy(Barang $barang)
    {
        // Tambahkan cek jika barang masih ada di pengajuan, dll

        $barang->delete();
        return redirect()->route('admin.barang.index')->with('success', 'Data barang berhasil dihapus.');
    }
}
