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
        Schema::create('header_settings', function (Blueprint $table) {
            $table->id();
            
            // General Header Settings
            $table->boolean('header_enabled')->default(true);
            $table->string('header_font')->default('Tajawal');
            $table->boolean('header_sticky')->default(true);
            $table->boolean('header_shadow')->default(true);
            $table->boolean('header_scroll_effects')->default(true);
            $table->boolean('header_smooth_transitions')->default(true);
            $table->text('header_custom_css')->nullable();
            $table->string('header_layout')->default('default');
            $table->integer('header_height')->default(80);
            
            // Logo Settings
            $table->boolean('logo_enabled')->default(true);
            $table->string('logo_image')->nullable();
            $table->text('logo_svg')->nullable();
            $table->integer('logo_width')->default(150);
            $table->integer('logo_height')->default(50);
            $table->enum('logo_position', ['left', 'center', 'right'])->default('left');
            $table->string('logo_border_radius')->default('rounded-lg');
            $table->boolean('logo_shadow_enabled')->default(false);
            $table->string('logo_shadow_class')->nullable();
            $table->string('logo_shadow_color')->default('gray-500');
            $table->string('logo_shadow_opacity')->default('50');
            
            // Navigation Settings
            $table->boolean('navigation_enabled')->default(true);
            $table->boolean('show_home_link')->default(true);
            $table->boolean('show_categories_in_menu')->default(true);
            $table->json('menu_items')->nullable();
            
            // Header Features
            $table->boolean('search_bar_enabled')->default(true);
            $table->boolean('user_menu_enabled')->default(true);
            $table->boolean('shopping_cart_enabled')->default(false);
            $table->boolean('wishlist_enabled')->default(false);
            $table->boolean('language_switcher_enabled')->default(false);
            $table->boolean('currency_switcher_enabled')->default(false);
            
            // Contact Information
            $table->boolean('header_contact_enabled')->default(false);
            $table->string('header_phone')->nullable();
            $table->string('header_email')->nullable();
            $table->enum('contact_position', ['top', 'main', 'right'])->default('top');
            
            // Mobile Settings
            $table->boolean('mobile_menu_enabled')->default(true);
            $table->boolean('mobile_search_enabled')->default(true);
            $table->boolean('mobile_cart_enabled')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_settings');
    }
};
