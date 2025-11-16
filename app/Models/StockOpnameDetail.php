<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameDetail extends Model
{
    use HasFactory;
    
    // INI BAGIAN PENTINGNYA
    protected $guarded = ['id'];

    public function stockOpname()
    {
        return $this->belongsTo(StockOpname::class);
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}