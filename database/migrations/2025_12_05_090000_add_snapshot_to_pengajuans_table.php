<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menambahkan kolom snapshot untuk nama pegawai dan NIP
     * agar data laporan historis tidak berubah saat profil di-update
     */
    public function up(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            // Snapshot nama pegawai saat pengajuan dibuat
            $table->string('nama_pegawai_snapshot')->nullable()->after('pegawaiID');
            // Snapshot NIP pegawai saat pengajuan dibuat
            $table->string('nip_snapshot')->nullable()->after('nama_pegawai_snapshot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn(['nama_pegawai_snapshot', 'nip_snapshot']);
        });
    }
};
