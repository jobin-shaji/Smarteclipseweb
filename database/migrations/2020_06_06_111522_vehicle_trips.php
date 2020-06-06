<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VehicleTrips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_trip_summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('vehicle_id');
            $table->string('report_url');
            $table->integer('distance');
            $table->date('trip_date');
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
        Schema::dropIfExists('vehicle_trip_summaries');
    }
}
