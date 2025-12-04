<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';  // Nama tabel plural
    protected $primaryKey = 'transaksiID';
    public $incrementing = true;

    protected $fillable = [
        'userID',
        'tanggal',
        'jenis',      // masuk, keluar, penyesuaian
        'sumber',     // Untuk transaksi masuk
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jenis' => 'string',
    ];

    /**
     * Relasi ke User (Operator yang melakukan transaksi)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    /**
     * Relasi ke DetailRangging (Detail items transaksi)
     */
    public function detailRangggings()
    {
        return $this->hasMany(DetailRangging::class, 'transaksiID', 'transaksiID');
    }

    /**
     * Relasi ke Details (alias)
     */
    public function details()
    {
        return $this->hasMany(DetailRangging::class, 'transaksiID', 'transaksiID');
    }

    /**
     * Scope: Filter transaksi masuk
     */
    public function scopeMasuk($query)
    {
        return $query->where('jenis', 'masuk');
    }

    /**
     * Scope: Filter transaksi keluar
     */
    public function scopeKeluar($query)
    {
        return $query->where('jenis', 'keluar');
    }

    /**
     * Scope: Filter transaksi penyesuaian (stock opname)
     */
    public function scopePenyesuaian($query)
    {
        return $query->where('jenis', 'penyesuaian');
    }
}