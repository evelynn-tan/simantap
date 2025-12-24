<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailRangging;

class ManajemenPermintaanController extends Controller
{
    /**
     * Menampilkan daftar pengajuan
     */
    public function index()
    {
        $pengajuans = Pengajuan::with(['pegawai', 'pengajuanDetails.barang'])
            ->orderBy('requested_at', 'desc')
            ->get();

        return view('admin.permintaan.index', compact('pengajuans'));
    }

    /**
     * Menampilkan detail pengajuan
     */
    public function show(Pengajuan $pengajuan)
    {
        $pengajuan->load(['pegawai', 'pengajuanDetails.barang', 'approver']);

        return view('admin.permintaan.show', compact('pengajuan'));
    }

    /**
     * Menyetujui pengajuan
     * - Set status pengajuan = 'disetujui'
     * - Set per-item status = 'disetujui'
     * - Kurangi stok barang (dengan validasi dan partial approval)
     */
    public function setujui(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.pengajuanDetailID' => 'required|exists:pengajuan_details,pengajuanDetailID',
            'items.*.approve' => 'boolean',
            'items.*.jumlah_disetujui' => 'nullable|integer|min:0',
        ]);

        $userID = auth()->id();
        $now = now();

        try {
            DB::transaction(function () use ($request, $pengajuan, $userID, $now) {
                $errors = [];
                $hasApprovedItems = false;
                $approvedDetails = [];

                foreach ($request->items as $item) {
                    $detail = PengajuanDetail::findOrFail($item['pengajuanDetailID']);

                    if ($item['approve'] ?? false) {
                        // Skip custom items from stock deduction (they don't exist in inventory)
                        if (!empty($detail->nama_barang_custom)) {
                            $detail->update([
                                'status' => 'disetujui',
                                'jumlah_disetujui' => $detail->jumlah
                            ]);
                            $hasApprovedItems = true;
                            continue;
                        }

                        // Lock row untuk mencegah race condition
                        $barang = Barang::lockForUpdate()->find($detail->barangID);

                        // Tentukan jumlah yang disetujui (default: jumlah yang diminta)
                        $jumlahDiminta = $detail->jumlah;
                        $jumlahDisetujui = isset($item['jumlah_disetujui']) 
                            ? (int) $item['jumlah_disetujui'] 
                            : $jumlahDiminta;
                        
                        // Pastikan tidak melebihi jumlah yang diminta
                        $jumlahDisetujui = min($jumlahDisetujui, $jumlahDiminta);
                        
                        // Validasi ketersediaan stok
                        if ($barang->stok < $jumlahDisetujui) {
                            $errors[] = "Stok '{$barang->namaBarang}' tidak cukup (diminta: {$jumlahDisetujui}, tersedia: {$barang->stok})";
                            $detail->update(['status' => 'ditolak']);
                            continue;
                        }

                        // Simpan stok sebelumnya untuk histori
                        $stokSebelum = $barang->stok;

                        // Setujui item dengan jumlah yang disetujui
                        $detail->update([
                            'status' => 'disetujui',
                            'jumlah_disetujui' => $jumlahDisetujui
                        ]);

                        // Kurangi stok barang
                        $barang->decrement('stok', $jumlahDisetujui);
                        
                        // Simpan untuk histori transaksi
                        $approvedDetails[] = [
                            'barangID' => $barang->barangID,
                            'jumlah' => $jumlahDisetujui,
                            'stok_sebelum' => $stokSebelum,
                            'stok_sesudah' => $barang->stok,
                            'namaBarang' => $barang->namaBarang,
                        ];
                        
                        $hasApprovedItems = true;
                    } else {
                        // Item tidak dicentang = ditolak
                        $detail->update(['status' => 'ditolak']);
                    }
                }

                // Update status pengajuan
                $pengajuan->update([
                    'status' => $hasApprovedItems ? 'disetujui' : 'ditolak',
                    'approved_by' => $userID,
                    'approved_at' => $now,
                ]);

                // BARU: Catat histori transaksi barang keluar
                if (!empty($approvedDetails)) {
                    // Buat transaksi untuk barang keluar
                    $transaksi = Transaksi::create([
                        'userID' => $userID,
                        'tanggal' => $now->toDateString(),
                        'jenis' => 'keluar',
                        'sumber' => 'Pengajuan #' . $pengajuan->pengajuanID,
                        'keterangan' => 'Permintaan dari ' . ($pengajuan->nama_pegawai_snapshot ?? 'Pegawai'),
                    ]);

                    // Catat detail item yang keluar
                    foreach ($approvedDetails as $detailData) {
                        DetailRangging::create([
                            'transaksiID' => $transaksi->transaksiID,
                            'barangID' => $detailData['barangID'],
                            'jumlah' => $detailData['jumlah'],
                            'stok_sebelum' => $detailData['stok_sebelum'],
                            'stok_sesudah' => $detailData['stok_sesudah'],
                        ]);
                    }
                }

                // Jika ada error stok, lempar exception untuk info
                if (!empty($errors)) {
                    throw new \Exception(implode('; ', $errors));
                }
            });

            return redirect()->route('admin.permintaan.index')
                ->with('success', 'Pengajuan telah diproses dan stok berhasil dikurangi.');

        } catch (\Exception $e) {
            return redirect()->route('admin.permintaan.index')
                ->with('warning', 'Pengajuan diproses dengan catatan: ' . $e->getMessage());
        }
    }

    /**
     * Menolak pengajuan
     * - Set status pengajuan = 'ditolak'
     * - Set per-item status = 'ditolak'
     */
    public function tolak(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'alasan' => 'required|string|max:500',
        ]);

        $userID = auth()->id();
        $now = now();

        // Tolak semua item
        $pengajuan->pengajuanDetails()
            ->update(['status' => 'ditolak']);

        // Update pengajuan status
        $pengajuan->update([
            'status' => 'ditolak',
            'approved_by' => $userID,
            'approved_at' => $now,
            'alasan_penolakan' => $request->alasan,
        ]);

        return redirect()->route('admin.permintaan.index')
            ->with('success', 'Pengajuan telah ditolak.');
    }

    /**
     * Membatalkan pengajuan (hanya status 'menunggu')
     */
    public function batal(Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== 'menunggu') {
            return redirect()->back()
                ->with('error', 'Hanya pengajuan dengan status "menunggu" yang dapat dibatalkan.');
        }

        $pengajuan->pengajuanDetails()
            ->update(['status' => 'ditolak']);

        $pengajuan->update(['status' => 'dibatalkan']);

        return redirect()->route('admin.permintaan.index')
            ->with('success', 'Pengajuan telah dibatalkan.');
    }
}
