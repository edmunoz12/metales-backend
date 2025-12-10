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
        Schema::table('assemblies', function (Blueprint $table) {
            $table->foreignId('assembly_customer_id')->nullable()->constrained('assembly_customers','id')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users', 'id')->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assemblies', function (Blueprint $table) {
            $table->dropForeign(['assembly_customer_id']);
            $table->dropColumn('assembly_customer_id');

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            
        });
    }
};
