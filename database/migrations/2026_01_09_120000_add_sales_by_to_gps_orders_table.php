<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalesByToGpsOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('gps_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_by')
                  ->nullable()
                  ->after('message');
        });
    }

    public function down()
    {
        Schema::table('gps_orders', function (Blueprint $table) {
            $table->dropColumn('sales_by');
        });
    }
}
