<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use App\Models\Pegawai;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermintaanController extends Controller
{
    /**
     * Show list of available items
     */
    public function daftarBarang(Request $request)
    {
        $userId = Auth::id();
        $pegawai = Pegawai::where('userID', $userId)->first();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        $query = Barang::with('kategori');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('namaBarang', 'like', "%{$search}%")
                    ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('categoryID', $request->kategori);
        }

        // Default: only show items with stock > 0
        $query->where('stok', '>', 0);

        // Dynamic Sorting
        $sortColumn = $request->get('sort', 'namaBarang');
        $sortDirection = $request->get('direction', 'asc');
        
        // Validate sort column to prevent SQL injection
        $allowedSorts = ['kode_barang', 'namaBarang', 'categoryID', 'stok'];
        if (!in_array($sortColumn, $allowedSorts)) {
            $sortColumn = 'namaBarang';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }
        
        $query->orderBy($sortColumn, $sortDirection);

        $barangs = $query->paginate(10);

        return view('pegawai.daftar-barang', compact('barangs', 'pegawai', 'kategoris'));
    }

    /**
     * Show form to create new request
     */
    public function create()
    {
        $userId = Auth::id();
        $pegawai = Pegawai::where('userID', $userId)->first();

        $barangs = Barang::where('stok', '>', 0)
            ->orderBy('namaBarang')
            ->get();

        return view('pegawai.permintaan.create', compact('barangs', 'pegawai'));
    }

    /**
     * Save new request (single item only - simple)
     */
    public function ajukan(Request $request)
    {
        $userId = Auth::id();
        $pegawai = Pegawai::where('userID', $userId)->first();

        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        // Validation - simple single item
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

        // Check stock availability
        foreach ($request->items as $item) {
            $barang = Barang::findOrFail($item['barangID']);
            if ($barang->stok < $item['jumlah']) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Stok '{$barang->namaBarang}' tidak mencukupi. Tersisa: {$barang->stok}");
            }
        }

        DB::beginTransaction();
        try {
            // Create pengajuan header dengan snapshot nama pegawai
            $pengajuan = Pengajuan::create([
                'pegawaiID' => $pegawai->pegawaiID,
                'nama_pegawai_snapshot' => $pegawai->nama_lengkap,
                'nip_snapshot' => $pegawai->nip,
                'requested_at' => now(),
                'description' => $request->description,
                'status' => 'menunggu',
            ]);

            // Create detail items
            foreach ($request->items as $item) {
                PengajuanDetail::create([
                    'pengajuanID' => $pengajuan->pengajuanID,
                    'barangID' => $item['barangID'],
                    'jumlah' => $item['jumlah'],
                    'status' => 'menunggu',
                ]);
            }

            DB::commit();

            return redirect()->route('pegawai.monitor-permintaan')
                ->with('success', 'Permintaan berhasil diajukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Show request status monitoring
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

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('requested_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('requested_at', '<=', $request->tanggal_selesai);
        }

        $permintaan = $query->orderBy('requested_at', 'desc')->paginate(10);

        return view('pegawai.monitor-permintaan', compact('permintaan', 'pegawai'));
    }

    /**
     * Cancel a pending request
     */
    public function batal(Pengajuan $pengajuan)
    {
        $userId = Auth::id();
        $pegawai = Pegawai::where('userID', $userId)->first();

        // Verify ownership
        if ($pengajuan->pegawaiID !== $pegawai->pegawaiID) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk membatalkan pengajuan ini.');
        }

        if ($pengajuan->status !== 'menunggu') {
            return redirect()->back()
                ->with('error', 'Hanya permintaan dengan status "menunggu" yang dapat dibatalkan.');
        }

        $pengajuan->update(['status' => 'dibatalkan']);
        $pengajuan->pengajuanDetails()
            ->update(['status' => 'ditolak']);

        return redirect()->route('pegawai.monitor-permintaan')
            ->with('success', 'Permintaan berhasil dibatalkan.');
    }
}
