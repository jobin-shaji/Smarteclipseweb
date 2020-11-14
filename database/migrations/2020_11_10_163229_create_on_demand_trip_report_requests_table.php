<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnDemandTripReportRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('on_demand_trip_report_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('vehicle_id');
            $table->integer('gps_id');
            $table->date('trip_report_date');
            $table->date('job_submitted_on');
            $table->date('job_attended_on')->nullable();
            $table->date('job_completed_on')->nullable();
            $table->text('job_remarks')->nullable();
            $table->integer('is_job_failed')->default(0)->comment = '0-not a Failed Job,1-Failed Job';;
            $table->string('report_type')->nullable();
            $table->text('download_link');
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
        Schema::dropIfExists('on_demand_trip_report_requests');
    }
}
