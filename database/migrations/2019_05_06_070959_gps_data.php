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
            $table->char('update_rate_ignition_on',3)->nullable();
            $table->char('update_rate_ignition_off',3)->nullable();
            $table->char('battery_percentage',3)->nullable();
            $table->char('low_battery_threshold_value',3)->nullable();
            $table->char('memory_percentage',3)->nullable();
            $table->string('digital_io_status')->nullable();
            $table->string('analog_io_status')->nullable();
            $table->bigInteger('activation_key')->nullable();
            $table->string('latitude')->nullable();
            $table->char('lat_dir')->nullable();
            $table->string('longitude')->nullable();
            $table->char('lon_dir')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('speed')->nullable();
            $table->char('alert_id',2)->nullable();
            $table->char('packet_status')->nullable();
            $table->integer('gps_fix')->nullable();
            $table->char('mcc',3)->nullable();
            $table->char('mnc',3)->nullable();
            $table->string('lac')->nullable();
            $table->string('cell_id')->nullable();
            $table->string('heading')->nullable();
            $table->char('no_of_satelites',2)->nullable();
            $table->char('hdop',2)->nullable();
            $table->char('gsm_signal_strength',2)->nullable();
            $table->integer('ignition')->nullable();
            $table->integer('main_power_status')->nullable();
            $table->char('vehicle_mode',1)->nullable();
            $table->string('altitude')->nullable();
            $table->char('pdop',2)->nullable();
            $table->string('nw_op_name')->nullable();
            $table->text('nmr')->nullable();
            $table->string('main_input_voltage')->nullable();
            $table->string('internal_battery_voltage')->nullable();
            $table->char('tamper_alert')->nullable();
            $table->char('digital_input_status',4)->nullable();
            $table->char('digital_output_status',2)->nullable();
            $table->string('vehicle_register_num')->nullable();
            $table->string('frame_number')->nullable();
            $table->string('checksum')->nullable();
            $table->string('key1')->nullable();
            $table->string('value1')->nullable();
            $table->string('key2')->nullable();
            $table->string('value2')->nullable();
            $table->string('key3')->nullable();
            $table->string('value3')->nullable();
            $table->string('gf_id')->nullable();
            $table->text('vlt_data')->nullable();

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
