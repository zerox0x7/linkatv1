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
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->json('credentials')->nullable()->after('logo'); // بيانات الاعتماد (مشفرة)
            $table->json('settings')->nullable()->after('credentials'); // إعدادات البوابة والتفضيلات
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('credentials');
            $table->dropColumn('settings');
        });
    }
};
