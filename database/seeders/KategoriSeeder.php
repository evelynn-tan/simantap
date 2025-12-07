<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

/**
 * KategoriSeeder - Seeder untuk data Kategori Barang
 * 
 * Membuat kategori-kategori barang inventaris BMN SIMANTAP
 */
class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Kategori Barang...');

        $kategoris = [
            // Kategori ATK & Alat Tulis
            ['nama_kategori' => 'Alat Tulis Menulis', 'deskripsi' => 'Pensil, pena, stabilo, dan alat tulis lainnya'],
            ['nama_kategori' => 'Penjepit Kertas', 'deskripsi' => 'Binder clip, paper clip, dan penjepit dokumen'],
            ['nama_kategori' => 'Penghapus', 'deskripsi' => 'Penghapus pensil dan karet'],
            ['nama_kategori' => 'Alat Koreksi', 'deskripsi' => 'Tip-ex, correction tape, dan alat koreksi'],
            ['nama_kategori' => 'Perlengkapan Stempel', 'deskripsi' => 'Tinta stempel, bak stempel, dan stempel'],
            
            // Kategori Buku & Map
            ['nama_kategori' => 'Buku/Catatan', 'deskripsi' => 'Buku folio, buku agenda, dan catatan'],
            ['nama_kategori' => 'Map/Ordner', 'deskripsi' => 'Map lipat, ordner, dan penyimpan dokumen'],
            
            // Kategori Perlengkapan Kantor
            ['nama_kategori' => 'Alat Potong', 'deskripsi' => 'Gunting, cutter, dan alat pemotong'],
            ['nama_kategori' => 'Perekat', 'deskripsi' => 'Lem, isolasi, dan perekat'],
            ['nama_kategori' => 'Perlengkapan Meja/ATK', 'deskripsi' => 'Stapler, papan jalan, dan perlengkapan meja'],
            
            // Kategori Kertas & Amplop
            ['nama_kategori' => 'Kertas Cetak', 'deskripsi' => 'Kertas HVS, kertas folio, dan kertas cetak'],
            ['nama_kategori' => 'Kertas Khusus', 'deskripsi' => 'Kertas foto, kertas karbon, dan kertas khusus'],
            ['nama_kategori' => 'Amplop', 'deskripsi' => 'Amplop surat dan amplop dokumen'],
            
            // Kategori Komputer & Elektronik
            ['nama_kategori' => 'Tinta Printer', 'deskripsi' => 'Tinta printer berbagai merk'],
            ['nama_kategori' => 'Toner Printer', 'deskripsi' => 'Toner untuk printer laser'],
            ['nama_kategori' => 'Media Penyimpanan', 'deskripsi' => 'CD, DVD, flashdisk, dan harddisk'],
            ['nama_kategori' => 'Periferal Komputer', 'deskripsi' => 'Mouse, keyboard, dan periferal'],
            
            // Kategori Kebersihan & Rumah Tangga
            ['nama_kategori' => 'Perlengkapan Kebersihan', 'deskripsi' => 'Sapu, kain pel, tissue, dan tempat sampah'],
            ['nama_kategori' => 'Bahan Pembersih', 'deskripsi' => 'Sabun, pembersih lantai, dan deterjen'],
            ['nama_kategori' => 'Pewangi/Pengharum Ruangan', 'deskripsi' => 'Pengharum ruangan dan spray'],
            
            // Kategori Perbaikan & Listrik
            ['nama_kategori' => 'Perlengkapan Perbaikan', 'deskripsi' => 'Gembok, kran, dan perlengkapan perbaikan'],
            ['nama_kategori' => 'Perkakas/Pertukangan', 'deskripsi' => 'Cangkul, obeng, dan perkakas'],
            ['nama_kategori' => 'Perlengkapan Listrik', 'deskripsi' => 'Kabel, stop kontak, dan perlengkapan listrik'],
            ['nama_kategori' => 'Lampu', 'deskripsi' => 'Lampu LED dan lampu kantor'],
            
            // Kategori Bahan Bangunan & BBM
            ['nama_kategori' => 'Bahan Bangunan', 'deskripsi' => 'Semen, pasir, dan bahan bangunan'],
            ['nama_kategori' => 'Bahan Bakar Minyak (BBM)', 'deskripsi' => 'Solar, bensin, dan bahan bakar'],
            
            // Kategori Khusus BPS
            ['nama_kategori' => 'Perlengkapan Sensus/Survei', 'deskripsi' => 'Rompi petugas, tas survei, dan perlengkapan'],
            ['nama_kategori' => 'Perlengkapan Survei', 'deskripsi' => 'Sepatu boot, topi, dan perlengkapan lapangan'],
            ['nama_kategori' => 'Dokumen Survei/Sensus', 'deskripsi' => 'Kuesioner, daftar isian, dan dokumen survei'],
            ['nama_kategori' => 'Publikasi BPS', 'deskripsi' => 'Buku publikasi dan statistik BPS'],
            ['nama_kategori' => 'Publikasi/Sosialisasi', 'deskripsi' => 'Poster kampanye dan bahan sosialisasi'],
            ['nama_kategori' => 'Publikasi/Souvenir', 'deskripsi' => 'Kalender, souvenir, dan merchandise'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        $this->command->info('✓ Created ' . count($kategoris) . ' Kategori');
    }
}
