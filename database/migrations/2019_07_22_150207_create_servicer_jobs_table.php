<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicerJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicer_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('servicer_id');
            $table->integer('client_id');
            $table->integer('job_id');
            $table->integer('job_type');
            $table->integer('user_id');
            $table->text('description');
            $table->dateTime('job_date');
            $table->dateTime('job_complete_date');
            $table->integer('status');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('servicer_jobs');
    }
}
