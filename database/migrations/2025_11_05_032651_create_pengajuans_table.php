<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // Pegawai yg mengajukan
            $table->text('keperluan');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->foreignId('operator_id')->nullable()->constrained('users'); // Operator yg memvalidasi
            $table->timestamp('processed_at')->nullable(); // Tgl divalidasi
            $table->timestamps(); // Tgl diajukan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuans');
    }
};
