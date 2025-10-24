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
            // Change string columns to text for longer content
            $table->text('hero_background_image')->nullable()->change();
            $table->text('location_map_image')->nullable()->change();
            $table->text('store_logo')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page', function (Blueprint $table) {
            $table->string('hero_background_image')->nullable()->change();
            $table->string('location_map_image')->nullable()->change();
            $table->string('store_logo')->nullable()->change();
        });
    }
};
