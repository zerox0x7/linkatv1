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
        Schema::table('top_header_settings', function (Blueprint $table) {
            $table->boolean('text_only')->default(false)->after('show_countdown');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('top_header_settings', function (Blueprint $table) {
            $table->dropColumn('text_only');
        });
    }
};
