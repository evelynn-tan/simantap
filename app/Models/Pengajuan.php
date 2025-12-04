<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $primaryKey = 'pengajuanID';
    public $incrementing = true;

    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
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

    /**
     * Relasi ke Pegawai
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawaiID', 'pegawaiID');
    }

    /**
     * Relasi ke User (yang approve - operator)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'userID');
    }

    /**
     * Relasi ke PengajuanDetails
     */
    public function pengajuanDetails()
    {
        return $this->hasMany(PengajuanDetail::class, 'pengajuanID', 'pengajuanID');
    }

    /**
     * Alias untuk pengajuanDetails
     */
    public function details()
    {
        return $this->hasMany(PengajuanDetail::class, 'pengajuanID', 'pengajuanID');
    }

    /**
     * Relasi ke User melalui Pegawai
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, Pegawai::class, 'pegawaiID', 'userID', 'pegawaiID', 'userID');
    }

    /**
     * Scope: Filter pengajuan yang menunggu
     */
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    /**
     * Scope: Filter pengajuan yang disetujui
     */
    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    /**
     * Scope: Filter pengajuan yang ditolak
     */
    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }
}