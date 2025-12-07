<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\Kategori;

/**
 * BarangSeeder - Seeder untuk data Barang Inventaris
 * 
 * Membuat data barang inventaris BMN lengkap untuk sistem SIMANTAP
 * Data barang disesuaikan dengan kebutuhan BPS (Badan Pusat Statistik)
 */
class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Barang Inventaris...');

        // Mapping kategori untuk lookup
        $kategoriMap = Kategori::pluck('categoryID', 'nama_kategori')->toArray();

        // Data barang lengkap
        $barangsData = [
            // 1. Bahan Bangunan
            ['nama' => 'SEMEN TIGA RODA', 'kategori' => 'Bahan Bangunan', 'satuan' => 'buah', 'stok' => 50, 'deskripsi' => 'Semen untuk keperluan perbaikan gedung'],
            
            // 2. BBM
            ['nama' => 'SOLAR GENSET', 'kategori' => 'Bahan Bakar Minyak (BBM)', 'satuan' => 'liter', 'stok' => 200, 'deskripsi' => 'Bahan bakar untuk genset kantor'],
            
            // 3-6. Alat Tulis Menulis
            ['nama' => 'PENSIL 2B CHUNG HWA', 'kategori' => 'Alat Tulis Menulis', 'satuan' => 'buah', 'stok' => 100, 'deskripsi' => 'Pensil 2B untuk keperluan survei'],
            ['nama' => 'STABILLO', 'kategori' => 'Alat Tulis Menulis', 'satuan' => 'buah', 'stok' => 50, 'deskripsi' => 'Stabilo marker untuk highlighting'],
            ['nama' => 'PENA SIGNO HITAM', 'kategori' => 'Alat Tulis Menulis', 'satuan' => 'buah', 'stok' => 120, 'deskripsi' => 'Pena gel warna hitam'],
            ['nama' => 'PENSIL KENKO', 'kategori' => 'Alat Tulis Menulis', 'satuan' => 'buah', 'stok' => 80, 'deskripsi' => 'Pensil mekanik Kenko'],
            
            // 7. Perlengkapan Stempel
            ['nama' => 'TINTA STEMPEL HORSE', 'kategori' => 'Perlengkapan Stempel', 'satuan' => 'buah', 'stok' => 25, 'deskripsi' => 'Tinta stempel merk Horse'],
            
            // 8. Penjepit Kertas
            ['nama' => 'BINDER CLIPS NO.200', 'kategori' => 'Penjepit Kertas', 'satuan' => 'box', 'stok' => 30, 'deskripsi' => 'Binder clip ukuran besar'],
            
            // 9. Penghapus
            ['nama' => 'KARET PENGHAPUS JOYKO', 'kategori' => 'Penghapus', 'satuan' => 'buah', 'stok' => 100, 'deskripsi' => 'Penghapus pensil Joyko'],
            
            // 10. Alat Koreksi
            ['nama' => 'TIP-EX RE-TYPE', 'kategori' => 'Alat Koreksi', 'satuan' => 'set', 'stok' => 40, 'deskripsi' => 'Correction tape Re-Type'],
            
            // 11-12. Buku/Catatan
            ['nama' => 'BUKU FOLIO (ISI 200 LBR)', 'kategori' => 'Buku/Catatan', 'satuan' => 'buah', 'stok' => 25, 'deskripsi' => 'Buku folio isi 200 lembar'],
            ['nama' => 'BUKU AGENDA SURAT', 'kategori' => 'Buku/Catatan', 'satuan' => 'buah', 'stok' => 10, 'deskripsi' => 'Buku agenda untuk pencatatan surat'],
            
            // 13-14. Map/Ordner
            ['nama' => 'MAP LIPAT BIASA', 'kategori' => 'Map/Ordner', 'satuan' => 'lembar', 'stok' => 200, 'deskripsi' => 'Map lipat untuk dokumen'],
            ['nama' => 'ORDNER TEBAL', 'kategori' => 'Map/Ordner', 'satuan' => 'buah', 'stok' => 30, 'deskripsi' => 'Ordner tebal untuk arsip'],
            
            // 15-16. Alat Potong
            ['nama' => 'PISAU CUTTER', 'kategori' => 'Alat Potong', 'satuan' => 'buah', 'stok' => 20, 'deskripsi' => 'Pisau cutter untuk memotong kertas'],
            ['nama' => 'GUNTING KECIL', 'kategori' => 'Alat Potong', 'satuan' => 'buah', 'stok' => 15, 'deskripsi' => 'Gunting kecil kantor'],
            
            // 17-18. Perekat
            ['nama' => 'LEM STICK POVINAL', 'kategori' => 'Perekat', 'satuan' => 'buah', 'stok' => 50, 'deskripsi' => 'Lem stick Povinal'],
            ['nama' => 'ISOLASI KERTAS', 'kategori' => 'Perekat', 'satuan' => 'buah', 'stok' => 30, 'deskripsi' => 'Isolasi kertas/masking tape'],
            
            // 19-21. Perlengkapan Meja/ATK
            ['nama' => 'ISI STAPLES ETONA 10-1M', 'kategori' => 'Perlengkapan Meja/ATK', 'satuan' => 'box', 'stok' => 50, 'deskripsi' => 'Isi staples Etona No.10'],
            ['nama' => 'STAPLER', 'kategori' => 'Perlengkapan Meja/ATK', 'satuan' => 'buah', 'stok' => 10, 'deskripsi' => 'Stapler kantor'],
            ['nama' => 'PAPAN JALAN', 'kategori' => 'Perlengkapan Meja/ATK', 'satuan' => 'buah', 'stok' => 20, 'deskripsi' => 'Papan jalan untuk menulis'],
            
            // 22. Kertas Cetak
            ['nama' => 'KERTAS A4 70 gr', 'kategori' => 'Kertas Cetak', 'satuan' => 'rim', 'stok' => 100, 'deskripsi' => 'Kertas HVS A4 70 gram'],
            
            // 23. Kertas Khusus
            ['nama' => 'KERTAS FOTO (GLOSSY)', 'kategori' => 'Kertas Khusus', 'satuan' => 'lembar', 'stok' => 200, 'deskripsi' => 'Kertas foto glossy untuk cetak foto'],
            
            // 24. Amplop
            ['nama' => 'AMPLOP SURAT BERLOGO', 'kategori' => 'Amplop', 'satuan' => 'box', 'stok' => 20, 'deskripsi' => 'Amplop surat dengan logo BPS'],
            
            // 25. Tinta Printer
            ['nama' => 'TINTA EPSON 664 BLACK', 'kategori' => 'Tinta Printer', 'satuan' => 'buah', 'stok' => 30, 'deskripsi' => 'Tinta printer Epson 664 hitam'],
            
            // 26. Toner Printer
            ['nama' => 'TONER HP 49A', 'kategori' => 'Toner Printer', 'satuan' => 'buah', 'stok' => 5, 'deskripsi' => 'Toner printer HP LaserJet 49A'],
            
            // 27-28, 30. Media Penyimpanan
            ['nama' => 'CD-R', 'kategori' => 'Media Penyimpanan', 'satuan' => 'pack', 'stok' => 10, 'deskripsi' => 'CD-R kosong untuk backup data'],
            ['nama' => 'FLASH DISK 8G', 'kategori' => 'Media Penyimpanan', 'satuan' => 'buah', 'stok' => 20, 'deskripsi' => 'Flash disk kapasitas 8GB'],
            ['nama' => 'EXTERNAL HARDDISK', 'kategori' => 'Media Penyimpanan', 'satuan' => 'buah', 'stok' => 5, 'deskripsi' => 'External harddisk untuk backup'],
            
            // 29. Periferal Komputer
            ['nama' => 'MOUSE OPTIC', 'kategori' => 'Periferal Komputer', 'satuan' => 'buah', 'stok' => 15, 'deskripsi' => 'Mouse optik USB'],
            
            // 31-34. Perlengkapan Kebersihan
            ['nama' => 'SAPU PLASTIK', 'kategori' => 'Perlengkapan Kebersihan', 'satuan' => 'buah', 'stok' => 10, 'deskripsi' => 'Sapu plastik lantai'],
            ['nama' => 'KAIN PEL', 'kategori' => 'Perlengkapan Kebersihan', 'satuan' => 'buah', 'stok' => 15, 'deskripsi' => 'Kain pel lantai'],
            ['nama' => 'TISSUE KOTAK', 'kategori' => 'Perlengkapan Kebersihan', 'satuan' => 'box', 'stok' => 50, 'deskripsi' => 'Tissue kotak untuk kantor'],
            ['nama' => 'TEMPAT SAMPAH TUTUP', 'kategori' => 'Perlengkapan Kebersihan', 'satuan' => 'buah', 'stok' => 20, 'deskripsi' => 'Tempat sampah dengan tutup'],
            
            // 35-36. Perlengkapan Perbaikan
            ['nama' => 'GEMBOK NO.40', 'kategori' => 'Perlengkapan Perbaikan', 'satuan' => 'buah', 'stok' => 10, 'deskripsi' => 'Gembok ukuran 40mm'],
            ['nama' => 'KRAN AIR', 'kategori' => 'Perlengkapan Perbaikan', 'satuan' => 'pcs', 'stok' => 10, 'deskripsi' => 'Kran air untuk toilet/wastafel'],
            
            // 37. Pewangi/Pengharum Ruangan
            ['nama' => 'GLADE SPRAY', 'kategori' => 'Pewangi/Pengharum Ruangan', 'satuan' => 'buah', 'stok' => 25, 'deskripsi' => 'Pengharum ruangan Glade spray'],
            
            // 38-40. Bahan Pembersih
            ['nama' => 'SOKLIN LANTAI', 'kategori' => 'Bahan Pembersih', 'satuan' => 'buah', 'stok' => 20, 'deskripsi' => 'Pembersih lantai Soklin'],
            ['nama' => 'HARPIC 675ML', 'kategori' => 'Bahan Pembersih', 'satuan' => 'buah', 'stok' => 30, 'deskripsi' => 'Pembersih toilet Harpic 675ml'],
            ['nama' => 'HANDSOAP YURI REFILL', 'kategori' => 'Bahan Pembersih', 'satuan' => 'pack', 'stok' => 20, 'deskripsi' => 'Sabun cuci tangan Yuri refill'],
            
            // 41-42. Perkakas/Pertukangan
            ['nama' => 'CANGKUL', 'kategori' => 'Perkakas/Pertukangan', 'satuan' => 'buah', 'stok' => 5, 'deskripsi' => 'Cangkul untuk berkebun'],
            ['nama' => 'OBENG', 'kategori' => 'Perkakas/Pertukangan', 'satuan' => 'buah', 'stok' => 10, 'deskripsi' => 'Obeng plus dan minus'],
            
            // 43, 45-46. Perlengkapan Listrik
            ['nama' => 'KABEL GULUNG', 'kategori' => 'Perlengkapan Listrik', 'satuan' => 'buah', 'stok' => 5, 'deskripsi' => 'Kabel roll/gulung'],
            ['nama' => 'STOP KONTAK', 'kategori' => 'Perlengkapan Listrik', 'satuan' => 'buah', 'stok' => 20, 'deskripsi' => 'Stop kontak listrik'],
            ['nama' => 'BATERAI AAA', 'kategori' => 'Perlengkapan Listrik', 'satuan' => 'buah', 'stok' => 50, 'deskripsi' => 'Baterai AAA untuk remote'],
            
            // 44. Lampu
            ['nama' => 'PHILIPS 5 WATT', 'kategori' => 'Lampu', 'satuan' => 'buah', 'stok' => 30, 'deskripsi' => 'Lampu LED Philips 5 Watt'],
            
            // 47. Perlengkapan Sensus/Survei
            ['nama' => 'ROMPI PETUGAS DAN KORTIM ST2013', 'kategori' => 'Perlengkapan Sensus/Survei', 'satuan' => 'pcs', 'stok' => 50, 'deskripsi' => 'Rompi petugas sensus ST2013'],
            
            // 48. Publikasi/Sosialisasi
            ['nama' => 'POSTER KAMPANYE ST2013', 'kategori' => 'Publikasi/Sosialisasi', 'satuan' => 'lembar', 'stok' => 100, 'deskripsi' => 'Poster kampanye sensus ST2013'],
            
            // 49, 51, 53. Dokumen Survei/Sensus
            ['nama' => 'DAFTAR ISIAN SE2016-L1 BLOK I-IV', 'kategori' => 'Dokumen Survei/Sensus', 'satuan' => 'buah', 'stok' => 200, 'deskripsi' => 'Daftar isian SE2016 Blok I-IV'],
            ['nama' => 'Kuesioner SAK17.AK', 'kategori' => 'Dokumen Survei/Sensus', 'satuan' => 'buah', 'stok' => 150, 'deskripsi' => 'Kuesioner SAK17 Anak'],
            ['nama' => 'Kuesioner HP-S 2025', 'kategori' => 'Dokumen Survei/Sensus', 'satuan' => 'buah', 'stok' => 300, 'deskripsi' => 'Kuesioner Harga Produsen Subsektor 2025'],
            
            // 50, 55. Publikasi BPS
            ['nama' => 'Tanjungpinang Dalam Angka 2015', 'kategori' => 'Publikasi BPS', 'satuan' => 'buah', 'stok' => 50, 'deskripsi' => 'Publikasi Tanjungpinang Dalam Angka 2015'],
            ['nama' => 'Statistik Kesejahteraan Rakyat Kota Tanjungpinang 2023', 'kategori' => 'Publikasi BPS', 'satuan' => 'buah', 'stok' => 30, 'deskripsi' => 'Publikasi Statistik Kesejahteraan Rakyat 2023'],
            
            // 52. Publikasi/Souvenir
            ['nama' => 'Kalender Dinding 2023', 'kategori' => 'Publikasi/Souvenir', 'satuan' => 'buah', 'stok' => 100, 'deskripsi' => 'Kalender dinding BPS tahun 2023'],
            
            // 54. Perlengkapan Survei
            ['nama' => 'Sepatu Boot', 'kategori' => 'Perlengkapan Survei', 'satuan' => 'buah', 'stok' => 20, 'deskripsi' => 'Sepatu boot untuk survei lapangan'],
        ];

        $count = 0;
        foreach ($barangsData as $data) {
            $kategoriID = $kategoriMap[$data['kategori']] ?? null;

            if (!$kategoriID) {
                $this->command->warn("  ⚠ Kategori '{$data['kategori']}' tidak ditemukan untuk barang '{$data['nama']}'");
                continue;
            }

            Barang::create([
                'namaBarang' => $data['nama'],
                'categoryID' => $kategoriID,
                'satuan' => $data['satuan'],
                'stok' => $data['stok'],
                'deskripsi' => $data['deskripsi'],
                // kode_barang akan auto-generate di Model::booted() hook
            ]);
            $count++;
        }

        $this->command->info('✓ Created ' . $count . ' Barang dengan kode auto-generate');
    }
}
