<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGpsStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gps_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gps_id');
            $table->integer('inserted_by');
            $table->integer('dealer_id')->nullable();
            $table->integer('subdealer_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gps_stocks');
    }
}
