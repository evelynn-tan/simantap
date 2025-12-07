<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * DatabaseSeeder - Master Seeder untuk SIMANTAP
 * 
 * File ini memanggil semua seeder lainnya dengan urutan yang benar
 * untuk memastikan foreign key constraints terpenuhi.
 * 
 * Penggunaan:
 *   php artisan db:seed              - Jalankan semua seeder
 *   php artisan db:seed --class=UserSeeder    - Jalankan seeder tertentu
 *   php artisan migrate:fresh --seed  - Reset database dan seed ulang
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Urutan seeding:
     * 1. UserSeeder     - Users, Operators, dan Pegawai (parent tables)
     * 2. KategoriSeeder - Kategori barang (parent of barangs)
     * 3. BarangSeeder   - Barang inventaris (depends on kategoris)
     */
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('╔══════════════════════════════════════════════════╗');
        $this->command->info('║           SIMANTAP Database Seeder               ║');
        $this->command->info('║    Sistem Manajemen Inventaris Terpadu BMN       ║');
        $this->command->info('╚══════════════════════════════════════════════════╝');
        $this->command->info('');

        // Disable foreign key checks untuk menghindari constraint violations
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tables (urutan: child to parent)
        $this->command->info('Cleaning existing data...');
        DB::table('stock_opname_details')->truncate();
        DB::table('stock_opnames')->truncate();
        DB::table('detail_rangggings')->truncate();
        DB::table('transaksis')->truncate();
        DB::table('laporans')->truncate();
        DB::table('pengajuan_details')->truncate();
        DB::table('pengajuans')->truncate();
        DB::table('barangs')->truncate();
        DB::table('kategoris')->truncate();
        DB::table('pegawais')->truncate();
        DB::table('operators')->truncate();
        DB::table('users')->truncate();
        $this->command->info('✓ All tables cleaned');
        $this->command->info('');

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Run seeders in correct order
        $this->call([
            UserSeeder::class,      // 1. Users, Operators, Pegawai
            KategoriSeeder::class,  // 2. Kategori barang
            BarangSeeder::class,    // 3. Barang inventaris
        ]);

        // Summary
        $this->command->info('');
        $this->command->info('╔══════════════════════════════════════════════════╗');
        $this->command->info('║              SEEDING COMPLETED!                  ║');
        $this->command->info('╚══════════════════════════════════════════════════╝');
        $this->command->info('');
        $this->command->info('📊 Database Summary:');
        $this->command->info('   • Users     : ' . DB::table('users')->count() . ' records');
        $this->command->info('   • Operators : ' . DB::table('operators')->count() . ' records');
        $this->command->info('   • Pegawai   : ' . DB::table('pegawais')->count() . ' records');
        $this->command->info('   • Kategori  : ' . DB::table('kategoris')->count() . ' records');
        $this->command->info('   • Barang    : ' . DB::table('barangs')->count() . ' records');
        $this->command->info('');
        $this->command->info('🔐 Login Credentials:');
        $this->command->info('   Operator : operator1@bps.go.id / password');
        $this->command->info('   Pegawai  : nabhan@bps.go.id / password');
        $this->command->info('');
    }
}
