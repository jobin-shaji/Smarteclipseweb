<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('register_number');
            $table->tinyInteger('vehicle_type_id');
            $table->integer('client_id');
            $table->integer('gps_id');
            $table->tinyInteger('status');
            $table->integer('driver_id')->nullable();
            $table->integer('servicer_job_id')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('chassis_number')->nullable();
            $table->integer('theft_mode')->default(0);
            $table->integer('emergency_status');
            $table->integer('towing')->default(0);
            $table->integer('is_returned')->nullable()->comment = '0,null-not returned,1-returned';
            $table->integer('is_reinstallation_job_created')->nullable()->comment = '0-not created,1-reinstallation job created';
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
        Schema::dropIfExists('vehicles');
    }
}
