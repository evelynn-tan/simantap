<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $primaryKey = 'pegawaiID';
    public $incrementing = true;

    protected $fillable = [
        'userID',
        'nama_lengkap',
        'nip',
        'jabatan',
        'divisi',
        'foto',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    // Relasi ke Pengajuan
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'pegawaiID', 'pegawaiID');
    }
}
