<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Client\Models\OnDemandTripReportRequests;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Vehicle\Models\VehicleTripSummary;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessGeneralTripJob;
use Queue;
use PDF;
use \DB;

class GeneralDemandTrips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'General:DemandTrips';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trip generation for on demand vehicles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pending_trips         =   (new OnDemandTripReportRequests())->getPendingReportRequests(); 
        foreach ($pending_trips as $pending_trip) 
        {
        $trip_report_date               =   $pending_trip['trip_report_date']; 
        $id                             =   $pending_trip['vehicle_id'];
        $on_demand_request_id           =   $pending_trip['id'];
        $pending_trip->job_attended_on  =   date('Y-m-d');
        $pending_trip->save();
        Queue::push(new ProcessGeneralTripJob($trip_report_date,$id,$on_demand_request_id));
       
    }
       
    }
    
}
