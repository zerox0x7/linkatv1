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
            
            // المعلومات الأساسية
            $table->string('name'); // اسم طريقة الدفع
            $table->string('code')->unique(); // الكود الفريد للبوابة (paypal, stripe, myfatoorah)
            $table->string('description')->nullable(); // وصف طريقة الدفع
            $table->string('logo')->nullable(); // مسار شعار البوابة
            
            // بيانات الاتصال والاعتماد (مشفرة)
            $table->json('credentials')->nullable(); // يخزن مفاتيح API والبيانات الحساسة (مشفر)
            
            // إعدادات البوابة والتفضيلات 
            $table->json('settings')->nullable(); // إعدادات متنوعة خاصة بكل بوابة
            
            // خيارات الوضع والتفعيل
            $table->boolean('is_active')->default(false); // حالة تفعيل البوابة
            $table->enum('mode', ['live', 'test'])->default('test'); // وضع التشغيل
            
            // إعدادات العملات
            $table->string('default_currency')->default('SAR'); // العملة الافتراضية  
            $table->json('supported_currencies')->nullable(); // العملات المدعومة
            
            // إعدادات الرسوم
            $table->float('fee_percentage', 5, 2)->default(0); // نسبة الرسوم
            $table->float('fee_fixed', 8, 2)->default(0); // رسوم ثابتة
            
            // إعدادات العرض
            $table->integer('sort_order')->default(0); // ترتيب العرض
            $table->boolean('visible_on_checkout')->default(true); // الظهور في صفحة الدفع
            
            // حدود الاستخدام
            $table->decimal('min_order_amount', 10, 2)->nullable(); // الحد الأدنى للطلب
            $table->decimal('max_order_amount', 10, 2)->nullable(); // الحد الأقصى للطلب
            
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
