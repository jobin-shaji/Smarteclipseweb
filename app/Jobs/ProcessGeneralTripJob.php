<?php

namespace App\Jobs;
use App\Http\Controllers\MsController;

class ProcessGeneralTripJob extends Job
{
    
    protected $pending_trip;


    /**
    * The number of times the job may be attempted.
    *
    * @var int
    */

    public $tries = 3;


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
         dd( $this->pending_trip);
    }
}
