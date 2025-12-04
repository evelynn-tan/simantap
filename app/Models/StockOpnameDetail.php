<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'opnameDetailID';
    public $incrementing = true;

    protected $fillable = [
        'opnameID',
        'barangID',
        'stok_sistem',
        'stok_fisik',
        'stok_selisih',
        'keterangan',
    ];

    protected $casts = [
        'stok_sistem' => 'integer',
        'stok_fisik' => 'integer',
        'stok_selisih' => 'integer',
    ];

    /**
     * Relasi ke StockOpname
     */
    public function stockOpname()
    {
        return $this->belongsTo(StockOpname::class, 'opnameID', 'opnameID');
    }

    /**
     * Relasi ke Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barangID', 'barangID');
    }
}
