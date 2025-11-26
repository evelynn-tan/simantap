<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    
    // PENTING: Karena database menggunakan ID operator non-standar (operatorID)
    // dan kolom lain diisi melalui create(), kita gunakan $guarded untuk mengizinkan mass assignment.
    protected $guarded = ['id'];
    
    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    // Relasi ke Barang
    public function barang()
    {
        // Asumsi foreign key barang juga non-standar: 'barangID'
        return $this->belongsTo(Barang::class, 'barangID', 'barangID');
    }
    
    // Relasi ke Operator
    public function operator()
    {
        // MENGUBAH foreign key menjadi 'operatorID' agar sesuai dengan database non-standar
        return $this->belongsTo(User::class, 'operatorID');
    }

    // Transaksi ini bisa direferensikan oleh Stock Opname (referensi_jenis='StockOpname')
    // atau yang lainnya (misalnya, Pengajuan)
    public function referensi()
    {
        return $this->morphTo('referensi', 'referensi_jenis', 'referensi_id');
    }
}