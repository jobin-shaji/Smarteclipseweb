<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imei');
            $table->date('manufacturing_date');
            $table->bigInteger('e_sim_number');
            $table->string('brand');
            $table->string('model_name');
            $table->string('version');
            $table->integer('user_id')->nullable();
            $table->integer('status')->comment = '0-inactive,1-active';
            $table->string('mode')->nullable();
            $table->string('lat')->nullable();
            $table->string('lat_dir')->nullable();
            $table->string('lon')->nullable();
            $table->string('lon_dir')->nullable();
            $table->integer('network_status')->nullable();
            $table->integer('fuel_status')->nullable();
            $table->string('speed')->nullable();
            $table->string('odometer')->nullable();
            $table->integer('satllite')->nullable();
            $table->string('battery_status')->nullable();
            $table->string('heading')->nullable();
            $table->dateTime('device_time');
            $table->string('main_power_status')->nullable();
            $table->string('ignition')->nullable();            
            $table->integer('gsm_signal_strength')->nullable();
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
        Schema::dropIfExists('gps');
    }
}
