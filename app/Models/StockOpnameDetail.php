<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameDetail extends Model
{
    use HasFactory;
    
    // Menggunakan $guarded untuk mengizinkan mass assignment, kecuali 'id'.
    protected $guarded = ['id'];

    public function stockOpname()
    {
        // PENTING: Jika foreign key di DB menggunakan CamelCase (misal: 'stockOpnameID'), 
        // kita perlu mendefinisikannya secara eksplisit.
        return $this->belongsTo(StockOpname::class, 'stockOpnameID');
    }
    
    public function barang()
    {
        // PENTING: Jika foreign key di DB menggunakan CamelCase (misal: 'barangID'), 
        // kita perlu mendefinisikannya secara eksplisit.
        return $this->belongsTo(Barang::class, 'barangID');
    }
}