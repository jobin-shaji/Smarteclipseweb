<?php

namespace App\Jobs;
use App\Http\Controllers\GeneralController;
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
    public $trip_report_date;
    public $id;
    public $on_demand_request_id;
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
    public function __construct($trip_report_date,$id,$on_demand_request_id)
    {
        $this->trip_report_date = $trip_report_date;
        $this->id               = $id;
        $this->on_demand_request_id = $on_demand_request_id;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
        (new GeneralController())->processGeneralTrip($this->trip_report_date,$this->id, $this->on_demand_request_id);
        return;
    
    }
}