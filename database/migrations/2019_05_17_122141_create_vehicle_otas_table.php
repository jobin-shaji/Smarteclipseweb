<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleOtasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_otas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('vehicle_id');
            $table->string('PU')->nullable();
            $table->string('EU')->nullable();
            $table->bigInteger('EM')->nullable();
            $table->integer('EO')->nullable();
            $table->integer('ED')->nullable();
            $table->string('APN')->nullable();
            $table->integer('ST')->nullable();
            $table->integer('SL')->nullable();
            $table->integer('HBT')->nullable();
            $table->integer('HAT')->nullable();
            $table->integer('RTT')->nullable();
            $table->integer('LBT')->nullable();
            $table->string('VN')->nullable();
            $table->integer('UR')->nullable();
            $table->integer('URS')->nullable();
            $table->integer('URE')->nullable();
            $table->integer('URF')->nullable();
            $table->integer('URH')->nullable();
            $table->string('VID')->nullable();
            $table->integer('FV')->nullable();
            $table->integer('DSL')->nullable();
            $table->integer('HT')->nullable();
            $table->bigInteger('M1')->nullable();
            $table->bigInteger('M2')->nullable();
            $table->bigInteger('M3')->nullable();
            $table->integer('GF')->nullable();
            $table->bigInteger('OM')->nullable();
            $table->string('OU')->nullable();
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
        Schema::dropIfExists('vehicle_otas');
    }
}
