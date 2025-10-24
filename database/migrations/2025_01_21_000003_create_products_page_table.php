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
        Schema::create('products_page', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            
            // Page Header Settings
            $table->boolean('page_header_enabled')->default(true);
            $table->string('page_title')->nullable();
            $table->string('page_subtitle')->nullable();
            $table->text('header_image')->nullable();
            
            // Discount Timer Settings
            $table->boolean('discount_timer_enabled')->default(false);
            $table->string('discount_text')->nullable();
            $table->datetime('discount_end_date')->nullable();
            $table->enum('timer_style', ['modern', 'classic', 'minimal', 'bold'])->default('modern');
            
            // Coupon Banner Settings
            $table->boolean('coupon_banner_enabled')->default(false);
            $table->string('coupon_code')->nullable();
            $table->string('coupon_text')->nullable();
            $table->string('coupon_background_color')->default('#ff4444');
            
            // Layout Settings
            $table->enum('layout_style', ['grid', 'list'])->default('grid');
            $table->integer('products_per_row')->default(3);
            $table->boolean('sidebar_enabled')->default(true);
            $table->enum('sidebar_position', ['left', 'right'])->default('right');
            
            // Filter Settings
            $table->boolean('search_enabled')->default(true);
            $table->string('search_placeholder')->nullable();
            $table->boolean('price_filter_enabled')->default(true);
            $table->boolean('category_filter_enabled')->default(true);
            $table->boolean('brand_filter_enabled')->default(true);
            $table->boolean('rating_filter_enabled')->default(true);
            $table->boolean('sort_options_enabled')->default(true);
            $table->enum('default_sort', ['latest', 'oldest', 'price_low', 'price_high', 'name_asc', 'name_desc', 'rating'])->default('latest');
            
            // Product Display Settings
            $table->enum('product_card_style', ['modern', 'classic', 'minimal'])->default('modern');
            $table->boolean('product_rating_enabled')->default(true);
            $table->boolean('product_badges_enabled')->default(true);
            $table->boolean('quick_view_enabled')->default(true);
            $table->boolean('wishlist_enabled')->default(true);
            $table->integer('products_per_page')->default(12);
            $table->enum('pagination_style', ['numbers', 'loadmore'])->default('numbers');
            
            // Color Scheme Settings
            $table->string('primary_color')->default('#3b82f6');
            $table->string('secondary_color')->default('#6b7280');
            $table->string('accent_color')->default('#f59e0b');
            $table->string('background_color')->default('#ffffff');
            
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            
            // Unique constraint - one settings record per store
            $table->unique('store_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_page');
    }
}; 