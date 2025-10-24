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
        Schema::create('home_section_settings', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique(); // مفتاح القسم: categories, features, testimonials, newsletter
            $table->string('title')->nullable(); // عنوان القسم
            $table->text('description')->nullable(); // وصف القسم
            $table->integer('order')->default(0); // ترتيب القسم في الصفحة
            $table->boolean('is_active')->default(true); // حالة تفعيل القسم
            $table->json('content')->nullable(); // محتوى القسم (المميزات، التقييمات، إلخ)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_section_settings');
    }
};
