<?php

namespace App\Console\Commands;
use \Carbon\Carbon;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Vehicle\Models\VehicleTripSummary;
use PDF;
use \DB;

use Illuminate\Console\Command;

class VehicleTrips extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicle:trips';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'trip generation for all vehicles';

    /**
     * Trip date 
     *
     * @var date 
     */
    protected $trip_date;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->trip_date = date('Y-m-d',strtotime("-1 days"));
    }

    public function handle()
    {
        $vehicles = Vehicle::select('id','gps_id','client_id')->get();

        foreach ($vehicles as $vehicle) 
        {
            if($vehicle->gps)
            {               
                try 
                {
                    $this->processTripsofVehicle($vehicle->gps);
                } 
                catch (Exception $e) 
                {
                    report($e);
                    continue;     
                } 
            }
        }
    }

    /**
     * 
     *
     * 
     */
    public function processTripsofVehicle($gps)
    {
        $source_table    = new GpsData;
        $vehicle_records = $source_table->fetchYesterdaysRecordsOfVehicleDevice($gps->imei);
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
                            'start_address' => getPlacenameFromLatLng($start_lat, $start_lng),
                            'start_time'    => $start_time,
                            'stop_address'  => getPlacenameFromLatLng($stop_lat, $stop_lng),
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
            $summary["off location"] = $trips[0]["stop_address"];
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

     /**
     * 
     *
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

        $path = "public/documents/tripreports/".$client_id."/".$vehicle_id."/".$this->trip_date."/trips/".$trip_id.".gpx";
        $trip_file = fopen($path, "w");
        fwrite($trip_file, $trip['gpx']);
        fclose($trip_file);
        
        return $trip['distance'];

    }

    /**
     * 
     *
     * 
     */
    public function generatePdfReport($trips, $summary, $gps)
    {

        $client_id  = $gps->vehicle->client->id;
        $vehicle_id = $gps->vehicle->id;
        view()->share(['trips' => $trips, 'date' => $this->trip_date, 'summary' => $summary, 'gps' => $gps]);
        $file_name = $gps->imei.'-'.$this->trip_date.'.pdf';
        $pdf       = PDF::loadView('Exports::trip-report');
        $file = "public/documents/tripreports/".$client_id."/".$vehicle_id."/".$this->trip_date."/".$file_name;
        $pdf->save($file);

        (new VehicleTripSummary)->addNewReport($client_id, $vehicle_id, $file, $summary["km"], $this->trip_date);
    }

}

