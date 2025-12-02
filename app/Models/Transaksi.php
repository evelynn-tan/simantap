<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    
    // PERBAIKAN: Daftarkan semua kolom yang boleh diisi
    protected $fillable = [
        'barangID',
        'operatorID',
        'jenis',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
        'referensi_id',
        'referensi_jenis',
    ];
    
    // Tambahkan relasi (sangat disarankan)
    public function barang() { 
        return $this->belongsTo(Barang::class, 'barangID'); 
    }
    public function operator() { 
        // Menggunakan operatorID karena user yang login adalah operator
        return $this->belongsTo(User::class, 'operatorID'); 
    }
}