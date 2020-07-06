<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimActivationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sim_activation_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imei',15);
            $table->integer('gps_id');
            $table->string('msisdn')->nullable();
            $table->string('iccid')->nullable();
            $table->string('imsi')->nullable();
            $table->string('puk')->nullable();
            $table->string('product_type')->nullable();
            $table->date('activated_on')->nullable();
            $table->date('expire_on')->nullable();
            $table->string('business_unit_name')->nullable();
            $table->string('product_status')->nullable();
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
        Schema::dropIfExists('sim_activation_details');
    }
}
