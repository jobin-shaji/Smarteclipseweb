<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubDealersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_dealers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('dealer_id');
             $table->string('name');
            $table->string('address');
            $table->string('phone_number');
            $table->string('email');
            $table->integer('status');            
             $table->string('created_by');
              $table->integer('deleted_by')->nullable();
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
        Schema::dropIfExists('sub_dealers');
    }
}
