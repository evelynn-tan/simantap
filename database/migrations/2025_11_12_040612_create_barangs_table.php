<?php
// database/migrations/2024_01_04_create_barangs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id('barangID');
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->foreignId('kategoriID')->constrained('kategoris', 'kategoriID');
            $table->string('satuan');
            $table->integer('stok_awal')->default(0);
            $table->integer('stok_sekarang')->default(0);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['tersedia', 'habis', 'restricted'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
