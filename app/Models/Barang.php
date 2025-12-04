<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $primaryKey = 'barangID';
    public $incrementing = true;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategoriID',
        'satuan',
        'stok',
        'deskripsi',
    ];

    protected $casts = [
        'stok' => 'integer',
        'satuan' => 'string',
    ];

    /**
     * Route model binding menggunakan barangID
     */
    public function getRouteKeyName()
    {
        return 'barangID';
    }

    /**
     * Relasi ke Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategoriID', 'kategoriID');
    }

    /**
     * Relasi ke PengajuanDetails
     */
    public function pengajuanDetails()
    {
        return $this->hasMany(PengajuanDetail::class, 'barangID', 'barangID');
    }

    /**
     * Relasi ke DetailRangggings (untuk tracking transaksi)
     */
    public function detailRangggings()
    {
        return $this->hasMany(DetailRangging::class, 'barangID', 'barangID');
    }

    /**
     * Relasi ke StockOpnameDetails
     */
    public function stockOpnameDetails()
    {
        return $this->hasMany(StockOpnameDetail::class, 'barangID', 'barangID');
    }

    /**
     * ACCESSOR: Menghitung status barang dari nilai stok
     */
    public function getStatusAttribute()
    {
        if ($this->stok <= 0) {
            return 'habis';
        }
        if ($this->stok < 5) {
            return 'rendah';
        }
        return 'tersedia';
    }

    /**
     * Auto-generate kode barang saat create
     * Format: BRG-001, BRG-002, dst
     */
    protected static function booted()
    {
        static::creating(function ($barang) {
            if (!$barang->kode_barang) {
                $lastBarang = Barang::orderBy('barangID', 'desc')->first();
                $nextNum = ($lastBarang ? intval(substr($lastBarang->kode_barang, 4)) + 1 : 1);
                $barang->kode_barang = 'BRG-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Scope: Barang tersedia (stok > 0)
     */
    public function scopeTersedia($query)
    {
        return $query->where('stok', '>', 0);
    }

    /**
     * Scope: Barang habis (stok <= 0)
     */
    public function scopeHabis($query)
    {
        return $query->where('stok', '<=', 0);
    }

    /**
     * Scope: Barang stok rendah (0 < stok < 5)
     */
    public function scopeRendah($query)
    {
        return $query->where('stok', '>', 0)->where('stok', '<', 5);
    }
}