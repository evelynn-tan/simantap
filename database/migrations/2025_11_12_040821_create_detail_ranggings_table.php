<?php
// DETAIL TRANSAKSI (JUNCTION) - Untuk detail items dalam transaksi
// yang awalnya ada 2 table detail barang masuk dan keluar dijadikan 1 table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_rangggings', function (Blueprint $table) {
            $table->id('detailRanggingID');
            $table->foreignId('transaksiID')->constrained('transaksis', 'transaksiID')->onDelete('cascade');
            $table->foreignId('barangID')->constrained('barangs', 'barangID')->onDelete('restrict');
            $table->integer('jumlah');
            $table->integer('stok_sebelum');  // Stok sebelum transaksi
            $table->integer('stok_sesudah');  // Stok setelah transaksi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_rangggings');
    }
};
