<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'userID';
    public $incrementing = true;

    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Pegawai
    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'userID', 'userID');
    }

    // Relasi ke Operator
    public function operator()
    {
        return $this->hasOne(Operator::class, 'userID', 'userID');
    }
}
