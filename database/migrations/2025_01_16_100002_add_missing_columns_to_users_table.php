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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'store_id')) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'client_to_store')) {
                $table->unsignedBigInteger('client_to_store')->nullable()->after('store_id');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('avatar');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('role');
            }
            if (!Schema::hasColumn('users', 'vip')) {
                $table->boolean('vip')->default(false)->after('is_active');
            }
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('vip');
            }
            if (!Schema::hasColumn('users', 'balance')) {
                $table->decimal('balance', 10, 2)->default(0)->after('last_login_at');
            }
            if (!Schema::hasColumn('users', 'orders_count')) {
                $table->integer('orders_count')->default(0)->after('balance');
            }
            if (!Schema::hasColumn('users', 'active_theme')) {
                $table->string('active_theme')->nullable()->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'custom_domain')) {
                $table->string('custom_domain')->nullable()->after('active_theme');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'store_id', 'client_to_store', 'phone', 'avatar', 'role', 'is_active',
                'vip', 'last_login_at', 'balance', 'orders_count', 'active_theme', 'custom_domain'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}; 