<?php

namespace App\Jobs;
use App\Http\Controllers\MsController;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Vehicle\Models\VehicleTripSummary;
use App\Http\Traits\LocationTrait;
use Illuminate\Support\Facades\Log;
use App\Modules\Client\Models\OnDemandTripReportRequests;
use PDF;
use Carbon\Carbon AS Carbon;
class ProcessGeneralTripJob extends Job
{
      /**
     * 
     * 
     */
     use LocationTrait;

    protected $pending_trip;
    protected $source_table;
    protected $id;
    protected $on_demand_request_id;
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
        $this->trip_date                =   $this->pending_trip['trip_report_date'];
        $removed_alphanumeric_from_date =   preg_replace( '/[\W]/', '',$this->trip_date);
        $source_table                   =   'gps_data_'.$removed_alphanumeric_from_date;
        $id                             =   $this->pending_trip['vehicle_id'];
        $on_demand_request_id           =   $this->pending_trip['id'];
        $vehicle = Vehicle::find($id);

        if(!$vehicle)
        {
            echo "vehicle not found"."\n";
            exit;
        }else{
            $this->processTripsofVehicle($vehicle->gps,$on_demand_request_id,$source_table);
            echo "processing completed !!"."\n";
        }
    }
    /**
     * 
     *process trip of vehicle
     * 
     */
    public function processTripsofVehicle($gps,$on_demand_request_id,$source_table)
    {
        $source_table_gps= new GpsData;
        $vehicle_records = $source_table_gps->fetchDateWiseRecordsOfVehicleDevice($gps->imei,$source_table);
        $geo_locations   = [];
        $trips           = [];
        $total_distance  = 0;
        $summary         = [];
        $pending_trip    =   (new OnDemandTripReportRequests())->getSinglePendingReport($on_demand_request_id); 
        $pending_trip->is_job_failed = 1;
        $pending_trip->save();
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
                // based on map variable we can get address from LocationTrait
                $map ="heremap";
                $trip = [ 
                            'start_address' => $this->getPlacenameFromGeoCords($start_lat,$start_lng,$map),
                            'start_time'    => $start_time,
                            'stop_address'  => $this->getPlacenameFromGeoCords($stop_lat,$stop_lng,$map),
                            'stop_time'     => $stop_time,
                            'duration'      => dateTimediff($start_time, $stop_time),
                            'distance'      => $distance
                        ];

                $trips[] = $trip;
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
          
            $this->generatePdfReport($trips, $summary, $gps,$on_demand_request_id);
            // update daily km calculation of vehicle based on new calculation 
            (new DailyKm)->updateDailyKm($total_distance, $gps->id, $this->trip_date);
        }else
        {
            $pending_trip =   (new OnDemandTripReportRequests())->getSinglePendingReport($on_demand_request_id); 
            $current_date =   Carbon::now()->format('Y-m-d H:i:s');
            $pending_trip->job_completed_on=$current_date;
            $pending_trip->is_job_failed = 0;
            $pending_trip->save();
        }

    }
    /**
     * 
     *get distance of trip
     * 
     */
    public function getDistanceOfTrip($geo_locations, $trip_id, $client_id, $vehicle_id)
    {
        $trip = tripDistanceFromHereMap($geo_locations);

        //save gpx file lo trip reports folder 
        //directory client id => vehicle id => trip date => trips

        if (!file_exists("public/documents/tripreports/".$client_id."/".$vehicle_id."/".$this->trip_date."/trips/")) {
            mkdir("public/documents/tripreports/".$client_id."/".$vehicle_id."/".$this->trip_date."/trips/", 0777, true);
        }
        $path      = "public/documents/tripreports/".$client_id."/".$vehicle_id."/".$this->trip_date."/trips/".$trip_id.".gpx";
        $trip_file = fopen($path, "w");
        fwrite($trip_file, $trip['gpx']);
        fclose($trip_file);
        return $trip['distance'];

    }

    /**
     * 
     * generate pdf report
     * 
     */
    public function generatePdfReport($trips, $summary, $gps,$on_demand_request_id)
    {
        $client_id  = $gps->vehicle->client->id;
        $vehicle_id = $gps->vehicle->id;
        $file_name  = $gps->imei.'-'.$this->trip_date.'.pdf';
        $pdf        = PDF::loadView('Exports::trip-report', ['trips' => $trips, 'date' => $this->trip_date, 'summary' => $summary, 'gps' => $gps]);
        $file       = "documents/tripreports/".$client_id."/".$vehicle_id."/".$this->trip_date."/".$file_name;
        $pdf->save("public/".$file);
       
        if (file_exists("public/documents/tripreports/".$client_id."/".$vehicle_id."/".$this->trip_date."/".$file_name)) {
            $pending_trip = (new OnDemandTripReportRequests())->getSinglePendingReport($on_demand_request_id); 
            $pending_trip->download_link = $file;
            $current_date =  Carbon::now()->format('Y-m-d H:i:s');
            $pending_trip->job_completed_on = $current_date;
            $pending_trip->is_job_failed = 0;
            $pending_trip->save();
        }else{
            $pending_trip =   (new OnDemandTripReportRequests())->getSinglePendingReport($on_demand_request_id); 
            $current_date =   Carbon::now()->format('Y-m-d H:i:s');
            $pending_trip->job_completed_on = $current_date;
            $pending_trip->save();
            
        }
        (new VehicleTripSummary)->addNewReport($client_id, $vehicle_id, $file, $summary["km"], $this->trip_date);
    }
}
