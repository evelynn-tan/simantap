<?php

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
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data (from child to parent)
        Barang::truncate();
        Kategori::truncate();
        Pegawai::truncate();
        Operator::truncate();
        User::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // =========== SEED USERS & OPERATORS ===========
        // Operator 1
        $userOperator1 = User::create([
            'email' => 'operator1@bps.go.id',
            'password' => Hash::make('password'),
            'role' => 'operator'
        ]);

        Operator::create([
            'userID' => $userOperator1->userID,
        ]);

        // Operator 2
        $userOperator2 = User::create([
            'email' => 'operator2@bps.go.id',
            'password' => Hash::make('password'),
            'role' => 'operator'
        ]);

        Operator::create([
            'userID' => $userOperator2->userID,
        ]);

        // =========== SEED PEGAWAI ===========
        $pegawaiData = [
            ['email' => 'nabhan@bps.go.id', 'nama' => 'Nabhan Athallah', 'nip' => '19850510200921001', 'jabatan' => 'Statistisi Ahli Pertama', 'divisi' => 'Fungsional'],
            ['email' => 'faruq@bps.go.id', 'nama' => 'M. Faruq Hafidzullah', 'nip' => '199002152012022001', 'jabatan' => 'Statistisi Ahli Muda', 'divisi' => 'Fungsional'],
            ['email' => 'danang@bps.go.id', 'nama' => 'Danang Ivan Pangestu', 'nip' => '198608202010011002', 'jabatan' => 'Pranata Komputer', 'divisi' => 'Fungsional'],
            ['email' => 'difya@bps.go.id', 'nama' => 'Difya Ayu Meisya', 'nip' => '199105152013022001', 'jabatan' => 'Statistisi Penyelia', 'divisi' => 'Fungsional'],
            ['email' => 'aulia@bps.go.id', 'nama' => 'Aulia Ul Hasanah', 'nip' => '199203182014022002', 'jabatan' => 'Analis Data', 'divisi' => 'Fungsional'],
            ['email' => 'evelyn@bps.go.id', 'nama' => 'Evelyn Tan Eldisha', 'nip' => '199401202015022001', 'jabatan' => 'Pranata Humas', 'divisi' => 'Fungsional'],
            ['email' => 'indri@bps.go.id', 'nama' => 'Indri Putri Lestari', 'nip' => '199502202016022003', 'jabatan' => 'Staf Keuangan', 'divisi' => 'Administrasi'],
            ['email' => 'bambang@bps.go.id', 'nama' => 'Bambang Setiawan', 'nip' => '198712102008011004', 'jabatan' => 'Koordinator Umum', 'divisi' => 'Administrasi'],
            ['email' => 'siti@bps.go.id', 'nama' => 'Siti Marhaeni', 'nip' => '199003112017022005', 'jabatan' => 'Asisten Statistisi', 'divisi' => 'Fungsional'],
            ['email' => 'rudi@bps.go.id', 'nama' => 'Rudi Hartono', 'nip' => '198506302009021006', 'jabatan' => 'Teknisi', 'divisi' => 'Teknis'],
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
                'divisi' => $data['divisi'],
            ]);
        }

        // =========== SEED CATEGORIES ===========
        $kategoris = [
            ['nama' => 'ATK', 'deskripsi' => 'Alat Tulis Kantor'],
            ['nama' => 'Elektronik', 'deskripsi' => 'Perangkat Elektronik'],
            ['nama' => 'Cetakan', 'deskripsi' => 'Barang Cetakan'],
            ['nama' => 'Lain-lain', 'deskripsi' => 'Barang Lain-lain'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama_kategori' => $kategori['nama'],
                'deskripsi' => $kategori['deskripsi']
            ]);
        }

        // =========== SEED BARANG ===========
        $barangsData = [
            // ATK
            ['nama' => 'Kertas HVS A4 80 gram', 'kategori' => 'ATK', 'satuan' => 'rim', 'stok' => 45, 'deskripsi' => 'Kertas putih untuk fotokopi'],
            ['nama' => 'Bolpoint Pilot Hitam', 'kategori' => 'ATK', 'satuan' => 'pcs', 'stok' => 125, 'deskripsi' => 'Pulpen hitam standard office'],
            ['nama' => 'Pensil 2B Faber Castell', 'kategori' => 'ATK', 'satuan' => 'pcs', 'stok' => 85, 'deskripsi' => 'Pensil untuk menulis/sketsa'],
            ['nama' => 'Spidol Whiteboard Snowman', 'kategori' => 'ATK', 'satuan' => 'pcs', 'stok' => 42, 'deskripsi' => 'Spidol warna untuk whiteboard'],
            ['nama' => 'Stapler HD-50 Max', 'kategori' => 'ATK', 'satuan' => 'pcs', 'stok' => 6, 'deskripsi' => 'Stapler kantor kapasitas besar'],
            ['nama' => 'Kertas Karbon', 'kategori' => 'ATK', 'satuan' => 'set', 'stok' => 15, 'deskripsi' => 'Kertas karbon untuk dokumen'],
            ['nama' => 'Tinta Printer Canon', 'kategori' => 'ATK', 'satuan' => 'pcs', 'stok' => 8, 'deskripsi' => 'Cartridge tinta printer'],
            ['nama' => 'Map Folio Karton', 'kategori' => 'ATK', 'satuan' => 'pcs', 'stok' => 30, 'deskripsi' => 'Map penyimpan dokumen'],

            // Elektronik
            ['nama' => 'Lampu LED 12W', 'kategori' => 'Elektronik', 'satuan' => 'pcs', 'stok' => 12, 'deskripsi' => 'Lampu LED hemat energi'],
            ['nama' => 'Kabel LAN Cat5E', 'kategori' => 'Elektronik', 'satuan' => 'meter', 'stok' => 250, 'deskripsi' => 'Kabel jaringan panjang 1m'],
            ['nama' => 'Keyboard Wireless', 'kategori' => 'Elektronik', 'satuan' => 'pcs', 'stok' => 5, 'deskripsi' => 'Keyboard nirkabel USB'],
            ['nama' => 'Mouse Optic USB', 'kategori' => 'Elektronik', 'satuan' => 'pcs', 'stok' => 18, 'deskripsi' => 'Mouse dengan kabel USB'],

            // Cetakan
            ['nama' => 'Formulir Pengajuan', 'kategori' => 'Cetakan', 'satuan' => 'lembar', 'stok' => 500, 'deskripsi' => 'Form permintaan barang'],
            ['nama' => 'Label Stiker', 'kategori' => 'Cetakan', 'satuan' => 'pack', 'stok' => 20, 'deskripsi' => 'Stiker label untuk inventaris'],
            ['nama' => 'Undangan Acara', 'kategori' => 'Cetakan', 'satuan' => 'lembar', 'stok' => 200, 'deskripsi' => 'Surat undangan resmi'],

            // Lain-lain
            ['nama' => 'Air Mineral Galon', 'kategori' => 'Lain-lain', 'satuan' => 'buah', 'stok' => 10, 'deskripsi' => 'Galon air minum kantor'],
            ['nama' => 'Kopi Instant Sachet', 'kategori' => 'Lain-lain', 'satuan' => 'box', 'stok' => 5, 'deskripsi' => 'Kopi instant box isi 30'],
            ['nama' => 'Gula Pasir', 'kategori' => 'Lain-lain', 'satuan' => 'kg', 'stok' => 25, 'deskripsi' => 'Gula pasir untuk kantor'],
        ];

        foreach ($barangsData as $data) {
            $kategori = Kategori::where('nama_kategori', $data['kategori'])->first();

            Barang::create([
                'namaBarang' => $data['nama'],
                'categoryID' => $kategori->categoryID,
                'satuan' => $data['satuan'],
                'stok' => $data['stok'],
                'deskripsi' => $data['deskripsi'],
                // kode_barang akan auto-generate di booted() hook
            ]);
        }

        $this->command->info('✓ Database seeded successfully!');
        $this->command->info('✓ Created 2 Operators (operator1@bps.go.id, operator2@bps.go.id)');
        $this->command->info('✓ Created 10 Pegawai (nabhan@bps.go.id, etc)');
        $this->command->info('✓ Created 4 Categories (ATK, Elektronik, Cetakan, Lain-lain)');
        $this->command->info('✓ Created 20 Barang with auto-generated kode_barang');
        $this->command->info('Default password: password');
    }
}
