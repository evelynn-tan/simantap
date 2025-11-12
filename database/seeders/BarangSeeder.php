<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        // Data diambil dari mockup `image_f22be3.png`
        Barang::create(['categoryID' => 1, 'kode_barang' => 'ATK001', 'namaBarang' => 'Kertas HVS A4 80 gram', 'stok' => 45, 'satuan' => 'Rim', 'deskripsi' => '']);
        Barang::create(['categoryID' => 1, 'kode_barang' => 'ATK002', 'namaBarang' => 'Bolpoint Pilot Hitam', 'stok' => 25, 'satuan' => 'Dus', 'deskripsi' => '']);
        Barang::create(['categoryID' => 1, 'kode_barang' => 'ATK003', 'namaBarang' => 'Pensil 2B Faber Castell', 'stok' => 15, 'satuan' => 'Dus', 'deskripsi' => '']);
        Barang::create(['categoryID' => 1, 'kode_barang' => 'ATK004', 'namaBarang' => 'Tipp-Ex Correction Tape', 'stok' => 8, 'satuan' => 'Pcs', 'deskripsi' => '']);
        Barang::create(['categoryID' => 1, 'kode_barang' => 'ATK005', 'namaBarang' => 'Spidol Whiteboard Snowman', 'stok' => 12, 'satuan' => 'Pcs', 'deskripsi' => '']);
        Barang::create(['categoryID' => 1, 'kode_barang' => 'ATK006', 'namaBarang' => 'Stapler HD-50 Max', 'stok' => 6, 'satuan' => 'Pcs', 'deskripsi' => '']);
        Barang::create(['categoryID' => 1, 'kode_barang' => 'ATK007', 'namaBarang' => 'Isi Staples No.10', 'stok' => 20, 'satuan' => 'Box', 'deskripsi' => '']);
    }
}
