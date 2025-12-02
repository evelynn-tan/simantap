<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;
    
    // PERBAIKAN: Definisikan Primary Key yang non-standar (opnameID)
    protected $primaryKey = 'opnameID'; //

    // PERBAIKAN: Ganti $guarded agar primary key yang non-standar tidak perlu di mass-assign
    // Jika Anda ingin menggunakan $guarded
    protected $guarded = ['opnameID']; 
    
    // Atau lebih aman menggunakan $fillable:
    // protected $fillable = ['operatorID', 'tanggal_opname', 'keterangan']; 

    protected $casts = [
        'tanggal_opname' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(StockOpnameDetail::class, 'opnameID'); // Tambahkan FK eksplisit ke StockOpnameDetail
    }

    public function operator()
    {
        // MENGUBAH foreign key dari 'operator_id' menjadi 'operatorID' 
        // agar sesuai dengan nama kolom di database Anda.
        return $this->belongsTo(User::class, 'operatorID'); 
    }
}