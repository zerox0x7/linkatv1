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
            $table->boolean('settings_enabled')->default(true)->after('mobile_cart_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('header_settings', function (Blueprint $table) {
            $table->dropColumn('settings_enabled');
        });
    }
};
