<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Client\Models\OnDemandTripReportRequests;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Vehicle\Models\VehicleTripSummary;
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
    protected $description = 'Trip generation for unsubscribed vehicles';

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
        // $pending_trip          = (array) $pending_trips;
        $current_date          =    date('Y-m-d');
        foreach ($pending_trips as $pending_trip) 
        {
            
        $pending_trip->job_attended_on = $current_date;
        $pending_trip->save();
          
        
          
         Queue::push(new ProcessGeneralTripJob($pending_trip));
    
        }
        
       
    }
    
}
