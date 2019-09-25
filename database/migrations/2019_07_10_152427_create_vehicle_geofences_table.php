<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleGeofencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_geofences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vehicle_id');
            $table->integer('geofence_id');
            $table->dateTime('date_from')->nullable();
            $table->dateTime('date_to')->nullable();
            $table->integer('status');
            $table->integer('client_id');
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
        Schema::dropIfExists('vehicle_geofences');
    }
}
