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
        Schema::table('themes_data', function (Blueprint $table) {
            $table->json('sections_data')->nullable()->comment('Section activation data (firstSection, secondSection, etc.)')->after('custom_js');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('themes_data', function (Blueprint $table) {
            $table->dropColumn('sections_data');
        });
    }
};
