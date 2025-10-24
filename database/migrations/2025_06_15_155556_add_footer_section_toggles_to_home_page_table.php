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
            // Add footer section toggle columns after footer_address
            $table->boolean('footer_social_media_enabled')->default(true)->after('footer_address');
            $table->boolean('footer_payment_methods_enabled')->default(false)->after('footer_social_media_enabled');
            $table->boolean('footer_categories_enabled')->default(false)->after('footer_payment_methods_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page', function (Blueprint $table) {
            $table->dropColumn([
                'footer_social_media_enabled',
                'footer_payment_methods_enabled',
                'footer_categories_enabled'
            ]);
        });
    }
};
