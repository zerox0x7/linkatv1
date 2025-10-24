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
        Schema::create('home_page', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable();
            
            // Store Info Section
            $table->string('store_name')->nullable();
            $table->text('store_description')->nullable();
            $table->string('store_logo')->nullable();
            
            // Hero Section
            $table->boolean('hero_enabled')->default(true);
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_button1_text')->nullable();
            $table->text('hero_button1_link')->nullable();
            $table->string('hero_button2_text')->nullable();
            $table->text('hero_button2_link')->nullable();
            $table->string('hero_background_image')->nullable();
            
            // Categories Section
            $table->boolean('categories_enabled')->default(true);
            $table->string('categories_title')->nullable();
            $table->json('categories_data')->nullable();
            
            // Featured Products Section
            $table->boolean('featured_enabled')->default(true);
            $table->string('featured_title')->nullable();
            $table->integer('featured_count')->default(4);
            $table->json('featured_products')->nullable();
            
            // Services Section
            $table->boolean('services_enabled')->default(true);
            $table->string('services_title')->nullable();
            $table->json('services_data')->nullable();
            
            // Reviews Section
            $table->boolean('reviews_enabled')->default(true);
            $table->string('reviews_title')->nullable();
            $table->integer('reviews_count')->default(3);
            $table->json('reviews_data')->nullable();
            
            // Location Section
            $table->boolean('location_enabled')->default(true);
            $table->string('location_title')->nullable();
            $table->string('location_address')->nullable();
            $table->string('location_phone')->nullable();
            $table->string('location_email')->nullable();
            $table->string('location_hours')->nullable();
            $table->string('location_map_image')->nullable();
            
            // Footer Section
            $table->boolean('footer_enabled')->default(true);
            $table->text('footer_description')->nullable();
            $table->json('footer_quick_links')->nullable();
            $table->json('footer_payment_methods')->nullable();
            $table->json('footer_social_media')->nullable();
            $table->string('footer_copyright')->nullable();
            
            // Theme Colors
            $table->string('primary_color')->default('#00e5bb');
            $table->string('background_color')->default('#0f172a');
            $table->string('text_color')->default('#ffffff');
            $table->string('secondary_text_color')->default('#94a3b8');
            
            $table->timestamps();
            
            // Add index for store_id
            $table->index('store_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_page');
    }
};
