<?php
// database/migrations/2025_11_12_040946_create_laporans_table.php
// LAPORAN TABLE - Untuk audit trail & dokumentasi resmi

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id('laporanID');
            $table->foreignId('userID')->constrained('users', 'userID')->onDelete('restrict');  // Operator pembuat
            $table->enum('jenis', ['pengajuan', 'stok', 'transaksi'])->default('pengajuan');  // Tipe laporan
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->integer('total_items')->default(0);  // Jumlah item dalam laporan
            $table->json('isi')->nullable();  // Data laporan (JSON)
            $table->enum('status', ['draft', 'final', 'approved'])->default('draft');  // Status laporan (audit trail)
            $table->timestamp('finalized_at')->nullable();  // Saat laporan di-finalize
            $table->timestamps();

            $table->index('jenis');
            $table->index('status');
            $table->index('periode_awal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
