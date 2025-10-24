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
        Schema::table('coupons', function (Blueprint $table) {
            // Additional coupon fields for enhanced functionality
            $table->string('name')->nullable()->after('code'); // Coupon display name
            $table->text('description')->nullable()->after('name'); // Coupon description
            $table->decimal('max_discount_amount', 10, 2)->nullable()->after('value'); // Maximum discount cap for percentage coupons
            $table->integer('usage_limit_per_user')->nullable()->after('max_uses'); // Limit per individual user
            $table->boolean('auto_apply')->default(false)->after('is_active'); // Auto-apply coupon
            $table->boolean('stackable')->default(false)->after('auto_apply'); // Can be combined with other coupons
            $table->boolean('show_on_homepage')->default(false)->after('stackable'); // Display on homepage
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('show_on_homepage'); // Coupon priority
            $table->boolean('email_notifications')->default(true)->after('priority'); // Send email notifications
            $table->json('user_restrictions')->nullable()->after('email_notifications'); // User group restrictions
            $table->timestamp('last_used_at')->nullable()->after('used_times'); // Last usage timestamp
            $table->string('created_by')->nullable()->after('store_id'); // Who created the coupon
            $table->string('updated_by')->nullable()->after('created_by'); // Who last updated the coupon
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'description', 
                'max_discount_amount',
                'usage_limit_per_user',
                'auto_apply',
                'stackable',
                'show_on_homepage',
                'priority',
                'email_notifications',
                'user_restrictions',
                'last_used_at',
                'created_by',
                'updated_by'
            ]);
        });
    }
};
