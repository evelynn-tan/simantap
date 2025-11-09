<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengajuan extends Model
{
    use HasFactory;

    public function user()
    { // Pegawai yg mengajukan
        return $this->belongsTo(User::class, 'user_id');
    }
    public function operator()
    { // Operator yg memvalidasi
        return $this->belongsTo(User::class, 'operator_id');
    }
    public function details()
    { // Barang-barang yg diminta
        return $this->hasMany(PengajuanDetail::class);
    }
}
