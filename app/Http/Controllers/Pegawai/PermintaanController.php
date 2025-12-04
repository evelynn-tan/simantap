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

        // Status filter (stok > 0 by default, unless habis selected)
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'tersedia') {
                $query->where('stok', '>=', 10);
            } elseif ($status === 'rendah') {
                $query->whereBetween('stok', [1, 9]);
            } elseif ($status === 'habis') {
                $query->where('stok', 0);
            }
        } else {
            // Default: only show items with stock > 0
            $query->where('stok', '>', 0);
        }

        // Sorting
        $sortColumn = $request->get('sort', 'namaBarang');
        $sortDirection = $request->get('direction', 'asc');
        
        // Validate sort column
        $allowedSorts = ['kode_barang', 'namaBarang', 'stok', 'categoryID'];
        if (!in_array($sortColumn, $allowedSorts)) {
            $sortColumn = 'namaBarang';
        }
        
        // Validate direction
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
     * Save new request
     */
    public function ajukan(Request $request)
    {
        $userId = Auth::id();
        $pegawai = Pegawai::where('userID', $userId)->first();

        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        // Validation
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

        // Check stock availability for all items
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
            // Create pengajuan header
            $pengajuan = Pengajuan::create([
                'pegawaiID' => $pegawai->pegawaiID,
                'requested_at' => now(),
                'description' => $request->description,
                'status' => 'menunggu',
            ]);

            // Create detail items (status defaults to 'menunggu')
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
        if ($pengajuan->status !== 'menunggu') {
            return redirect()->back()
                ->with('error', 'Hanya permintaan yang menunggu yang dapat dibatalkan.');
        }

        $pengajuan->update(['status' => 'dibatalkan']);
        $pengajuan->pengajuanDetails()
            ->update(['status' => 'ditolak']);

        return redirect()->route('pegawai.monitor-permintaan')
            ->with('success', 'Permintaan berhasil dibatalkan.');
    }
}
