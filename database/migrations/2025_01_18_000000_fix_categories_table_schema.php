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
        Schema::table('categories', function (Blueprint $table) {
            // Fix store_id column type from bigint to int
            if (Schema::hasColumn('categories', 'store_id')) {
                $table->integer('store_id')->nullable()->change();
            }
            
            // Ensure homepage_order is nullable as per the desired schema
            if (Schema::hasColumn('categories', 'homepage_order')) {
                $table->integer('homepage_order')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Revert store_id back to unsignedBigInteger
            if (Schema::hasColumn('categories', 'store_id')) {
                $table->unsignedBigInteger('store_id')->nullable()->change();
            }
            
            // Revert homepage_order back to non-nullable with default 0
            if (Schema::hasColumn('categories', 'homepage_order')) {
                $table->integer('homepage_order')->default(0)->change();
            }
        });
    }
}; 