<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman "Pusat Laporan" dan memproses filter.
     */
    public function index(Request $request)
    {
<<<<<<< HEAD
        // PERBAIKAN DI SINI: Mengubah 'name' menjadi 'email' untuk orderBy, 
        // karena kolom 'name' tidak ada di tabel 'users'.
        $pegawais = User::where('role', 'pegawai')->orderBy('email')->get();
        
=======
        // 1. Ambil data yang dibutuhkan untuk filter dropdown
        // PERBAIKAN: Menggunakan get() terlebih dahulu, lalu diurutkan menggunakan Collection sortBy('name') 
        // untuk menghindari error SQL 'Unknown column name' dan memastikan pengurutan.
        $pegawais = User::where('role', 'pegawai')->get()->sortBy('name'); 
        
        // Asumsi 'nama_kategori' sudah benar di tabel 'kategoris'
>>>>>>> 0557b93218fdee1c56e83ef1ad5ba1ca00d8f418
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        
        // 2. Inisialisasi hasil laporan sebagai koleksi kosong
        $hasilLaporan = collect([]); 
        $jenisLaporan = $request->get('jenis_laporan', 'umum'); // Default ke 'umum'

        // 3. Logika Filter Laporan (Hanya eksekusi jika ada filter yang disubmit)
        if ($request->has('jenis_laporan') && ($request->jenis_laporan == 'umum' || $request->jenis_laporan == 'pegawai')) {
            
            // Query Dasar: Ambil Pengajuan yang statusnya disetujui (Barang Keluar)
            $query = Pengajuan::with(['user', 'details.barang'])
                             ->where('status', 'disetujui');
            
            // Filter Berdasarkan Jenis Laporan dan Parameter Tambahan
            if ($jenisLaporan == 'pegawai') {
                // Filter wajib: Pegawai ID
                if ($request->filled('pegawai_id')) {
                    // Menggunakan userID (sesuai pola non-standar DB Anda)
                    $query->where('userID', $request->pegawai_id); 
                }
                
                // Filter Periode
                if ($request->filled('periode')) {
                    $days = (int) $request->periode;
                    if ($days > 0) {
                        $query->where('processed_at', '>=', Carbon::now()->subDays($days));
                    }
                }

            } elseif ($jenisLaporan == 'umum') {
                 // Filter Laporan Umum (Berdasarkan Kategori Barang)
                if ($request->filled('kategori_id')) {
                    $kategoriId = $request->kategori_id;
                    $query->whereHas('details.barang', function($q) use ($kategoriId) {
                        // Menggunakan kategoriID (sesuai pola non-standar DB Anda)
                        $q->where('kategoriID', $kategoriId);
                    });
                }

                // Filter Tanggal Mulai dan Selesai
                if ($request->filled('tanggal_mulai')) {
                    $query->whereDate('processed_at', '>=', $request->tanggal_mulai);
                }
                if ($request->filled('tanggal_selesai')) {
                    $endDate = Carbon::parse($request->tanggal_selesai)->endOfDay();
                    $query->where('processed_at', '<=', $endDate);
                }
            }

            // Eksekusi Query dan Urutkan
            $hasilLaporan = $query->orderBy('processed_at', 'desc')->get();
        }

        // 4. Kirimkan data ke view
        // PENTING: Gunakan toArray() pada koleksi yang sudah diurutkan agar konsisten
        return view('admin.laporan.index', compact('pegawais', 'kategoris', 'hasilLaporan', 'jenisLaporan'));
    }

    // Metode untuk generate report (misalnya Export Excel/PDF)
    public function generate(Request $request)
    {
        // Redirect kembali ke index dengan semua parameter filter
        return redirect()->route('admin.laporan.index', $request->except('action'));
    }
}