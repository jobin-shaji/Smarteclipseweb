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
            $table->string('name');
            $table->string('imei');
            $table->date('manufacturing_date');
            $table->string('brand');
            $table->string('model_name');
            $table->string('version');
            $table->integer('user_id')->nullable();
            $table->integer('status');
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
