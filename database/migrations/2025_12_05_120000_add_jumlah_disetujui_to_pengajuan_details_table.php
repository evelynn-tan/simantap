<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom jumlah_disetujui untuk fitur partial approval
     */
    public function up(): void
    {
        Schema::table('pengajuan_details', function (Blueprint $table) {
            // Kolom untuk menyimpan jumlah yang disetujui (bisa lebih kecil dari jumlah yang diminta)
            $table->integer('jumlah_disetujui')->nullable()->after('jumlah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_details', function (Blueprint $table) {
            $table->dropColumn('jumlah_disetujui');
        });
    }
};
