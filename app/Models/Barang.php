<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $primaryKey = 'barangID';
    public $incrementing = true;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategoriID',
        'satuan',
        'stok_awal',
        'stok_sekarang',
        'deskripsi',
        'status',
    ];

    // Relasi ke Kategori
    public function kategori()
    {
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
