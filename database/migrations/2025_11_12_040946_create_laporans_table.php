<?php
// database/migrations/2024_01_13_create_laporans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id('laporanID');
            $table->foreignId('operatorID')->constrained('operators', 'operatorID');
            $table->string('jenis_laporan');
            $table->date('periode_mulai');
            $table->date('periode_selesai');
            $table->text('parameter')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
