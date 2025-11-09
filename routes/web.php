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

// Grup Admin (SUDAH BENAR, JANGAN DIUBAH)
Route::middleware(['auth:sanctum', 'verified', 'role:operator'])->prefix('admin')->name('admin.')->group(function () {
    // ... (Semua rute admin Anda) ...
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/pengguna', ManajemenPenggunaController::class);
    Route::resource('/barang', DataBarangController::class);
    Route::get('/permintaan', [ManajemenPermintaanController::class, 'index'])->name('permintaan.index');
    Route::post('/permintaan/setujui/{id}', [ManajemenPermintaanController::class, 'setujui'])->name('permintaan.setujui');
    Route::post('/permintaan/tolak/{id}', [ManajemenPermintaanController::class, 'tolak'])->name('permintaan.tolak');
    Route::resource('/stock-opname', StockOpnameController::class);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/generate', [LaporanController::class, 'generate'])->name('laporan.generate');
});

// Grup PEGAWAI (MODIFIKASI DI SINI)
Route::middleware(['auth:sanctum', 'verified', 'role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');
    
    // Rute untuk Permintaan
    Route::get('/barang-tersedia', [PegawaiPermintaanController::class, 'daftarBarang'])->name('barang.index');
    
    // TAMBAHKAN RUTE INI UNTUK MENAMPILKAN FORM
    Route::get('/ajukan-permintaan', [PegawaiPermintaanController::class, 'create'])->name('permintaan.create');
    
    Route::post('/ajukan-permintaan', [PegawaiPermintaanController::class, 'ajukan'])->name('permintaan.ajukan');
    Route::get('/permintaan-saya', [PegawaiPermintaanController::class, 'monitor'])->name('permintaan.monitor');
    
    // Rute untuk Profil
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
});

