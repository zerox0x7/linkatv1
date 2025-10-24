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
        if (!Schema::hasTable('theme_links')) {
            Schema::create('theme_links', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255)->unique()->comment('Theme name identifier');
                $table->json('links')->comment('JSON object containing all theme links with their icons and routes');
                $table->boolean('is_active')->default(true)->comment('Whether this theme is currently active');
                $table->text('description')->nullable()->comment('Optional description of the theme');
                $table->timestamps();
                
                // Add index for better performance on name lookups
                $table->index('name');
                $table->index('is_active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_links');
    }
};
