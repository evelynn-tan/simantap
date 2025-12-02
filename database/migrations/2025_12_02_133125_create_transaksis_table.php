<?php

// database/migrations/xxxx_xx_xx_create_transaksis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id(); // PK standar
            
            // Foreign Keys (FK)
            // Asumsi tabel 'barangs' menggunakan PK 'barangID'
            $table->foreignId('barangID')->constrained('barangs', 'barangID')->onDelete('restrict');
            // Asumsi tabel 'users' menggunakan PK 'userID' (sesuai perbaikan di migrasi users)
            $table->foreignId('operatorID')->constrained('users', 'userID')->onDelete('restrict'); 
            
            // Data Transaksi
            $table->enum('jenis', ['masuk', 'keluar', 'penyesuaian']); 
            $table->integer('jumlah'); // Selisih stok
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            
            // Kolom Polymorphic Reference (Untuk menunjuk ke StockOpname)
            $table->unsignedBigInteger('referensi_id')->nullable(); 
            $table->string('referensi_jenis')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
