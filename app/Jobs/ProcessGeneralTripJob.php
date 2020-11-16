<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessGeneralTripJob implements ShouldQueue
{
    use  InteractsWithQueue, Queueable, SerializesModels;

    /** 
     * variables
     */
    public $pendingTrip;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pendingTrip)
    {
        dd($pendingTrip);
        $this->pendingtrips    = $pendingTrip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
     dd($this->pendingtrips);
        
    }
}
