<?php
// app/Models/Pengajuan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $primaryKey = 'pengajuanID';
    public $incrementing = true;
    
    // PERBAIKAN KRUSIAL: Tambahkan casting untuk kolom tanggal
    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime', // Memastikan ini adalah objek Carbon untuk di-format
    ];

    protected $fillable = [
        'pegawaiID',
        'requested_at',
        'description',
        'status',
        'alasan_penolakan',
        'approved_by',
        'approved_at',
    ];

    // Relasi ke Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawaiID', 'pegawaiID');
    }

    // Relasi ke Operator (yang approve)
    public function operator()
    {
        return $this->belongsTo(Operator::class, 'approved_by', 'operatorID');
    }

    // Relasi ke Pengajuan Detail
    public function pengajuanDetails()
    {
        return $this->hasMany(PengajuanDetail::class, 'pengajuanID', 'pengajuanID');
    }

    // Relasi ke Transaksi Keluar
    public function transaksiKeluar()
    {
        return $this->hasOne(TransaksiKeluar::class, 'pengajuanID', 'pengajuanID');
    }

    // Relasi ke User melalui Pegawai
    public function user()
    {
        return $this->hasOneThrough(User::class, Pegawai::class, 'pegawaiID', 'userID', 'pegawaiID', 'userID');
    }

    // Alias untuk pengajuanDetails
    public function details()
    {
        return $this->hasMany(PengajuanDetail::class, 'pengajuanID', 'pengajuanID');
    }
}