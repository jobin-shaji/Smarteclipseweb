<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GpsModeChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('gps_mode_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gps_id');
            $table->string('lat');
            $table->string('lng');
            $table->text('mode');
            $table->dateTime('device_time');
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
        Schema::dropIfExists('gps_mode_changes');
    }
}
