<?php
// database/migrations/2024_01_08_create_detail_barang_masuks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_barang_masuks', function (Blueprint $table) {
            $table->id('detailMasukID');
            $table->foreignId('transaksiMasukID')->constrained('transaksi_masuks', 'transaksiMasukID')->onDelete('cascade');
            $table->foreignId('barangID')->constrained('barangs', 'barangID');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_barang_masuks');
    }
};
