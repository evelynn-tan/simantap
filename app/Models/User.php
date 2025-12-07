<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Primary Key non-standar
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

    /**
     * Accessor untuk properti 'name'.
     * Digunakan untuk mengambil nama lengkap dari tabel terkait (Pegawai/Operator)
     * karena tabel users tidak memiliki kolom 'name'.
     */
    public function getNameAttribute()
    {
        // Jika peran adalah pegawai, ambil dari tabel pegawais
        if ($this->role === 'pegawai' && $this->pegawai) {
            return $this->pegawai->nama_lengkap ?? $this->email; 
        }

        // Jika peran adalah operator, gunakan email sebagai identifier
        // (tabel operators tidak punya kolom nama_lengkap)
        if ($this->role === 'operator') {
            // Format email menjadi lebih readable: operator1@bps.go.id -> Operator 1
            $emailPrefix = explode('@', $this->email)[0];
            return ucwords(str_replace(['_', '.'], ' ', $emailPrefix));
        }

        // Fallback ke email jika role tidak dikenal
        return $this->email;
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

    public function getRoleDisplayAttribute()
    {
        if ($this->role == 'operator') {
            return 'Operator BMN';
        }
    
        // Huruf besar di awal kata (misal: 'pegawai' jadi 'Pegawai')
        return ucfirst($this->role);
    }
}