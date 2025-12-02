<?php
// database/migrations/2024_01_11_create_stock_opnames_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_opnames', function (Blueprint $table) {
            $table->id('opnameID');
            // PERBAIKAN: Ubah referensi tabel dari 'operators' ke 'users'
            // dan kolom referensi menjadi 'id' (standar Laravel)
            $table->foreignId('operatorID')->constrained('users', 'userID'); 
            // JIKA tabel users Anda menggunakan userID sebagai PK: $table->foreignId('operatorID')->constrained('users', 'userID');
            
            $table->date('tanggal_opname');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_opnames');
    }
};
