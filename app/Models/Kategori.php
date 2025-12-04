<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $primaryKey = 'categoryID';
    public $incrementing = true;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    // Relasi ke Barang
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'categoryID', 'categoryID');
    }
}
