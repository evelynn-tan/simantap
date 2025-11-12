<?php
// database/migrations/2024_01_10_create_detail_barang_keluars_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_barang_keluars', function (Blueprint $table) {
            $table->id('detailKeluarID');
            $table->foreignId('transaksiKeluarID')->constrained('transaksi_keluars', 'transaksiKeluarID')->onDelete('cascade');
            $table->foreignId('barangID')->constrained('barangs', 'barangID');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_barang_keluars');
    }
};
