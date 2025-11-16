<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    // INI JUGA PENTING
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
        return $this->belongsTo(User::class, 'operator_id');
    }
}