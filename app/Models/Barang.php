<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Tambahkan definisi Primary Key untuk memastikan penamaan non-standar (BarangID) dikenal
    protected $primaryKey = 'barangID'; 
    public $incrementing = true;
    
    // Gunakan $guarded untuk mengizinkan semua mass assignment kecuali 'id', 
    // menyelaraskan dengan Model lain yang sudah diperbaiki.
    protected $guarded = ['id'];

    // Relasi ke Kategori
    public function kategori()
    {
        // Foreign key di sini adalah kategoriID (non-standar)
        return $this->belongsTo(Kategori::class, 'kategoriID', 'kategoriID');
    }

    // Relasi ke Pengajuan Detail
    public function pengajuanDetails()
    {
        return $this->hasMany(PengajuanDetail::class, 'barangID', 'barangID');
    }

    // Relasi ke Detail Barang Masuk
    public function detailBarangMasuks()
    {
        return $this->hasMany(DetailBarangMasuk::class, 'barangID', 'barangID');
    }

    // Relasi ke Detail Barang Keluar
    public function detailBarangKeluars()
    {
        return $this->hasMany(DetailBarangKeluar::class, 'barangID', 'barangID');
    }

    // Relasi ke Stock Opname Detail
    public function stockOpnameDetails()
    {
        return $this->hasMany(StockOpnameDetail::class, 'barangID', 'barangID');
    }
}