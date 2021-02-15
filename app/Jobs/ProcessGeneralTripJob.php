<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\Log;

class ProcessGeneralTripJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 
     * variables
     */

    public $trip_report_date;
    /**
     * 
     * 
     */
    public $vehicle_id;
    /**
     * 
     * 
     */
    public $on_demand_request_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($trip_report_date,$vehicle_id,$on_demand_request_id)
    {
        $this->trip_report_date     = $trip_report_date;
        $this->vehicle_id           = $vehicle_id;
        $this->on_demand_request_id = $on_demand_request_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new GeneralController())->processGeneralTrip($this->trip_report_date,$this->vehicle_id,$this->on_demand_request_id);
         return;
    }
}
