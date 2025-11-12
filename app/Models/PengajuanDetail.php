<?php
// app/Models/PengajuanDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'pengajuanDetailID';
    public $incrementing = true;

    protected $fillable = [
        'pengajuanID',
        'barangID',
        'jumlah',
    ];

    // Relasi ke Pengajuan
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuanID', 'pengajuanID');
    }

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barangID', 'barangID');
    }
}
