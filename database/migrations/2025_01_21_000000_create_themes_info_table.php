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
        Schema::create('themes_info', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('Theme name');
            $table->string('slug', 255)->unique()->comment('Theme slug for URLs');
            $table->text('description')->nullable()->comment('Theme description');
            $table->decimal('price', 10, 2)->nullable()->comment('Theme price');
            $table->string('currency', 3)->default('USD')->comment('Currency code');
            $table->string('screenshot_image', 500)->nullable()->comment('Main screenshot image path');
            $table->json('links')->nullable()->comment('Theme links (demo, download, documentation, etc.)');
            $table->json('images')->nullable()->comment('Array of up to 30 images with order, size, and metadata');
            $table->string('version', 20)->nullable()->comment('Theme version');
            $table->string('author', 255)->nullable()->comment('Theme author/developer');
            $table->text('features')->nullable()->comment('Theme features list');
            $table->string('category', 100)->nullable()->comment('Theme category');
            $table->json('tags')->nullable()->comment('Theme tags');
            $table->string('status', 20)->default('active')->comment('Theme status (active, inactive, draft)');
            $table->boolean('is_featured')->default(false)->comment('Is featured theme');
            $table->boolean('is_premium')->default(false)->comment('Is premium theme');
            $table->integer('downloads_count')->default(0)->comment('Number of downloads');
            $table->integer('views_count')->default(0)->comment('Number of views');
            $table->float('rating', 3, 1)->nullable()->comment('Theme rating');
            $table->integer('reviews_count')->default(0)->comment('Number of reviews');
            $table->date('release_date')->nullable()->comment('Theme release date');
            $table->date('last_updated')->nullable()->comment('Last update date');
            $table->text('requirements')->nullable()->comment('System requirements');
            $table->text('installation_notes')->nullable()->comment('Installation instructions');
            $table->json('custom_data')->nullable()->comment('Additional custom data');
            $table->timestamps();
            
            // Indexes
            $table->index('name');
            $table->index('slug');
            $table->index('category');
            $table->index('status');
            $table->index('is_featured');
            $table->index('is_premium');
            $table->index('author');
            $table->index('release_date');
            $table->index(['status', 'is_featured']);
            $table->index(['category', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes_info');
    }
};
