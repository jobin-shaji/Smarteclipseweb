<?php

namespace App\Console\Commands;
use \Carbon\Carbon;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsData;
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $vehicles = Vehicle::all();

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


    public function processTripsofVehicle($gps)
    {
        $source_table    = new GpsData;
        $vehicle_records = $source_table->fetchYesterdaysRecordsOfVehicleDevice($gps->imei);
        $geo_locations   = [];
        $trips           = [];
        $total_distance  = 0;
        $summary         = [];
        $date            = date('Ymd',strtotime("-1 days"));

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

                $result = $this->getDistanceOfTrip($geo_locations, count($trips), $gps->imei, $date);
                $distance = m2Km($result);

                $total_distance = $total_distance + $result;
                $trip = [ 
                            'start_address' => getPlacenameFromLatLng($start_lat, $start_lng),
                            'start_time'    => $start_time,
                            'stop_address'  => getPlacenameFromLatLng($stop_lat, $stop_lng),
                            'stop_time'     => $stop_time,
                            'duration'      => $this->dateTimediff($start_time, $stop_time),
                            'distance'      => $distance
                        ];

                $trips[]      = $trip;
                $geo_locations = [];

            }

        }

        if($trips)
        {
            $summary["on location"] = $trips[0]["start_address"];
            $summary["on"] = $trips[0]["start_time"];
            $end = end($trips);
            $summary["off location"] = $trips[0]["stop_address"];
            $summary["off"] = $end["stop_time"];
            $summary["date"] = $date;
            $summary["km"] = m2Km($total_distance);
            $summary["duration"] = $this->dateTimediff($summary["on"], $summary["off"]);

            $this->generatePdfReport($trips, $summary, $gps);

        }

    }


    public function generatePdfReport($trips, $summary, $gps)
    {
        $date = date('Ymd',strtotime("-1 days"));

        view()->share(['trips' => $trips, 'date' => $date, 'summary' => $summary, 'gps' => $gps]);

        $file_name = $gps->imei.'-'.$date.'.pdf';

        $pdf = PDF::loadView('Exports::trip-report');

        $pdf->save("public/documents/tripreports/".$gps->imei."/".$date."/".$file_name);
        
    }


    public function getDistanceOfTrip($geo_locations, $count, $imei, $date)
    {

        $xml = '<?xml version="1.0"?>
                <gpx version="1.0"
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xmlns="http://www.topografix.com/GPX/1/0"
                xsi:schemaLocation="http://www.topografix.com/GPX/1/0 http://www.topografix.com/GPX/1/0/gpx.xsd">
                <trk>
                <trkseg>';

        foreach($geo_locations as $each_geo_location)
        {
            $xml .= '<trkpt lat="'.$each_geo_location['lattitude'].'" lon="'.$each_geo_location['longitude'].'"/>';
        }
         
        $xml .= '</trkseg>
         </trk>
        </gpx>';

        $client     = new \GuzzleHttp\Client(['base_uri' => 'https://m.fleet.ls.hereapi.com/']);

        try
        {
            $resp       = $client->request('POST', "2/calculateroute.json?apiKey=yHvLiXMvNW-Mvmp8whDmDfQCP0gS9KdQBZojr5u6igo&routeMatch=1&mode=fastest;car;traffic:disabled", ['body' => $xml]);
        
            $points     = (string) $resp->getBody();
            $points     = json_decode($points, true);
            $distance = $points['response']['route'][0]['summary']['distance'];
        }
        catch(Exception $e)
        {
            $e->getMessage();
        }

        $count = $count+1;

        if (!file_exists("public/documents/tripreports/".$imei."/".$date."/trips/")) {
            mkdir("public/documents/tripreports/".$imei."/".$date."/trips/", 0777, true);
        }

        $path = "public/documents/tripreports/".$imei."/".$date."/trips/".$count.".gpx";

        $trip_file = fopen($path, "w");

        fwrite($trip_file, $xml);

        fclose($trip_file);
        
        return $distance;

    }

    public function dateTimediff($d1, $d2)
    {

        if($d1 == $d2)
        {
            return "0 seconds";
        }

        // Declare and define two dates 
        $date1 = strtotime($d1);  
        $date2 = strtotime($d2);  
          
        // Formulate the Difference between two dates 
        $diff = abs($date2 - $date1);  
          
          
        // To get the year divide the resultant date into 
        // total seconds in a year (365*60*60*24) 
        $years = floor($diff / (365*60*60*24));  
          
          
        // To get the month, subtract it with years and 
        // divide the resultant date into 
        // total seconds in a month (30*60*60*24) 
        $months = floor(($diff - $years * 365*60*60*24) 
                                       / (30*60*60*24));  
          
          
        // To get the day, subtract it with years and  
        // months and divide the resultant date into 
        // total seconds in a days (60*60*24) 
        $days = floor(($diff - $years * 365*60*60*24 -  
                     $months*30*60*60*24)/ (60*60*24)); 
          
          
        // To get the hour, subtract it with years,  
        // months & seconds and divide the resultant 
        // date into total seconds in a hours (60*60) 
        $hours = floor(($diff - $years * 365*60*60*24  
               - $months*30*60*60*24 - $days*60*60*24) 
                                           / (60*60));  
          
          
        // To get the minutes, subtract it with years, 
        // months, seconds and hours and divide the  
        // resultant date into total seconds i.e. 60 
        $minutes = floor(($diff - $years * 365*60*60*24  
                 - $months*30*60*60*24 - $days*60*60*24  
                                  - $hours*60*60)/ 60); 

        // To get the minutes, subtract it with years, 
        // months, seconds, hours and minutes  
        $seconds = floor(($diff - $years * 365*60*60*24  
                 - $months*30*60*60*24 - $days*60*60*24 
                - $hours*60*60 - $minutes*60));

        $string = "";

        if($years > 0)
        {
            $string = $string.$years." years ";
        }

        if($months > 0)
        {
            $string = $string.$months." months ";
        }

        if($days > 0)
        {
            $string = $string.$days." days ";
        }


        if($hours > 0)
        {
            $string = $string.$hours." hours ";
        }

        if($minutes > 0)
        {
            $string = $string.$minutes." minutes ";
        }

        if($seconds > 0)
        {
            $string = $string.$seconds." seconds";
        }

        return $string;

    }

}







        // $directory_name = "public/documents/tripreports/".$gps->vehicle->client_id;
        // //Check if the directory already exists.
        // if(!is_dir($directory_name)){
        //     //Directory does not exist, so lets create it.
        //     mkdir($directory_name, 0755);
        // }

        // $directory_name = "public/documents/tripreports/".$gps->vehicle->client_id."/".$gps->vehicle->id;
        // //Check if the directory already exists.
        // if(!is_dir($directory_name)){
        //     //Directory does not exist, so lets create it.
        //     mkdir($directory_name, 0755);
        // }


        // $directory_name = "public/documents/tripreports/".$gps->vehicle->client_id."/".$gps->vehicle->id."/".$date."/";
        // //Check if the directory already exists.
        // if(!is_dir($directory_name)){
        //     //Directory does not exist, so lets create it.
        //     mkdir($directory_name, 0755);
        // }