<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    protected $primaryKey = 'opnameID';
    public $incrementing = true;

    protected $fillable = [
        'userID',
        'tanggal_opname',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_opname' => 'date',
    ];

    /**
     * Relasi ke User (Operator yang melakukan opname)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    /**
     * Relasi ke StockOpnameDetails
     */
    public function details()
    {
        return $this->hasMany(StockOpnameDetail::class, 'opnameID', 'opnameID');
    }
}