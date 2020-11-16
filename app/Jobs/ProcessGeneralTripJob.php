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
        echo "$pending_trip";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $this->trip_date                =   $this->pending_trip['trip_report_date'];
        $removed_alphanumeric_from_date =   preg_replace( '/[\W]/', '', $trip_date);
        $this->$source_table            =   'gps_data_'.$removed_alphanumeric_from_date;
        $id                             =   $this->pending_trip['vehicle_id'];
        $on_demand_request_id           =   $this->pending_trip['id'];
        $vehicle = Vehicle::find($id);

        if(!$vehicle)
        {
            echo "vehicle not found"."\n";
            exit;
        }else{
            $this->processTripsofVehicle($vehicle->gps,$on_demand_request_id);
        }
          

        
    }
      /**
     * 
     *
     * 
     */
    public function processTripsofVehicle($gps,$on_demand_request_id)
    {
        $source_table    = new GpsData;
        $vehicle_records = $source_table->fetchDateWiseRecordsOfVehicleDevice($gps->imei, $this->source_table);
        $geo_locations   = [];
        $trips           = [];
        $total_distance  = 0;
        $summary         = [];

        foreach ($vehicle_records as $item) 
        {
            if($item->vehicle_mode == 'M')
            {    
               $node =  [ 'lattitude' => $item->latitude, 'longitude' => $item->longitude, 'device_time' => $item->device_time];
               $geo_locations[] = $node;
            }
            if(sizeof($geo_locations) > 0 && $item->vehicle_mode != 'M')
            {
                $start_lat  = $geo_locations[0]['lattitude'];
                $start_lng  = $geo_locations[0]['longitude'];
                $start_time = $geo_locations[0]['device_time'];
                $end        = end($geo_locations);
                $stop_lat   = $end['lattitude'];
                $stop_lng   = $end['longitude'];
                $stop_time  = $end['device_time'];

                $result = $this->getDistanceOfTrip($geo_locations, (count($trips)+1), $gps->vehicle->client->id, $gps->vehicle->id);
                $distance = m2Km($result);

                $total_distance = $total_distance + $result;
                $trip = [ 
                            'start_address' => $this->getPlacenameFromGeoCords($start_lat, $start_lng),
                            'start_time'    => $start_time,
                            'stop_address'  => $this->getPlacenameFromGeoCords($stop_lat, $stop_lng),
                            'stop_time'     => $stop_time,
                            'duration'      => dateTimediff($start_time, $stop_time),
                            'distance'      => $distance
                        ];

                $trips[]      = $trip;
                $geo_locations = [];
            }
        }

        if($trips)
        {
            $summary["on location"]  = $trips[0]["start_address"];
            $summary["on"]           = $trips[0]["start_time"];
            $end                     = end($trips);
            $summary["off location"] = $end["stop_address"];
            $summary["off"]          = $end["stop_time"];
            $summary["date"]         = $this->trip_date;
            $summary["km"]           = m2Km($total_distance);
            $summary["duration"]     = dateTimediff($summary["on"], $summary["off"]);
            // generate pdf report of vehicle 
            $this->generatePdfReport($trips, $summary, $gps);
            // update daily km calculation of vehicle based on new calculation 
            (new DailyKm)->updateDailyKm($total_distance, $gps->id, $this->trip_date);
        }

    }
}
