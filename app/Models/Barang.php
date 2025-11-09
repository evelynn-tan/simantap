<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use HasFactory;

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
    public function pengajuanDetails(): HasMany
    {
        return $this->hasMany(PengajuanDetail::class);
    }
    public function stockOpnameDetails(): HasMany
    {
        return $this->hasMany(StockOpnameDetail::class);
    }
}
