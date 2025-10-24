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
            // Add brand section columns after featured products section
            $table->boolean('brand_enabled')->default(true)->after('featured_products');
            $table->string('brand_title')->nullable()->after('brand_enabled');
            $table->integer('brand_count')->default(6)->after('brand_title');
            $table->json('brand_products')->nullable()->after('brand_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page', function (Blueprint $table) {
            $table->dropColumn([
                'brand_enabled',
                'brand_title', 
                'brand_count',
                'brand_products'
            ]);
        });
    }
};
