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
            $table->string('shape')->nullable();
            $table->string('station_size')->nullable();
            $table->string('measurement')->nullable();
            $table->float('angle')->nullable();
            $table->string('clarity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn([
                'shape',
                'station_size',
                'measurement',
                'angle',
                'clarity',
            ]);
        });
    }
};
