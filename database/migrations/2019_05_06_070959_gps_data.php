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
            $table->integer('gps_id')->nullable();
            $table->string('header')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string('firmware_version')->nullable();
            $table->bigInteger('imei')->nullable();
            $table->char('update_rate_ignition_on',3)->nullable();
            $table->char('update_rate_ignition_off',3)->nullable();
            $table->string('battery_percentage')->nullable();
            $table->string('low_battery_threshold_value')->nullable();
            $table->string('memory_percentage')->nullable();
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
            $table->text('response')->nullable();
            $table->string('gf_id')->nullable();
            $table->string('packet_type')->nullable();
            $table->string('packet_version')->nullable();
            $table->string('emergency_status')->nullable();
            $table->string('message_type')->nullable();
            $table->string('gps_validity')->nullable();
            $table->string('distance')->nullable();
            $table->string('provider')->nullable();
            $table->integer('reply_number')->nullable();
            $table->string('crc')->nullable();
            $table->text('vlt_data')->nullable();
            $table->dateTime('device_time')->nullable();

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
