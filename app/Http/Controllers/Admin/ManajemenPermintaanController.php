<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
     * - Kurangi stok barang
     */
    public function setujui(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.pengajuanDetailID' => 'required|exists:pengajuan_details,pengajuanDetailID',
            'items.*.approve' => 'boolean',
        ]);

        $userID = auth()->id();
        $now = now();

        foreach ($request->items as $item) {
            $detail = PengajuanDetail::findOrFail($item['pengajuanDetailID']);

            if ($item['approve'] ?? false) {
                // Setujui item ini
                $detail->update(['status' => 'disetujui']);

                // Kurangi stok barang
                $barang = $detail->barang;
                $barang->decrement('stok', $detail->jumlah);
            }
        }

        // Update pengajuan status & approved_by
        $pengajuan->update([
            'status' => 'disetujui',
            'approved_by' => $userID,
            'approved_at' => $now,
        ]);

        return redirect()->route('admin.permintaan.index')
            ->with('success', 'Pengajuan telah disetujui.');
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
