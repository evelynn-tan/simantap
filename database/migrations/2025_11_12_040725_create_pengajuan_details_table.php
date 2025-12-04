<?php
// database/migrations/2025_11_12_040725_create_pengajuan_details_table.php
// PENGAJUAN_DETAILS TABLE - Add status column untuk tracking

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
            $table->foreignId('barangID')->constrained('barangs', 'barangID')->onDelete('restrict');
            $table->integer('jumlah');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');  // NEW: Track status per item
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_details');
    }
};
