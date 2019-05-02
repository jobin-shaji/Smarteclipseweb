<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGpsTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gps_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gps_id');
            $table->integer('from_user_id')->nullable();
            $table->integer('to_user_id');
            $table->dateTime('transfer_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gps_transfers');
    }
}
