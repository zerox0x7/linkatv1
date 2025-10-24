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
        Schema::table('home_sections', function (Blueprint $table) {
            // إضافة عمود store_id مع foreign key constraint
            $table->unsignedBigInteger('store_id')->default(1)->after('id');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            
            // إضافة index للأداء
            $table->index(['store_id', 'is_active']);
            
            // إصلاح مشكلة sort_order إلى order إذا كان العمود موجود
            if (Schema::hasColumn('home_sections', 'sort_order')) {
                $table->renameColumn('sort_order', 'order');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_sections', function (Blueprint $table) {
            // حذف foreign key constraint أولاً
            $table->dropForeign(['store_id']);
            
            // حذف index
            $table->dropIndex(['store_id', 'is_active']);
            
            // حذف عمود store_id
            $table->dropColumn('store_id');
            
            // إرجاع order إلى sort_order إذا لزم الأمر
            if (Schema::hasColumn('home_sections', 'order')) {
                $table->renameColumn('order', 'sort_order');
            }
        });
    }
};
