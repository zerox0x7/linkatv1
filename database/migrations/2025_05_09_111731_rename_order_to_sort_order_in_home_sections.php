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
        // Use raw SQL for MariaDB compatibility
        DB::statement('ALTER TABLE home_sections CHANGE `order` sort_order INT DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Use raw SQL for MariaDB compatibility
        DB::statement('ALTER TABLE home_sections CHANGE sort_order `order` INT DEFAULT 0');
    }
};
