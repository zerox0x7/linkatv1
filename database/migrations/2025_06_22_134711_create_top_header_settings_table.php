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
        Schema::create('top_header_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable()->index();
            $table->boolean('top_header_enabled')->default(true);
            $table->string('top_header_position')->default('top');
            $table->integer('top_header_height')->default(40);
            $table->boolean('top_header_sticky')->default(false);
            $table->string('background_color')->default('#1e293b');
            $table->string('text_color')->default('#d1d5db');
            $table->string('border_color')->default('#374151');
            $table->integer('opacity')->default(100);
            $table->boolean('contact_enabled')->default(true);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->boolean('quick_links_enabled')->default(true);
            $table->json('quick_links')->nullable();
            $table->boolean('social_media_enabled')->default(true);
            $table->json('social_media')->nullable();
            $table->boolean('language_switcher_enabled')->default(false);
            $table->boolean('currency_switcher_enabled')->default(false);
            $table->boolean('announcement_enabled')->default(false);
            $table->text('announcement_text')->nullable();
            $table->string('announcement_link')->nullable();
            $table->string('announcement_bg_color')->default('#6366f1');
            $table->string('announcement_text_color')->default('#ffffff');
            $table->boolean('announcement_scrolling')->default(false);
            $table->boolean('auth_links_enabled')->default(true);
            $table->boolean('show_login_link')->default(true);
            $table->boolean('show_register_link')->default(true);
            $table->string('login_text')->default('تسجيل الدخول');
            $table->string('register_text')->default('إنشاء حساب');
            $table->boolean('working_hours_enabled')->default(false);
            $table->string('working_hours')->nullable();
            $table->string('movement_type')->default('scroll');
            $table->string('movement_direction')->default('rtl');
            $table->integer('animation_speed')->default(20);
            $table->boolean('pause_on_hover')->default(false);
            $table->boolean('infinite_loop')->default(true);
            $table->text('header_text')->nullable();
            $table->string('header_link')->nullable();
            $table->string('font_size')->default('14px');
            $table->string('font_weight')->default('400');
            $table->string('background_gradient')->default('none');
            $table->boolean('enable_shadow')->default(false);
            $table->boolean('enable_opacity')->default(false);
            $table->boolean('show_contact_info')->default(false);
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->boolean('show_social_icons')->default(false);
            $table->boolean('show_close_button')->default(false);
            $table->boolean('show_countdown')->default(false);
            $table->boolean('text_only')->default(false);
            $table->dateTime('countdown_date')->nullable();
            $table->timestamps();
            
            // Add unique constraint on store_id
            $table->unique('store_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_header_settings');
    }
};
