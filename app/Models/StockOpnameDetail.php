<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameDetail extends Model
{
    use HasFactory;
    
    // PERBAIKAN 1: Definisikan Primary Key non-standar
    // Berdasarkan migrasi, PK-nya adalah 'opnameDetailID'
    protected $primaryKey = 'opnameDetailID';
    
    // PERBAIKAN KRUSIAL 2: Daftarkan semua kolom yang boleh diisi, 
    // pastikan namanya SAMA dengan database (CamelCase)
    protected $fillable = [
        'opnameID', 
        'barangID', 
        'stokSistem', 
        'stokFisik', 
        'stokSelisih', // Nama kolom yang benar
        'keterangan', // Dari migrasi
    ]; 

    public function stockOpname()
    {
        return $this->belongsTo(StockOpname::class, 'opnameID');
    }
    
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barangID');
    }
}