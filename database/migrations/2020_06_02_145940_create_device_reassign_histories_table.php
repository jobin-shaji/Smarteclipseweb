<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceReassignHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_reassign_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gps_id');
            $table->string('imei');
            $table->integer('reassign_type_id');
            $table->integer('reassign_from');
            $table->integer('reassign_to');
            $table->dateTime('reassigned_on');
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
        Schema::dropIfExists('device_reassign_histories');
    }
}
