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
        Schema::table('header_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('store_id')->nullable()->after('id');
            $table->index('store_id');
            
            // Add foreign key constraint if stores table exists
            // Uncomment the line below if you have a stores table
            // $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('header_settings', function (Blueprint $table) {
            // Drop foreign key first if it exists
            // $table->dropForeign(['store_id']);
            
            $table->dropIndex(['store_id']);
            $table->dropColumn('store_id');
        });
    }
};
