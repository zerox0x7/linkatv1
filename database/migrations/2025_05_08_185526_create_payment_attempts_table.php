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
        Schema::create('payment_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('transaction_id')->nullable()->index();
            $table->string('payment_method');
            $table->decimal('amount', 10, 2);
            $table->string('status');
            $table->json('request_data')->nullable();
            $table->json('response_data')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            // Add a unique index on order_id and transaction_id
            $table->unique(['order_id', 'transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_attempts');
    }
};
