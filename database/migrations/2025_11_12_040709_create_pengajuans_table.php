<?php
// database/migrations/2025_11_12_040709_create_pengajuans_table.php
// PENGAJUAN TABLE - Ubah approved_by ke userID (bukan operatorID)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id('pengajuanID');
            $table->foreignId('pegawaiID')->constrained('pegawais', 'pegawaiID')->onDelete('cascade');
            $table->timestamp('requested_at');  // Changed from date to timestamp
            $table->text('description');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('alasan_penolakan')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users', 'userID')->onDelete('set null');  // FK ke users
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
