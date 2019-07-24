<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imei');
            $table->date('manufacturing_date');
            $table->string('brand');
            $table->string('model_name');
            $table->string('version');
            $table->integer('user_id')->nullable();
            $table->integer('status')->comment = '0-inactive,1-active';
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
        Schema::dropIfExists('sos');
    }
}
