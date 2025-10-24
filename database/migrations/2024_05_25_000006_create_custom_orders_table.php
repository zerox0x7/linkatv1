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
        Schema::create('custom_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('status')->default('new'); // new, under_review, in_progress, completed, rejected
            $table->text('admin_notes')->nullable();
            $table->date('deadline')->nullable();
            $table->decimal('final_price', 10, 2)->nullable();
            $table->foreignId('assigned_to')->nullable()->references('id')->on('users');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_orders');
    }
}; 