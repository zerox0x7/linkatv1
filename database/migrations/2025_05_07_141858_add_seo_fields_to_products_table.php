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
            // إضافة حقول السيو
            $table->string('meta_title')->nullable()->after('description');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
            $table->string('focus_keyword')->nullable()->after('meta_keywords');
            
            // إضافة حقل للتاغات
            $table->text('tags')->nullable()->after('focus_keyword');
            
            // إضافة حقل لتقييم SEO (اختياري)
            $table->tinyInteger('seo_score')->nullable()->after('tags');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // حذف الحقول عند التراجع
            $table->dropColumn([
                'meta_title',
                'meta_description',
                'meta_keywords',
                'focus_keyword',
                'tags',
                'seo_score'
            ]);
        });
    }
};
