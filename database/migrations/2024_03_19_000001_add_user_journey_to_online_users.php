<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('online_users', function (Blueprint $table) {
            if (!Schema::hasColumn('online_users', 'user_journey')) {
                $table->json('user_journey')->nullable()->after('page_url');
            }
        });
    }

    public function down()
    {
        Schema::table('online_users', function (Blueprint $table) {
            if (Schema::hasColumn('online_users', 'user_journey')) {
                $table->dropColumn('user_journey');
            }
        });
    }
}; 