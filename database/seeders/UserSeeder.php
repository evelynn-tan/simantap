<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Operator BMN (sesuai mockup & laporan)
        User::create([
            'name' => 'Operator BMN',
            'email' => 'operator@bps.go.id',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'operator',
            'nip' => '198203101005021001',
            'jabatan' => 'Pengadministrasi Umum',
        ]);

        // 2. Buat Pegawai BPS (sesuai mockup & laporan)
        User::create([
            'name' => 'Nabhan Athallah',
            'email' => 'pegawai@bps.go.id',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'pegawai',
            'nip' => '198505102009021001',
            'jabatan' => 'Statistisi Ahli Pertama',
        ]);

        // Buat beberapa pegawai lain (sesuai mockup)
        User::create(['name' => 'Muhammad Faruq', 'email' => 'faruq@bps.go.id', 'password' => Hash::make('password'), 'role' => 'pegawai', 'nip' => '199002152012022001', 'jabatan' => 'Statistisi Ahli Muda']);
        User::create(['name' => 'Danang Ivan', 'email' => 'ivan@bps.go.id', 'password' => Hash::make('password'), 'role' => 'pegawai', 'nip' => '198808202010011002', 'jabatan' => 'Pranata Komputer']);
    }
}
