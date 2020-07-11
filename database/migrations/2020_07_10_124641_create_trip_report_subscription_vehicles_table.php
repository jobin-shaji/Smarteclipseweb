<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripReportSubscriptionVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_report_subscription_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_trip_report_subscription_id');
            $table->integer('vehicle_id');
            $table->date('attached_on');
            $table->date('detached_on');
            $table->date('expired_on');
            $table->date('report_last_generated_on');
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
        Schema::dropIfExists('trip_report_subscription_vehicles');
    }
}
