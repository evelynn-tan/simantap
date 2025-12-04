<?php
// database/migrations/2025_11_12_040534_create_operators_table.php
// OPERATOR TABLE - Hanya FK ke users (Operator = sistem, bukan personal)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operators', function (Blueprint $table) {
            $table->foreignId('userID')->primary()->constrained('users', 'userID')->onDelete('cascade');
            // Hanya FK, tidak ada identitas personal
            // Operator = sistem (operator.bps.go.id)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operators');
    }
};
