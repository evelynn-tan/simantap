<?php
// database/migrations/2025_11_12_040921_create_stock_opnames_table.php
// STOCK OPNAME TABLE - Ubah operatorID ke userID

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_opnames', function (Blueprint $table) {
            $table->id('opnameID');
            $table->foreignId('userID')->constrained('users', 'userID')->onDelete('restrict');  // Operator yang melakukan opname
            $table->date('tanggal_opname');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('tanggal_opname');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_opnames');
    }
};
