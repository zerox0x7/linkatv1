<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('home_section_settings', function (Blueprint $table) {
            // استخدام SQL مباشر لتجنب مشاكل Doctrine
            DB::statement('ALTER TABLE `home_section_settings` CHANGE `section_key` `key` VARCHAR(255) NOT NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_section_settings', function (Blueprint $table) {
            // استخدام SQL مباشر لتجنب مشاكل Doctrine
            DB::statement('ALTER TABLE `home_section_settings` CHANGE `key` `section_key` VARCHAR(255) NOT NULL');
        });
    }
};
