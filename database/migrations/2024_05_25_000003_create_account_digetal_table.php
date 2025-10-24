<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('account_digetal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['available', 'sold', 'pending'])->default('available');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->json('meta')->nullable(); // الحقول الديناميكية
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('account_digetal');
    }
}; 