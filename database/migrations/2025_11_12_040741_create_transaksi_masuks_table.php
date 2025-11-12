<?php
// database/migrations/2024_01_07_create_transaksi_masuks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_masuks', function (Blueprint $table) {
            $table->id('transaksiMasukID');
            $table->date('tanggal');
            $table->string('sumber');
            $table->text('keterangan')->nullable();
            $table->foreignId('operatorID')->constrained('operators', 'operatorID');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_masuks');
    }
};
