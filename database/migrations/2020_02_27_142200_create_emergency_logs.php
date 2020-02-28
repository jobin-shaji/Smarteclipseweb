<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gps_id');
            $table->string('lat');
            $table->string('lng');
            $table->integer('alert_type_id');
            $table->dateTime('device_time');
            $table->integer('verified_by')->nullable();
            $table->dateTime('verified_at')->nullable();
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
        Schema::dropIfExists('emergency_logs');
    }
}
