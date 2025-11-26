<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    // PENTING: Karena error SQL menunjuk ke 'operatorID', kita asumsikan 
    // nama kolom di DB non-standar (CamelCase) dan harus didefinisikan 
    // di model untuk relasi dan potensi Primary Key.
    
    // Jika Primary Key Anda bukan 'id' (misalnya 'stockOpnameID'), tambahkan:
    // protected $primaryKey = 'stockOpnameID';

    // Menggunakan $guarded untuk mengizinkan mass assignment, kecuali 'id'.
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_opname' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(StockOpnameDetail::class);
    }

    public function operator()
    {
        // MENGUBAH foreign key dari 'operator_id' menjadi 'operatorID' 
        // agar sesuai dengan nama kolom di database Anda (berdasarkan error).
        return $this->belongsTo(User::class, 'operatorID'); 
    }
}