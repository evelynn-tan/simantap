<?php
// database/migrations/2025_11_12_040902_create_detail_barang_keluars_table.php
// DEPRECATED - Detail barang keluar sudah merge ke detail_rangggings table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // SKIP - Sudah tercakup di detail_rangggings table
    }

    public function down(): void
    {
        // SKIP
    }
};
