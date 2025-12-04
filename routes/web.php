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

// Rute Jetstream untuk /dashboard (SUDAH BENAR, JANGAN DIUBAH)
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
    Route::resource('/pengguna', ManajemenPenggunaController::class);
    
    // Search endpoint HARUS didefinisikan sebelum resource route
    Route::get('/barang/search', [DataBarangController::class, 'search'])->name('barang.search');
    
    // Route model binding untuk Barang - manual define untuk explicit binding
    Route::get('/barang', [DataBarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [DataBarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [DataBarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{barang}', [DataBarangController::class, 'show'])->name('barang.show')->where('barang', '[0-9]+');
    Route::get('/barang/{barang}/edit', [DataBarangController::class, 'edit'])->name('barang.edit')->where('barang', '[0-9]+');
    Route::put('/barang/{barang}', [DataBarangController::class, 'update'])->name('barang.update')->where('barang', '[0-9]+');
    Route::delete('/barang/{barang}', [DataBarangController::class, 'destroy'])->name('barang.destroy')->where('barang', '[0-9]+');
    
    // Permintaan
    Route::get('/permintaan', [ManajemenPermintaanController::class, 'index'])->name('permintaan.index');
    Route::post('/permintaan/setujui/{pengajuan}', [ManajemenPermintaanController::class, 'setujui'])->name('permintaan.setujui')->where('pengajuan', '[0-9]+');
    Route::post('/permintaan/tolak/{pengajuan}', [ManajemenPermintaanController::class, 'tolak'])->name('permintaan.tolak')->where('pengajuan', '[0-9]+');
    
    // Perbaikan kecil: resource jangan pakai path 'views/admin/...', cukup nama URL saja
    Route::resource('stock-opname', StockOpnameController::class); 
    
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/generate', [LaporanController::class, 'generate'])->name('laporan.generate');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');

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
