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
        Schema::create('digital_card_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_card_id')->constrained()->onDelete('cascade');
            $table->string('code');
            $table->string('status')->default('available'); // available, sold, expired
            $table->dateTime('expiry_date')->nullable();
            $table->dateTime('sold_at')->nullable();
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_card_codes');
    }
}; 