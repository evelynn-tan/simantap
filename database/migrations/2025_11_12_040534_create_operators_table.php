<?php
// database/migrations/2024_01_02_create_operators_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operators', function (Blueprint $table) {
            $table->id('operatorID');
            $table->foreignId('userID')->constrained('users', 'userID')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nip')->unique();
            $table->string('jabatan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operators');
    }
};
