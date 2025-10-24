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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الخطة (شهري، 6 أشهر، سنوي)
            $table->string('slug')->unique(); // معرف الخطة
            $table->text('description'); // وصف الخطة
            $table->decimal('price', 10, 2); // سعر الخطة
            $table->integer('duration_days'); // مدة الخطة بالأيام
            $table->string('duration_type'); // نوع المدة (monthly, semi_annual, annual)
            $table->json('features'); // مميزات الخطة
            $table->integer('max_products')->nullable(); // الحد الأقصى للمنتجات
            $table->integer('max_orders')->nullable(); // الحد الأقصى للطلبات
            $table->decimal('commission_rate', 5, 2)->default(0); // نسبة العمولة
            $table->boolean('is_active')->default(true); // نشطة أم لا
            $table->boolean('is_featured')->default(false); // مميزة أم لا
            $table->integer('sort_order')->default(0); // ترتيب العرض
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
