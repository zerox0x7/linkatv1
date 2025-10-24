<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToDigitalCardCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('digital_card_codes', function (Blueprint $table) {
            // إضافة قيد فريد على order_id و code
            $table->unique(['order_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('digital_card_codes', function (Blueprint $table) {
            // إزالة القيد الفريد
            $table->dropUnique(['order_id', 'code']);
        });
    }
}
