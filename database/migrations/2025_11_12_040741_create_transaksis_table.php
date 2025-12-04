<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('transaksiID');
            $table->foreignId('userID')->constrained('users', 'userID')->onDelete('restrict');  // Operator yang melakukan
            $table->date('tanggal');
            $table->enum('jenis', ['masuk', 'keluar', 'penyesuaian'])->default('masuk');  // Tipe transaksi
            $table->string('sumber')->nullable();  // Untuk masuk: supplier, pembelian, dll
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('tanggal');
            $table->index('jenis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
