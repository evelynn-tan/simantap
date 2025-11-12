<?php
// database/migrations/2024_01_09_create_transaksi_keluars_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_keluars', function (Blueprint $table) {
            $table->id('transaksiKeluarID');
            $table->foreignId('pengajuanID')->constrained('pengajuans', 'pengajuanID');
            $table->date('tanggal');
            $table->foreignId('operatorID')->constrained('operators', 'operatorID');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_keluars');
    }
};
