<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporaryCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->longtext('details');
            $table->tinyint('is_active');
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
        Schema::dropIfExists('temporary_certificates');
    }
}
