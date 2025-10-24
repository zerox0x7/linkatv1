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
        Schema::table('home_page', function (Blueprint $table) {
            // Add store_id column as the first column after id
            $table->unsignedBigInteger('store_id')->nullable()->after('id');
            
            // Add foreign key constraint if stores table exists
            // Uncomment the next line if you have a stores table
            // $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page', function (Blueprint $table) {
            // Drop foreign key constraint first if it exists
            // Uncomment the next line if you added the foreign key constraint
            // $table->dropForeign(['store_id']);
            
            // Drop the store_id column
            $table->dropColumn('store_id');
        });
    }
};
