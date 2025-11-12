<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $primaryKey = 'operatorID';
    public $incrementing = true;

    protected $fillable = [
        'userID',
        'nama_lengkap',
        'nip',
        'jabatan',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    // Relasi ke Transaksi Masuk
    public function transaksiMasuks()
    {
        return $this->hasMany(TransaksiMasuk::class, 'operatorID', 'operatorID');
    }

    // Relasi ke Transaksi Keluar
    public function transaksiKeluars()
    {
        return $this->hasMany(TransaksiKeluar::class, 'operatorID', 'operatorID');
    }

    // Relasi ke Stock Opname
    public function stockOpnames()
    {
        return $this->hasMany(StockOpname::class, 'operatorID', 'operatorID');
    }

    // Relasi ke Laporan
    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'operatorID', 'operatorID');
    }
}
