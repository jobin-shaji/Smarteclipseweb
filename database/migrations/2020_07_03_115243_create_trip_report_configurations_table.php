<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripReportConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_report_configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_id');
            $table->integer('number_of_report_per_month');
            $table->integer('backup_days');
            $table->integer('free_vehicle');
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
        Schema::dropIfExists('trip_report_configurations');
    }
}
