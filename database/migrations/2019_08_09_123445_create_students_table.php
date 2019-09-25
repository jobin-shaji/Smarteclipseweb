<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->integer('gender')->comment = '1-male,1-female,3-other';
            $table->integer('class_id');
            $table->integer('division_id');
            $table->string('parent_name');
            $table->text('address');
            $table->bigInteger('mobile');
            $table->string('email');
            $table->integer('route_batch_id');
            $table->string('nfc');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('password');
            $table->integer('client_id');
            $table->string('path');
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
        Schema::dropIfExists('students');
    }
}
