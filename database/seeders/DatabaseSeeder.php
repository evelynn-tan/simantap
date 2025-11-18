<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Operator;
use App\Models\Kategori;
use App\Models\Barang;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data dengan urutan yang benar (dari child ke parent)
        Barang::truncate();
        Kategori::truncate();
        Pegawai::truncate();
        Operator::truncate();
        User::truncate();

        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Seed Users & Operator
        $userOperator = User::create([
            'email' => 'operator@bps.go.id',
            'password' => Hash::make('password'),
            'role' => 'operator'
        ]);

        $operator = Operator::create([
            'userID' => $userOperator->userID,
            'nama_lengkap' => 'Afriani Mahardika, SST',
            'nip' => '198203101006021001',
            'jabatan' => 'Pengadministrasi Umum'
        ]);

        // Seed Users & Pegawai
        $pegawaiData = [
            ['email' => 'nabhan@bps.go.id', 'nama' => 'Nabhan Athallah', 'nip' => '19850510200921001', 'jabatan' => 'Statistisi Ahli Pertama', 'divisi' => 'Fungsional'],
            ['email' => 'faruq@bps.go.id', 'nama' => 'M. Faruq Hafidzullah', 'nip' => '199002152012022001', 'jabatan' => 'Statistisi Ahli Muda', 'divisi' => 'Fungsional'],
            ['email' => 'danang@bps.go.id', 'nama' => 'Danang Ivan Pangestu', 'nip' => '198608202010011002', 'jabatan' => 'Pranata Komputer', 'divisi' => 'Fungsional'],
            ['email' => 'difya@bps.go.id', 'nama' => 'Difya Ayu Meisya', 'nip' => '199105152013022001', 'jabatan' => 'Statistisi Penyelia', 'divisi' => 'Fungsional'],
            ['email' => 'aulia@bps.go.id', 'nama' => 'Aulia Ul Hasanah', 'nip' => '199203182014022002', 'jabatan' => 'Analis Data', 'divisi' => 'Fungsional'],
            ['email' => 'evelyn@bps.go.id', 'nama' => 'Evelyn Tan Eldisha', 'nip' => '199401202015022001', 'jabatan' => 'Pranata Humas', 'divisi' => 'Fungsional'],
        ];

        foreach ($pegawaiData as $data) {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'pegawai'
            ]);

            Pegawai::create([
                'userID' => $user->userID,
                'nama_lengkap' => $data['nama'],
                'nip' => $data['nip'],
                'jabatan' => $data['jabatan'],
                'divisi' => $data['divisi']
            ]);
        }

        // Seed Kategori
        $kategoris = [
            ['nama' => 'ATK', 'deskripsi' => 'Alat Tulis Kantor'],
            ['nama' => 'Elektronik', 'deskripsi' => 'Perangkat Elektronik'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama_kategori' => $kategori['nama'],
                'deskripsi' => $kategori['deskripsi']
            ]);
        }

        // Seed Barang
        $barangs = [
            ['kode' => 'ATK001', 'nama' => 'Kertas HVS A4 80 gram', 'kategori' => 'ATK', 'satuan' => 'rim', 'stok' => 45],
            ['kode' => 'ATK002', 'nama' => 'Bolpoint Pilot Hitam', 'kategori' => 'ATK', 'satuan' => 'pcs', 'stok' => 25],
            ['kode' => 'ATK003', 'nama' => 'Pensil 2B Faber Castell', 'kategori' => 'ATK', 'satuan' => 'pcs', 'stok' => 15],
            ['kode' => 'ATK004', 'nama' => 'Spidol Whiteboard Snowman', 'kategori' => 'ATK', 'satuan' => 'pcs', 'stok' => 12],
            ['kode' => 'ATK005', 'nama' => 'Stapler HD-50 Max', 'kategori' => 'ATK', 'satuan' => 'pcs', 'stok' => 6],
        ];

        foreach ($barangs as $barang) {
            $kategori = Kategori::where('nama_kategori', $barang['kategori'])->first();

            Barang::create([
                'kode_barang' => $barang['kode'],
                'nama_barang' => $barang['nama'],
                'kategoriID' => $kategori->kategoriID,
                'satuan' => $barang['satuan'],
                'stok_awal' => $barang['stok'],
                'stok_sekarang' => $barang['stok'],
                'deskripsi' => 'Barang ' . $barang['nama'],
                'status' => 'tersedia'
            ]);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Operator Login: operator@bps.go.id / password');
        $this->command->info('Pegawai Login: nabhan@bps.go.id / password');
    }
}
