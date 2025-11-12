<?php
// app/Http/Controllers/Pegawai/DashboardController.php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Pegawai;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Dapatkan data pegawai berdasarkan userID
        $pegawai = Pegawai::where('userID', $userId)->first();

        if (!$pegawai) {
            abort(404, 'Data pegawai tidak ditemukan');
        }

        $pegawaiID = $pegawai->pegawaiID;

        // Data untuk KPI Cards
        $barangDigunakan = Pengajuan::where('pegawaiID', $pegawaiID)
            ->where('status', 'disetujui')
            ->count();

        $totalPermintaan = Pengajuan::where('pegawaiID', $pegawaiID)->count();

        $menungguPersetujuan = Pengajuan::where('pegawaiID', $pegawaiID)
            ->where('status', 'menunggu')
            ->count();

        // Barang yang sedang digunakan (detail)
        $barangSedangDigunakan = Pengajuan::with(['pengajuanDetails.barang'])
            ->where('pegawaiID', $pegawaiID)
            ->where('status', 'disetujui')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pegawai.dashboard', compact(
            'barangDigunakan',
            'totalPermintaan',
            'menungguPersetujuan',
            'barangSedangDigunakan',
            'pegawai'
        ));
    }
}
