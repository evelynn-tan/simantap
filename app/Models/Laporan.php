<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $primaryKey = 'laporanID';
    public $incrementing = true;

    protected $fillable = [
        'userID',
        'jenis',
        'periode_awal',
        'periode_akhir',
        'total_items',
        'isi',
        'status',
        'finalized_at',
    ];

    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
        'finalized_at' => 'datetime',
        'isi' => 'json',
        'total_items' => 'integer',
    ];

    /**
     * Relasi ke User (Operator pembuat laporan)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    /**
     * Scope: Filter laporan draft
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope: Filter laporan final
     */
    public function scopeFinal($query)
    {
        return $query->where('status', 'final');
    }

    /**
     * Scope: Filter laporan approved
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: Filter by jenis laporan
     */
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }
}
