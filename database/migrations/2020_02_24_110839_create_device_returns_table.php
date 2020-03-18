<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('return_code',30);
            $table->integer('gps_id');
            $table->integer('servicer_id');
            $table->integer('client_id');
            $table->integer('type_of_issues')->comment = '0-hardware,1-software';
            $table->integer('status')->comment = '0-submit,1-cancel,2-accept';
            $table->text('comments');
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
        Schema::dropIfExists('device_returns');
    }
}
