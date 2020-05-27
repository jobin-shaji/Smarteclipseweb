<?php

namespace App\Console\Commands;
use App\VltData;
use App\Http\Controllers\HttpGpsController;
use App\Vst\BatchProcessor;
use App\Vst\NrmProcessor;
use App\Vst\AckProcessor;
use App\Vst\AltProcessor;
use App\Vst\CrtProcessor;
use App\Vst\EpbProcessor;
use App\Vst\FulProcessor;
use App\Vst\HlmProcessor;
use App\Vst\LgnProcessor;
use \Carbon\Carbon;
use App\Modules\Gps\Models\Gps;
use App\TripLog;

use PDF;
use \DB;

use Illuminate\Console\Command;

class TripM extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:trips';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processing data';

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

        $imei = $this->ask('Enter IMEI number');

        $date = $this->ask('Enter date (yyyy-mm-dd)');

        $user_selected_table = $this->ask('Enter source table');

        if (!file_exists("public/documents/tripreports/".$imei."/".$date."/trips/")) {
            mkdir("public/documents/tripreports/".$imei."/".$date."/trips/", 0777, true);
        }

        $gps = Gps::where('imei',$imei)->first();

        if(!$gps)
        {
            echo "device not found"."\n";
            exit;
        }
        else
        {
            if(!$gps->vehicle)
            {
                echo "vehicle not found"."\n";
                exit;
            }
        }

        $vlt_data_table = (New VltData);
        $vlt_data_table->selectTable($user_selected_table);


        $query = $vlt_data_table->distinct()->where("imei",$imei)->whereDate('created_at',$date);

        if($query->count() == 0)
        {
            echo "no data found"."\n";
            exit;
        }

        echo "fetching data from ".$vlt_data_table->getTable()."\n";
        $packets = $query->orderBy('created_at','asc')->get();

        $trips_table = (New TripLog);
        $trips_table->createTable($imei);
        $trips_table->query()->truncate();

        // $query = VltData::where("imei","869247045501563")->whereDate('created_at',$date);

        echo "moving data from ".$vlt_data_table->getTable()." to ".$trips_table->getTable()."\n";

        foreach ($packets as $item) {

            $vlt_data = $item->vltdata;

            $header = substr($vlt_data,0,3);

            if($header == "BTH"){
                $processor = New BatchProcessor;
                $packets = $processor->processBth($vlt_data);
                $this->splitBth($packets, $trips_table);
            }elseif($header == "NRM"){
                $processor = New NrmProcessor($vlt_data);
                $this->saveToLog($processor->lat, $processor->lng, $processor->vehicle_mode, $processor->ignition, $processor->device_time, $processor->speed, $trips_table);
            }elseif($header == "ACK" || $header == "AVK"){
                $processor = New AckProcessor($vlt_data);
                $this->saveToLog($processor->lat, $processor->lng, $processor->vehicle_mode, $processor->ignition, $processor->device_time, $processor->speed, $trips_table);
            }elseif($header == "ALT"){
                $processor = New AltProcessor($vlt_data);
                $this->saveToLog($processor->lat, $processor->lng, $processor->vehicle_mode, $processor->ignition, $processor->device_time, $processor->speed, $trips_table);
            }elseif($header == "CRT"){
                $processor = New CrtProcessor($vlt_data);
                $this->saveToLog($processor->lat, $processor->lng, $processor->vehicle_mode, $processor->ignition, $processor->device_time, $processor->speed, $trips_table);
            }elseif($header == "EPB"){
                $processor = New EpbProcessor($vlt_data);
                $this->saveToLog($processor->lat, $processor->lng, $processor->vehicle_mode, $processor->ignition, $processor->device_time, $processor->speed, $trips_table);
            }elseif($header == "FUL"){
                $processor = New FulProcessor($vlt_data);
                $this->saveToLog($processor->lat, $processor->lng, $processor->vehicle_mode, $processor->ignition, $processor->device_time, $processor->speed, $trips_table);
            }
            
        }

        // DB::select("UPDATE trip_logs SET device_time = concat('2020-04-09 ', time(device_time))");

        $data = $trips_table->whereDate('device_time',$date)->orderBy('device_time','asc')->get();

        $geo_locations = [];
        $trips = [];
        $total_distance = 0;

        foreach ($data as $item) {
            
            if($item->mode == 'M')
            {    
               $node =  [ 'lattitude' => $item->lat, 'longitude' => $item->lng, 'device_time' => $item->device_time];
               $geo_locations[] = $node;
            }

            if(sizeof($geo_locations) > 0 && $item->mode != 'M')
            {

                $start_lat  = $geo_locations[0]['lattitude'];
                $start_lng  = $geo_locations[0]['longitude'];
                $start_time = $geo_locations[0]['device_time'];
                $end        = end($geo_locations);
                $stop_lat   = $end['lattitude'];
                $stop_lng   = $end['longitude'];
                $stop_time  = $end['device_time'];

                $result = $this->getDistanceOfTrip($geo_locations, count($trips), $imei, $date);
                $distance = m2Km($result);

                $total_distance = $total_distance + $result;

                $trip = [ 
                            'start_address' => getPlacenameFromLatLng($start_lat, $start_lng),
                            'start_time'=> $start_time,
                            'stop_address'  => getPlacenameFromLatLng($stop_lat, $stop_lng),
                            'stop_time' => $stop_time,
                            'duration'  => $this->dateTimediff($start_time, $stop_time),
                            'distance'  => $distance
                        ];

                $trips[] = $trip;

                echo "processed trip ".count($trips) ."\n";


                $geo_locations = [];

            }

        }

        $summary = [];

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
        }
        else
        {
            echo "no trips found.."."\n";
            $trips_table->dropTable();
            exit;
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

        
        view()->share(['trips' => $trips, 'date' => $date, 'summary' => $summary, 'gps' => $gps]);

        $file_name = $gps->imei.'-'.$date.'.pdf';

        $pdf = PDF::loadView('Exports::trip-report');

        $pdf->save("public/documents/tripreports/".$imei."/".$date."/".$file_name);

        echo "Trip report saved Successfully (public/documents/tripreports/".$imei."/".$date."/".$file_name.")!!"."\n";
        
        $trips_table->dropTable();

    }

    //slicing batch to packets 
    public function splitBth($packets, $trips_table)
    {   
        foreach ($packets as $item) 
        {

            $vlt_data = $item["packet"];
            $header = substr($vlt_data,0,3);

            if($header == "NRM"){
                $processor = New NrmProcessor($vlt_data);
                $this->saveToLog($processor->lat, $processor->lng, $processor->vehicle_mode, $processor->ignition, $processor->device_time, $processor->speed, $trips_table);
            }elseif($header == "ACK" || $header == "AVK"){
                $processor = New AckProcessor($vlt_data);
                $this->saveToLog($processor->lat, $processor->lng, $processor->vehicle_mode, $processor->ignition, $processor->device_time, $processor->speed, $trips_table);
            }elseif($header == "ALT"){
                $processor = New AltProcessor($vlt_data);
                $this->saveToLog($processor->lat, $processor->lng, $processor->vehicle_mode, $processor->ignition, $processor->device_time, $processor->speed, $trips_table);
            }elseif($header == "CRT"){
                $processor = New CrtProcessor($vlt_data);
                $this->saveToLog($processor->lat, $processor->lng, $processor->vehicle_mode, $processor->ignition, $processor->device_time, $processor->speed, $trips_table);
            }elseif($header == "EPB"){
                $processor = New EpbProcessor($vlt_data);
                $this->saveToLog($processor->lat, $processor->lng, $processor->vehicle_mode, $processor->ignition, $processor->device_time, $processor->speed, $trips_table);
            }elseif($header == "FUL"){
                $processor = New FulProcessor($vlt_data);
                $this->saveToLog($processor->lat, $processor->lng, $processor->vehicle_mode, $processor->ignition, $processor->device_time, $processor->speed, $trips_table);
            }
        }
    }

    public function saveToLog($lat, $lng, $vehicle_mode, $ignition, $device_time, $speed, $trips_table)
    {
        $trips_table->create([
            'lat' => $lat,
            'lng' => $lng,
            'mode' => $vehicle_mode,
            'ignition' => $ignition,
            'speed' => $speed,
            'device_time' => $device_time
        ]);
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