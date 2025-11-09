<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermintaanController extends Controller
{
    /**
     * Menampilkan halaman "Daftar Barang Tersedia"
     * Sesuai mockup: ...09_31_00.jpg
     */
    public function daftarBarang(Request $request)
    {
        $query = Barang::with('kategori')->where('stok', '>', 0);

        // Logic untuk filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%')
                ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
        }

        // Logic untuk filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $barangs = $query->orderBy('nama_barang')->paginate(15); // Paginate 15 item per halaman

        return view('pegawai.permintaan.daftar-barang', compact('barangs'));
    }

    /**
     * Menampilkan halaman/form untuk "Mengajukan Permintaan Barang"
     */
    public function create()
    {
        // Ambil barang yang tersedia saja untuk ditampilkan di form
        $barangs = Barang::where('stok', '>', 0)->orderBy('nama_barang')->get();
        return view('pegawai.permintaan.create', compact('barangs'));
    }

    /**
     * Menyimpan data pengajuan baru dari form
     * Sesuai Activity Diagram: Mengajukan Permintaan Barang
     */
    public function ajukan(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'keperluan' => 'required|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ], [
            'keperluan.required' => 'Kolom keperluan wajib diisi.',
            'items.required' => 'Anda harus memilih minimal 1 barang.',
            'items.*.jumlah.min' => 'Jumlah barang tidak boleh 0.',
        ]);

        // 2. Cek apakah stok mencukupi untuk semua item
        foreach ($request->items as $item) {
            $barang = Barang::find($item['barang_id']);
            if ($barang->stok < $item['jumlah']) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Stok untuk barang "' . $barang->nama_barang . '" tidak mencukupi. Stok tersisa: ' . $barang->stok);
            }
        }

        // 3. Gunakan Transaction untuk menyimpan ke 2 tabel
        DB::beginTransaction();
        try {
            // Buat 1 data Pengajuan
            $pengajuan = Pengajuan::create([
                'user_id' => Auth::id(),
                'keperluan' => $request->keperluan,
                'status' => 'menunggu',
                'created_at' => now(),
            ]);

            // Loop untuk menyimpan barang-barangnya ke PengajuanDetail
            foreach ($request->items as $item) {
                PengajuanDetail::create([
                    'pengajuan_id' => $pengajuan->id,
                    'barang_id' => $item['barang_id'],
                    'jumlah_diminta' => $item['jumlah'],
                ]);
            }

            DB::commit(); // Semua berhasil, simpan permanen

            return redirect()->route('pegawai.permintaan.monitor')->with('success', 'Permintaan berhasil diajukan.');
        } catch (\Exception $e) {
            DB::rollBack(); // Ada error, batalkan semua
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan halaman "Monitor Status Permintaan"
     * Sesuai mockup: ...09_31_20.jpg
     */
    public function monitor(Request $request)
    {
        $query = Pengajuan::with('details.barang')
            ->where('user_id', Auth::id());

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

        $permintaans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pegawai.permintaan.monitor', compact('permintaans'));
    }
}
