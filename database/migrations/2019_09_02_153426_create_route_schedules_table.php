<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouteSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('route_batch_id');
            $table->integer('route_id');
            $table->integer('vehicle_id');
            $table->integer('driver_id');
            $table->integer('helper_id');
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
        Schema::dropIfExists('route_schedules');
    }
}
