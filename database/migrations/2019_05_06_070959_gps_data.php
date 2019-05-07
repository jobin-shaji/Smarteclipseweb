<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GpsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('gps_data', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('client_id')->nullable();
            $table->integer('gps_id')->nullable();
            $table->integer('vehicle_id')->nullable();
            $table->string('header')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string('firmware_version')->nullable();
            $table->bigInteger('imei')->nullable();
            $table->integer('update_rate_ignition_on')->nullable();
            $table->integer('update_rate_ignition_off')->nullable();
            $table->integer('battery_percentage')->nullable();
            $table->integer('low_battery_threshold_value')->nullable();
            $table->integer('memory_percentage')->nullable();
            $table->integer('digital_io_status')->nullable();
            $table->string('analog_io_status')->nullable();
            $table->bigInteger('activation_key')->nullable();
            $table->float('latitude')->nullable();
            $table->char('lat_dir')->nullable();
            $table->float('longitude')->nullable();
            $table->char('lon_dir')->nullable();
            $table->integer('date')->nullable();
            $table->integer('time')->nullable();
            $table->float('speed')->nullable();
            $table->integer('alert_id')->nullable();
            $table->char('packet_status')->nullable();
            $table->integer('gps_fix')->nullable();
            $table->integer('mcc')->nullable();
            $table->integer('mnc')->nullable();
            $table->string('lac')->nullable();
            $table->string('cell_id')->nullable();
            $table->float('heading')->nullable();
            $table->integer('no_of_satelites')->nullable();
            $table->integer('hdop')->nullable();
            $table->integer('gsm_signal_strength')->nullable();
            $table->integer('ignition')->nullable();
            $table->integer('main_power_status')->nullable();
            $table->integer('vehicle_mode')->nullable();
            $table->float('altitude')->nullable();
            $table->integer('pdop')->nullable();
            $table->string('nw_op_name')->nullable();
            $table->integer('nmr')->nullable();
            $table->float('main_input_voltage')->nullable();
            $table->float('internal_battery_voltage')->nullable();
            $table->char('tamper_alert')->nullable();
            $table->integer('digital_input_status')->nullable();
            $table->integer('digital_output_status')->nullable();
            $table->integer('frame_number')->nullable();
            $table->integer('checksum')->nullable();
            $table->string('key1')->nullable();
            $table->string('value1')->nullable();
            $table->string('key2')->nullable();
            $table->string('value2')->nullable();
            $table->string('key3')->nullable();
            $table->string('value3')->nullable();
            $table->integer('gf_id')->nullable();

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
        Schema::dropIfExists('gps_data');
    }
}
