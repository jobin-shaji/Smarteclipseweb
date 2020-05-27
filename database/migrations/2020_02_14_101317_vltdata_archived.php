<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VltdataArchived extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('vltdata_archived', function (Blueprint $table) {
            $table->increments('id');
            $table->string('header');
            $table->string('imei');
            $table->text('vltdata');
            $table->integer('is_processed');
            $table->integer('is_login');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vltdata_archived');
    }
}
