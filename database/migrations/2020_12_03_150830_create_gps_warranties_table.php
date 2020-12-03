<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGpsWarrantiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gps_warranties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gps_id');
            $table->date('period_from');
            $table->date('period_to');
            $table->date('expired_on')->nullable();
            $table->text('expired_reason')->nullable();
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
        Schema::dropIfExists('gps_warranties');
    }
}
