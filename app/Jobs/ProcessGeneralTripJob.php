<?php

namespace App\Jobs;
use App\Http\Controllers\GeneralController;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Vehicle\Models\VehicleTripSummary;
use App\Http\Traits\LocationTrait;
use Illuminate\Support\Facades\Log;
use App\Modules\Client\Models\OnDemandTripReportRequests;
use PDF;
use Carbon\Carbon AS Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
 class ProcessGeneralTripJob extends Job
{
      /**
     * 
     * 
     */
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, LocationTrait;
    protected $pending_trip;
    protected $source_table;
    protected $id;
    protected $on_demand_request_id;
    protected $pending_trip_array;
    /**
    * The number of times the job may be attempted.
    *
    * @var int
    */

     public $tries = 1;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pending_trip)
    {
        $this->pending_trip = $pending_trip;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("handles");
        Log::info($this->pending_trip);
        (new GeneralController())->processGeneralTrip($this->pending_trip);
        return;
    
    }
}