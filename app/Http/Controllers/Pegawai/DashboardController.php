<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Data untuk KPI Cards
        // "Barang Sedang Digunakan" dihitung dari permintaan yg disetujui
        $barangDigunakan = Pengajuan::where('user_id', $userId)
            ->where('status', 'disetujui')
            ->count();

        $totalPermintaan = Pengajuan::where('user_id', $userId)->count();

        // Data untuk tabel "Barang yang Sedang Saya Gunakan"
        $barangDigunakanList = Pengajuan::with('details.barang')
            ->where('user_id', $userId)
            ->where('status', 'disetujui')
            ->orderBy('processed_at', 'desc')
            ->take(5) // Ambil 5 terakhir yg disetujui
            ->get();

        // Data untuk tabel "Riwayat 5 Permintaan Terakhir"
        $riwayatPermintaan = Pengajuan::with('details.barang')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pegawai.dashboard', compact(
            'barangDigunakan',
            'totalPermintaan',
            'barangDigunakanList',
            'riwayatPermintaan'
        ));
    }
}
