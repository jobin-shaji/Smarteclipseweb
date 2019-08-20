<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGpsTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gps_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_user_id');
            $table->integer('to_user_id');
            $table->string('order_number');
            $table->string('scanned_employee_code');
            $table->string('invoice_number');
            $table->dateTime('dispatched_on');
            $table->dateTime('accepted_on')->nullable();
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
        Schema::dropIfExists('gps_transfers');
    }
}
