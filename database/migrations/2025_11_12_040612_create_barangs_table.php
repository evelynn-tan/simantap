<?php
// database/migrations/2025_11_12_040612_create_barangs_table.php
// BARANG TABLE - Sesuai ERD baru dengan simplifikasi stok

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id('barangID');
            $table->string('kode_barang');  // Auto-generated: BRG-001, BRG-002, dll
            $table->string('nama_barang');
            $table->foreignId('kategoriID')->constrained('kategoris', 'kategoriID')->onDelete('restrict');
            $table->enum('satuan', ['rim', 'pcs', 'buah', 'box', 'pack', 'set', 'lembar', 'meter', 'kg', 'liter'])->default('pcs');
            $table->integer('stok')->default(0);  // SIMPLIFIED: hanya satu kolom stok
            $table->text('deskripsi')->nullable();
            // DIHAPUS: stok_awal, stok_sekarang, status (diganti dengan accessor logic)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
