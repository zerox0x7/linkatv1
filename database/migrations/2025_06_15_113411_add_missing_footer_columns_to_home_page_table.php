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
            // Add missing footer columns after existing footer columns
            $table->string('footer_background_color')->default('#1e293b')->after('footer_copyright');
            $table->string('footer_text_color')->default('#d1d5db')->after('footer_background_color');
            $table->string('footer_phone')->nullable()->after('footer_text_color');
            $table->string('footer_email')->nullable()->after('footer_phone');
            $table->text('footer_address')->nullable()->after('footer_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page', function (Blueprint $table) {
            $table->dropColumn([
                'footer_background_color',
                'footer_text_color',
                'footer_phone',
                'footer_email',
                'footer_address'
            ]);
        });
    }
};
