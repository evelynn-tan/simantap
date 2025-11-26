<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\StockOpname;
use App\Models\StockOpnameDetail;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
// TAMBAHKAN 3 BARIS INI
use App\Models\User;
use App\Models\Kategori;
use App\Models\Pengajuan;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman "Pusat Laporan"
     * Sesuai mockup: screencapture-fabric-camel-47506428-figma-site-2025-11-05-09_33_56.png
     */
    public function index(Request $request)
    {
        // PERBAIKAN DI SINI: Mengubah 'name' menjadi 'email' untuk orderBy, 
        // karena kolom 'name' tidak ada di tabel 'users'.
        $pegawais = User::where('role', 'pegawai')->orderBy('email')->get();
        
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $hasilLaporan = null;
        $jenisLaporan = $request->get('jenis_laporan');

        // Cek jika ada request untuk generate laporan
        if ($request->has('jenis_laporan')) {
            $query = Pengajuan::with('user', 'details.barang')
                            ->where('status', 'disetujui'); // Kita hanya laporkan yg disetujui

            // Filter Laporan Per Pegawai
            if ($request->filled('pegawai_id')) {
                $query->where('user_id', $request->pegawai_id);
            }
            // Filter Laporan Umum (Berdasarkan Kategori Barang)
            if ($request->filled('kategori_id')) {
                $query->whereHas('details.barang', function($q) use ($request) {
                    $q->where('kategori_id', $request->kategori_id);
                });
            }
            // Filter Tanggal
            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('processed_at', '>=', $request->tanggal_mulai);
            }
            if ($request->filled('tanggal_selesai')) {
                $query->whereDate('processed_at', '<=', $request->tanggal_selesai);
            }

            $hasilLaporan = $query->orderBy('processed_at', 'desc')->get();
        }

        return view('admin.laporan.index', compact('pegawais', 'kategoris', 'hasilLaporan', 'jenisLaporan'));
    }

    // Fungsi 'generate' sudah disatukan di 'index' untuk kemudahan
}