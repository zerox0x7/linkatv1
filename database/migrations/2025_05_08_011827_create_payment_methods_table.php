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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم طريقة الدفع
            $table->string('code')->unique(); // كود طريقة الدفع (مثل paypal, stripe, myfatoorah)
            $table->string('description')->nullable(); // وصف طريقة الدفع
            $table->string('logo')->nullable(); // شعار طريقة الدفع
            $table->json('credentials')->nullable(); // بيانات الاعتماد (مفاتيح API)
            $table->json('settings')->nullable(); // إعدادات إضافية
            $table->boolean('is_active')->default(false); // حالة التفعيل
            $table->float('fee_percentage', 5, 2)->default(0); // نسبة الرسوم
            $table->float('fee_fixed', 8, 2)->default(0); // رسوم ثابتة
            $table->integer('sort_order')->default(0); // ترتيب العرض
            $table->enum('mode', ['live', 'test'])->default('test'); // وضع التشغيل
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
