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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // المستخدم المشترك
            $table->foreignId('subscription_plan_id')->constrained()->onDelete('cascade'); // خطة الاشتراك
            $table->string('status')->default('pending'); // حالة الاشتراك (pending, active, expired, cancelled)
            $table->decimal('amount_paid', 10, 2); // المبلغ المدفوع
            $table->string('payment_method')->nullable(); // طريقة الدفع
            $table->string('payment_id')->nullable(); // معرف الدفع
            $table->timestamp('starts_at'); // تاريخ بداية الاشتراك
            $table->timestamp('ends_at'); // تاريخ انتهاء الاشتراك
            $table->timestamp('paid_at')->nullable(); // تاريخ الدفع
            $table->timestamp('cancelled_at')->nullable(); // تاريخ الإلغاء
            $table->json('metadata')->nullable(); // بيانات إضافية
            $table->timestamps();
            
            // فهارس لتحسين الأداء
            $table->index(['user_id', 'status']);
            $table->index(['ends_at', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
