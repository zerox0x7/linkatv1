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
        Schema::create('themes_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->string('theme_name', 100);
            $table->json('hero_data')->nullable()->comment('Hero section images and data');
            $table->json('banner_data')->nullable()->comment('Banner images and data');
            $table->json('feature_data')->nullable()->comment('Feature section data');
            $table->json('extra_images')->nullable()->comment('Additional theme images');
            $table->json('custom_data')->nullable()->comment('Other custom theme data');
            $table->text('custom_css')->nullable()->comment('Custom CSS for this theme');
            $table->text('custom_js')->nullable()->comment('Custom JS for this theme');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            
            // Indexes
            $table->index('store_id');
            $table->index('theme_name');
            $table->index(['store_id', 'theme_name']);
            $table->unique(['store_id', 'theme_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes_data');
    }
};
