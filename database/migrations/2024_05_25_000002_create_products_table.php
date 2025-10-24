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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('details')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('status')->default('available'); // available, sold, reserved
            $table->boolean('is_featured')->default(false);
            $table->json('features')->nullable(); // For storing game level, weapon count, etc
            $table->string('type')->default('account'); // account, digital_card
            $table->string('warranty_days')->nullable();
            $table->string('main_image')->nullable();
            $table->json('gallery')->nullable();
            $table->float('rating', 3, 1)->nullable();
            $table->integer('sales_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}; 