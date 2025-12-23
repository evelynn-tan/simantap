<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add 'dibatalkan' to status enum
        DB::statement("ALTER TABLE pengajuans MODIFY COLUMN status ENUM('menunggu', 'disetujui', 'ditolak', 'dibatalkan') DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        // Revert to original enum (Note: will fail if any records have 'dibatalkan' status)
        DB::statement("ALTER TABLE pengajuans MODIFY COLUMN status ENUM('menunggu', 'disetujui', 'ditolak') DEFAULT 'menunggu'");
    }
};
