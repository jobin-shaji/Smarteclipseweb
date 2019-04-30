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
            $table->string('version');
            $table->integer('dealer_user_id')->nullable();
            $table->integer('sub_dealer_user_id')->nullable();
            $table->integer('client_user_id')->nullable();
            $table->integer('vehicle_id')->nullable();
            $table->integer('status');
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
