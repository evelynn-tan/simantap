<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $table = 'operators';
    protected $primaryKey = 'userID';  // PK = userID (bukan operatorID)
    public $incrementing = false;  // userID bukan auto-increment
    protected $keyType = 'int';

    // Tidak ada timestamps karena tabel operators hanya FK
    public $timestamps = false;

    protected $fillable = [
        'userID',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    /**
     * Relasi ke Transaksis (untuk log operator)
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'userID', 'userID');
    }

    /**
     * Relasi ke StockOpnames
     */
    public function stockOpnames()
    {
        return $this->hasMany(StockOpname::class, 'userID', 'userID');
    }

    /**
     * Relasi ke Laporans
     */
    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'userID', 'userID');
    }
}

