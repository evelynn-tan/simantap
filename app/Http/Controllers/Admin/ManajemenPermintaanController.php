<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan; // <-- IMPORT MODEL YANG DIBUTUHKAN

class ManajemenPermintaanController extends Controller
{
    /**
     * Menampilkan halaman Manajemen Permintaan.
     * (Sesuai Activity Diagram "Memvalidasi Permintaan Barang", langkah "Menampilkan daftar...")
     */
    public function index()
    {
        // 1. Ambil semua data pengajuan dari database
        // Kita pakai ->with() agar data pegawai (user) dan barangnya (details.barang) ikut terambil
        $permintaan = Pengajuan::with('user', 'details.barang')
            ->orderBy('created_at', 'desc') // Urutkan dari yg terbaru
            ->get();

        // 2. Kirim data tersebut ke view yang akan kita buat
        return view('admin.permintaan.index', [
            'daftarPermintaan' => $permintaan
        ]);
    }

    /**
     * Memproses aksi "Setujui" permintaan.
     * (Sesuai Activity Diagram "Memvalidasi Permintaan Barang", alur "ya, stok mencukupi")
     */
    public function setujui($id)
    {
        $permintaan = Pengajuan::findOrFail($id);

        // 1. Ubah status pengajuan
        $permintaan->status = 'disetujui';
        $permintaan->operator_id = auth()->id(); // Catat siapa operator yg menyetujui
        $permintaan->processed_at = now();
        $permintaan->save();

        // 2. KURANGI STOK BARANG (LOGIKA PENTING)
        // (Ini akan meng-include use case "Mencatat Barang Keluar")
        foreach ($permintaan->details as $detail) {
            $barang = $detail->barang;

            // Catat di tabel transaksi (sesuai ERD)
            \App\Models\Transaksi::create([
                'barang_id' => $barang->id,
                'operator_id' => auth()->id(),
                'pengajuan_id' => $permintaan->id,
                'jenis' => 'keluar',
                'jumlah' => $detail->jumlah_diminta,
                'stok_sebelum' => $barang->stok,
                'stok_sesudah' => $barang->stok - $detail->jumlah_diminta,
            ]);

            // Update stok di master barang
            $barang->stok -= $detail->jumlah_diminta;
            $barang->save();
        }

        // 3. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('admin.permintaan.index')->with('success', 'Permintaan berhasil disetujui.');
    }

    /**
     * Memproses aksi "Tolak" permintaan.
     * (Sesuai Activity Diagram "Memvalidasi Permintaan Barang", alur "tidak")
     */
    public function tolak($id)
    {
        $permintaan = Pengajuan::findOrFail($id);

        // 1. Ubah status pengajuan
        $permintaan->status = 'ditolak';
        $permintaan->operator_id = auth()->id();
        $permintaan->processed_at = now();
        $permintaan->save();

        // 2. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('admin.permintaan.index')->with('success', 'Permintaan telah ditolak.');
    }
}
