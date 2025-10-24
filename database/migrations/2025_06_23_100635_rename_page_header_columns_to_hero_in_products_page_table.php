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
        Schema::table('products_page', function (Blueprint $table) {
            $table->renameColumn('hero_enabled', 'page_header_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_page', function (Blueprint $table) {
            $table->renameColumn('page_header_enabled', 'hero_enabled');
        });
    }
};
