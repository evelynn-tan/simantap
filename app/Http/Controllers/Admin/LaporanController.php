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
        // ... (Kode Pegawai dan Kategori)
        $pegawais = User::where('role', 'pegawai')->orderBy('email')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        
        $hasilLaporan = collect([]); 
        $jenisLaporan = $request->get('jenis_laporan', 'umum'); 

        if ($request->has('jenis_laporan') && ($request->jenis_laporan == 'umum' || $request->jenis_laporan == 'pegawai')) {
            
            // Query Dasar: Ambil Pengajuan yang statusnya disetujui
            $query = Pengajuan::with(['user', 'details.barang'])
                             ->where('status', 'disetujui');
            
            // Filter Berdasarkan Jenis Laporan dan Parameter Tambahan
            if ($jenisLaporan == 'pegawai') {
                // Filter wajib: Pegawai ID (sudah diperbaiki sebelumnya)
                if ($request->filled('pegawai_id')) {
                    $query->where('pegawaiID', $request->pegawai_id); 
                }
                
                // Filter Periode
                if ($request->filled('periode')) {
                    $days = (int) $request->periode;
                    if ($days > 0) {
                        // PERBAIKAN: Mengganti 'processed_at' menjadi 'approved_at'
                        $query->where('approved_at', '>=', Carbon::now()->subDays($days));
                    }
                }
            } elseif ($jenisLaporan == 'umum') {

                // Filter Tanggal Mulai dan Selesai
                if ($request->filled('tanggal_mulai')) {
                    // PERBAIKAN: Mengganti 'processed_at' menjadi 'approved_at'
                    $query->whereDate('approved_at', '>=', $request->tanggal_mulai);
                }
                if ($request->filled('tanggal_selesai')) {
                    $endDate = Carbon::parse($request->tanggal_selesai)->endOfDay();
                    // PERBAIKAN: Mengganti 'processed_at' menjadi 'approved_at'
                    $query->where('approved_at', '<=', $endDate);
                }
            }

            // Eksekusi Query dan Urutkan
            // PERBAIKAN: Mengganti 'processed_at' menjadi 'approved_at'
            $hasilLaporan = $query->orderBy('approved_at', 'desc')->get();
        }

        // 4. Kirimkan data ke view
        return view('admin.laporan.index', compact('pegawais', 'kategoris', 'hasilLaporan', 'jenisLaporan'));
    }

    public function generate(Request $request)
    {
        // Redirect kembali ke index dengan semua parameter filter
        return redirect()->route('admin.laporan.index', $request->except('action'));
    }
}