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
        Schema::table('processes', function (Blueprint $table) {
            $table->string('process_code')->unique()->nullable();
            $table->string('machine_operator')->nullable();
//            $table->timestamp('start_time')->nullable();
//            $table->timestamp('end_time')->nullable();
//
//            $table->decimal('duration', 8, 2)->unsigned()->nullable();
//            $table->decimal('expected_duration', 8, 2)->unsigned()->nullable();
//            $table->integer('required_quantity', 8, 2)->unsigned()->nullable();
//            $table->integer('delivered_quantity', 8, 2)->unsigned()->nullable();
//            $table->integer('quantity_defective', 8, 2)->unsigned()->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('processes', function (Blueprint $table) {
            $table->dropColumn([
                'process_code',
                'machine_operator',
//                'start_time',
//                'end_time',
//                'duration',
//                'expected_duration',
//                'required_quantity',
//                'delivered_quantity',
//                'quantity_defective',
            ]);
        });
    }
};
