<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanDetail extends Model
{
    use HasFactory;

    /**
     * Tabel ini tidak memiliki timestamps (created_at, updated_at).
     * Jika Anda menambahkannya di migrasi, hapus baris ini.
     */
    public $timestamps = false;

    /**
     * Dapatkan pengajuan induk dari detail ini.
     */
    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }

    /**
     * Dapatkan barang yang terkait dengan detail ini.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
