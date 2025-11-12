<?php
// database/migrations/2024_01_06_create_pengajuan_details_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_details', function (Blueprint $table) {
            $table->id('pengajuanDetailID');
            $table->foreignId('pengajuanID')->constrained('pengajuans', 'pengajuanID')->onDelete('cascade');
            $table->foreignId('barangID')->constrained('barangs', 'barangID');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_details');
    }
};
