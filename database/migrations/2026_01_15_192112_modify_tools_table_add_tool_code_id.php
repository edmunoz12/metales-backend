<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tools', function (Blueprint $table) {

            // Agregar la columna 'tool_code_id' como foreign key
            $table->foreignId('tool_code_id')
                ->nullable()
                ->constrained('tool_codes')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            if (Schema::hasColumn('tools', 'tool_code_id')) {
                $table->dropForeign(['tool_code_id']);
                $table->dropColumn('tool_code_id');
            }
        });
    }
};
