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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'store_id')) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('products', 'has_discounts')) {
                $table->boolean('has_discounts')->default(false)->after('store_id');
            }
            if (!Schema::hasColumn('products', 'has_discount')) {
                $table->boolean('has_discount')->default(false)->after('has_discounts');
            }
            if (!Schema::hasColumn('products', 'product_note')) {
                $table->text('product_note')->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('product_note');
            }
            if (!Schema::hasColumn('products', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            if (!Schema::hasColumn('products', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('products', 'focus_keyword')) {
                $table->string('focus_keyword')->nullable()->after('meta_keywords');
            }
            if (!Schema::hasColumn('products', 'tags')) {
                $table->text('tags')->nullable()->after('focus_keyword');
            }
            if (!Schema::hasColumn('products', 'seo_score')) {
                $table->integer('seo_score')->nullable()->after('tags');
            }
            if (!Schema::hasColumn('products', 'custom_fields')) {
                $table->json('custom_fields')->nullable()->after('gallery');
            }
            if (!Schema::hasColumn('products', 'price_options')) {
                $table->json('price_options')->nullable()->after('custom_fields');
            }
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->unique()->nullable()->after('views_count');
            }
            if (!Schema::hasColumn('products', 'share_slug')) {
                $table->string('share_slug')->unique()->nullable()->after('sku');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = [
                'store_id', 'has_discounts', 'has_discount', 'product_note', 'meta_title',
                'meta_description', 'meta_keywords', 'focus_keyword', 'tags', 'seo_score',
                'custom_fields', 'price_options', 'sku', 'share_slug'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}; 