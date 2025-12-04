<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRangging extends Model
{
    use HasFactory;

    protected $table = 'detail_rangggings';
    protected $primaryKey = 'detailRanggingID';
    public $incrementing = true;

    protected $fillable = [
        'transaksiID',
        'barangID',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'stok_sebelum' => 'integer',
        'stok_sesudah' => 'integer',
    ];

    /**
     * Relasi ke Transaksi
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksiID', 'transaksiID');
    }

    /**
     * Relasi ke Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barangID', 'barangID');
    }
}
