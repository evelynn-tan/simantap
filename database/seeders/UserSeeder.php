<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Akun Operator BMN
        User::create([
            'name' => 'Operator BMN',
            'email' => 'operator@bps.go.id',
            'password' => Hash::make('password'),
            'role' => 'operator',
            'jabatan' => 'Pengadministrasi Umum',
            'nip' => '198203101005021001'
        ]);

        // 2. Buat Akun Pegawai BPS
        User::create([
            'name' => 'Pegawai BPS (Contoh)',
            'email' => 'pegawai@bps.go.id',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'jabatan' => 'Statistisi Ahli Pertama',
            'nip' => '198505102009021001'
        ]);
    }
}
