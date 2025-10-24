<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->json('credentials')->nullable();
            $table->json('settings')->nullable();
            $table->boolean('is_active')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // إضافة طريقة clickpay كمثال
        DB::table('payment_methods')->insert([
            'name' => 'كليك باي',
            'code' => 'clickpay',
            'description' => 'الدفع باستخدام كليك باي',
            'credentials' => json_encode(['profile_id' => '43602', 'server_key' => 'S9JNLNMJJG-JHBJN9MGZZ-JDN9JKZHDH']),
            'settings' => json_encode(['test_mode' => true]),
            'is_active' => true,
            'sort_order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
