<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    public function operator(): BelongsTo
    {
        // Kita spesifikkan 'operator_id' sebagai foreign key
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
