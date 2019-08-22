<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticket_id');
            $table->integer('gps_id');
            $table->integer('complaint_type_id');
            $table->text('description');
            $table->integer('client_id');
            $table->integer('status')->comment = '0-inactive,1-assigned,2-completed';
            $table->integer('servicer_id');
            $table->integer('assigned_by');
            $table->text('servicer_comment');
            $table->date('closed_on')->nullable();             
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
        Schema::dropIfExists('complaints');
    }
}
