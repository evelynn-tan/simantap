<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use App\Models\Barang;

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
     * 
     * PERBAIKAN:
     * - Database transaction dengan row locking untuk mencegah race condition
     * - Validasi stok sebelum decrement
     * - Support partial approval (jumlah_disetujui <= jumlah)
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
            // Gunakan database transaction dengan row locking
            DB::transaction(function () use ($request, $pengajuan, $userID, $now) {
                $errors = [];
                $hasApprovedItems = false;

                foreach ($request->items as $item) {
                    $detail = PengajuanDetail::findOrFail($item['pengajuanDetailID']);

                    if ($item['approve'] ?? false) {
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
                            // Tolak item ini karena stok tidak cukup
                            $detail->update(['status' => 'ditolak']);
                            continue;
                        }

                        // Setujui item dengan jumlah yang disetujui
                        $detail->update([
                            'status' => 'disetujui',
                            'jumlah_disetujui' => $jumlahDisetujui
                        ]);

                        // Kurangi stok barang
                        $barang->decrement('stok', $jumlahDisetujui);
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

                // Jika ada error stok, lempar exception untuk rollback
                if (!empty($errors)) {
                    throw new \Exception(implode('; ', $errors));
                }
            });

            return redirect()->route('admin.permintaan.index')
                ->with('success', 'Pengajuan telah diproses.');

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
