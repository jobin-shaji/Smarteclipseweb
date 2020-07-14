<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTripReportSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_trip_report_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->text('subscription_id');
            $table->text('configuration');
            $table->integer('number_of_vehicles');
            $table->integer('number_of_reports_generated');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('client_trip_report_subscriptions');
    }
}
