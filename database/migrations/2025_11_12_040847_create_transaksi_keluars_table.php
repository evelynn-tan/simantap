<?php
// database/migrations/2025_11_12_040847_create_transaksi_keluars_table.php
// DEPRECATED - Transaksi keluar sudah merge ke transaksis table
// File ini dihapus, schema sudah tercakup di transaksis

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // SKIP - Sudah tercakup di transaksis table
    }

    public function down(): void
    {
        // SKIP
    }
};
