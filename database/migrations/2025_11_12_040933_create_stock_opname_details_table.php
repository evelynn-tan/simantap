<?php
// database/migrations/2025_11_12_040933_create_stock_opname_details_table.php
// STOCK OPNAME DETAILS TABLE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_opname_details', function (Blueprint $table) {
            $table->id('opnameDetailID');
            $table->foreignId('opnameID')->constrained('stock_opnames', 'opnameID')->onDelete('cascade');
            $table->foreignId('barangID')->constrained('barangs', 'barangID')->onDelete('restrict');
            $table->integer('stok_sistem');  // Stok menurut sistem
            $table->integer('stok_fisik');   // Stok menurut fisik
            $table->integer('stok_selisih');  // stok_fisik - stok_sistem
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_opname_details');
    }
};
