<?php

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
        'jumlah_disetujui',  // Jumlah yang disetujui (bisa lebih kecil dari jumlah diminta)
        'status',  // NEW: menunggu, disetujui, ditolak
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'status' => 'string',
    ];

    /**
     * Relasi ke Pengajuan
     */
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuanID', 'pengajuanID');
    }

    /**
     * Relasi ke Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barangID', 'barangID');
    }

    /**
     * Scope: Filter detail yang menunggu
     */
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    /**
     * Scope: Filter detail yang disetujui
     */
    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    /**
     * Scope: Filter detail yang ditolak
     */
    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }
}
