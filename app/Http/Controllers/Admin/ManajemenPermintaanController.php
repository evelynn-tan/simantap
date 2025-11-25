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
        // Kita pakai ->with() agar data pegawai dan barangnya ikut terambil
        $permintaan = Pengajuan::with('pegawai', 'pengajuanDetails.barang')
        // Kita pakai ->with() agar data pegawai (user) dan barangnya (details.barang) ikut terambil
        $permintaan = Pengajuan::with('pegawai', 'details.barang')
            ->orderBy('created_at', 'desc') // Urutkan dari yg terbaru
            ->get();

        // 2. Kirim data tersebut ke view yang akan kita buat
        return view('admin.permintaan.index', [
            'daftarPermintaan' => $permintaan
        ]);
    }

    /**
     * Memproses aksi "Setujui" permintaan.
     */
    public function setujui(Pengajuan $pengajuan)
    {
        // Ubah status pengajuan
        $pengajuan->status = 'disetujui';
        $pengajuan->approved_by = auth()->id();
        $pengajuan->approved_at = now();
        $pengajuan->save();

        $pengajuan = Pengajuan::findOrFail($id);

        // Ubah status pengajuan
        $pengajuan->status = 'disetujui';
        $pengajuan->approved_by = auth()->id();
        $pengajuan->approved_at = now();
        $pengajuan->save();

        // Kurangi stok barang
        foreach ($pengajuan->details as $detail) {
            $barang = $detail->barang;
            $barang->stok_sekarang -= $detail->jumlah;
            $barang->save();
        }

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('admin.permintaan.index')->with('success', 'Permintaan berhasil disetujui.');
    }

    /**
     * Memproses aksi "Tolak" permintaan.
     */
    public function tolak(Pengajuan $pengajuan)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        // Ubah status pengajuan
        $pengajuan->status = 'ditolak';
        $pengajuan->approved_by = auth()->id();
        $pengajuan->approved_at = now();
        $pengajuan->save();

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('admin.permintaan.index')->with('success', 'Permintaan telah ditolak.');
    }
}
