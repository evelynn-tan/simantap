<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ManajemenPenggunaController;
use App\Http\Controllers\Admin\DataBarangController;
use App\Http\Controllers\Admin\ManajemenPermintaanController;
use App\Http\Controllers\Admin\StockOpnameController;
use App\Http\Controllers\Admin\LaporanController;

use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboardController;
use App\Http\Controllers\Pegawai\PermintaanController as PegawaiPermintaanController;
use App\Http\Controllers\Pegawai\ProfilController;

Route::get('/', function () {
    return redirect('/login');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    if (Auth::user()->role == 'operator') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role == 'pegawai') {
        return redirect()->route('pegawai.dashboard');
    }
})->name('dashboard');

// Grup Admin
Route::middleware(['auth:sanctum', 'verified', 'role:operator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('/pengguna', ManajemenPenggunaController::class)->names([
        'index' => 'manajemen-pengguna',
    ]);

    Route::resource('/barang', DataBarangController::class)->names([
        'index' => 'data-barang',
        'create' => 'tambah-barang',
    ]);
    
    Route::get('/permintaan', [ManajemenPermintaanController::class, 'index'])->name('manajemen-permintaan');
    
    Route::post('/permintaan/setujui/{id}', [ManajemenPermintaanController::class, 'setujui'])->name('permintaan.setujui');
    Route::post('/permintaan/tolak/{id}', [ManajemenPermintaanController::class, 'tolak'])->name('permintaan.tolak');
    
    // 1. Route ini untuk menangani panggilan 'admin.stock-opname' (Sidebar)
    Route::get('/stock-opname-list', [StockOpnameController::class, 'index'])->name('stock-opname');
    
    // 2. Resource ini untuk menangani panggilan 'admin.stock-opname.index' (Tombol Batal) dan fungsi CRUD lainnya
    Route::resource('stock-opname', StockOpnameController::class); 
    
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan'); 
    Route::post('/laporan/generate', [LaporanController::class, 'generate'])->name('laporan.generate');

});

// Grup PEGAWAI
Route::middleware(['auth:sanctum', 'verified', 'role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');

    // Rute untuk Daftar Barang
    Route::get('/daftar-barang', [PegawaiPermintaanController::class, 'daftarBarang'])->name('daftar-barang');

    // Rute untuk Monitor Permintaan
    Route::get('/monitor-permintaan', [PegawaiPermintaanController::class, 'monitor'])->name('monitor-permintaan');

    // Rute untuk Edit Profil
    Route::get('/edit-profil', [ProfilController::class, 'edit'])->name('edit-profil');
    Route::put('/edit-profil/update', [ProfilController::class, 'update'])->name('edit-profil.update');

    // Rute tambahan untuk fitur permintaan
    Route::get('/ajukan-permintaan', [PegawaiPermintaanController::class, 'create'])->name('permintaan.create');
    Route::post('/ajukan-permintaan', [PegawaiPermintaanController::class, 'ajukan'])->name('permintaan.ajukan');
});