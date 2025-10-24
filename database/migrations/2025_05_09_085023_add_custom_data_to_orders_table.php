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
        Schema::table('orders', function (Blueprint $table) {
            $table->json('custom_data')->nullable()->after('notes')
                ->comment('بيانات المنتجات المخصصة التي تم إدخالها من قبل العميل');
            $table->boolean('has_custom_products')->default(false)->after('custom_data')
                ->comment('مؤشر على وجود منتجات مخصصة في الطلب');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('custom_data');
            $table->dropColumn('has_custom_products');
        });
    }
};
