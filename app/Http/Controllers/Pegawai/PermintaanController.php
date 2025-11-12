<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermintaanController extends Controller
{
    /**
     * Menampilkan halaman "Daftar Barang Tersedia"
     */
    public function daftarBarang(Request $request)
    {
        $userId = Auth::id();
        $pegawai = Pegawai::where('userID', $userId)->first();

        $query = Barang::with('kategori')
            ->where('status', 'tersedia')
            ->where('stok_sekarang', '>', 0);

        // Logic untuk filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%')
                ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
        }

        // Logic untuk filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategoriID', $request->kategori);
        }

        $barangs = $query->orderBy('nama_barang')->get();

        return view('pegawai.daftar-barang', compact('barangs', 'pegawai'));
    }

    /**
     * Menampilkan halaman/form untuk "Mengajukan Permintaan Barang"
     */
    public function create()
    {
        $userId = Auth::id();
        $pegawai = Pegawai::where('userID', $userId)->first();

        // Ambil barang yang tersedia saja untuk ditampilkan di form
        $barangs = Barang::where('status', 'tersedia')
            ->where('stok_sekarang', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        return view('pegawai.permintaan.create', compact('barangs', 'pegawai'));
    }

    /**
     * Menyimpan data pengajuan baru dari form
     */
    public function ajukan(Request $request)
    {
        $userId = Auth::id();
        $pegawai = Pegawai::where('userID', $userId)->first();

        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        // 1. Validasi input
        $request->validate([
            'description' => 'required|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.barangID' => 'required|exists:barangs,barangID',
            'items.*.jumlah' => 'required|integer|min:1',
        ], [
            'description.required' => 'Kolom keperluan wajib diisi.',
            'items.required' => 'Anda harus memilih minimal 1 barang.',
            'items.*.jumlah.min' => 'Jumlah barang tidak boleh 0.',
        ]);

        // 2. Cek apakah stok mencukupi untuk semua item
        foreach ($request->items as $item) {
            $barang = Barang::find($item['barangID']);
            if ($barang->stok_sekarang < $item['jumlah']) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Stok untuk barang "' . $barang->nama_barang . '" tidak mencukupi. Stok tersisa: ' . $barang->stok_sekarang);
            }
        }

        // 3. Gunakan Transaction untuk menyimpan ke 2 tabel
        DB::beginTransaction();
        try {
            // Buat 1 data Pengajuan
            $pengajuan = Pengajuan::create([
                'pegawaiID' => $pegawai->pegawaiID,
                'requested_at' => now(),
                'description' => $request->description,
                'status' => 'menunggu',
            ]);

            // Loop untuk menyimpan barang-barangnya ke PengajuanDetail
            foreach ($request->items as $item) {
                PengajuanDetail::create([
                    'pengajuanID' => $pengajuan->pengajuanID,
                    'barangID' => $item['barangID'],
                    'jumlah' => $item['jumlah'],
                ]);
            }

            DB::commit(); // Semua berhasil, simpan permanen

            return redirect()->route('pegawai.monitor-permintaan')->with('success', 'Permintaan berhasil diajukan.');
        } catch (\Exception $e) {
            DB::rollBack(); // Ada error, batalkan semua
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan halaman "Monitor Status Permintaan"
     */
    public function monitor(Request $request)
    {
        $userId = Auth::id();
        $pegawai = Pegawai::where('userID', $userId)->first();

        if (!$pegawai) {
            abort(404, 'Data pegawai tidak ditemukan');
        }

        $query = Pengajuan::with(['pengajuanDetails.barang'])
            ->where('pegawaiID', $pegawai->pegawaiID);

        // Logic untuk filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Logic untuk filter tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $permintaan = $query->orderBy('created_at', 'desc')->get();

        return view('pegawai.monitor-permintaan', compact('permintaan', 'pegawai'));
    }
}
