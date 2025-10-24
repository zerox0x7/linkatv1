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
            // Add main menus control columns after navigation_enabled
            $table->boolean('main_menus_enabled')->default(true)->after('navigation_enabled');
            $table->integer('main_menus_number')->default(5)->after('main_menus_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('header_settings', function (Blueprint $table) {
            $table->dropColumn(['main_menus_enabled', 'main_menus_number']);
        });
    }
};
