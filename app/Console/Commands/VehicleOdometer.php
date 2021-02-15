<?php

namespace App\Console\Commands;
use \Carbon\Carbon;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Gps\Models\Gps;
use App\Modules\Vehicle\Models\VehicleTripSummary;
use App\Modules\TripReport\Models\ClientTripReportSubscription;
use App\Modules\TripReport\Models\TripReportSubscriptionVehicles;
use PDF;
use \DB;

use Illuminate\Console\Command;

class VehicleOdometer extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicle:odometer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'odometer updation for all vehicles';

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
        $subscribed_vehicles = (new TripReportSubscriptionVehicles())->getSubscribedVehicles($this->trip_date)->pluck('vehicle_id');
        
        $vehicles = Vehicle::whereNotIn('id', $subscribed_vehicles)->get();

        foreach ($vehicles as $vehicle) 
        {
            if($vehicle->gps && $vehicle->client)
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
        $source_table           = new GpsData;
        $vehicle_records        = $source_table->fetchYesterdaysRecordsOfVehicleDevice($gps->imei);
        $geo_locations          = [];
        $trips                  = [];
        $km_from_all_packets    = 0;
        $summary                = [];
       
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

                $result     = $this->getDistanceOfTrip($geo_locations, (count($trips)+1), $gps->vehicle->client->id, $gps->vehicle->id);
                $distance   = m2Km($result);

                $km_from_all_packets = $km_from_all_packets + $result;
                $trip = [ 
                            'start_address' => $start_lat.','.$start_lng,
                            'start_time'    => $start_time,
                            'stop_address'  => $stop_lat.','.$stop_lng,
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
            $summary["km"]           = m2Km($km_from_all_packets);
            $summary["duration"]     = dateTimediff($summary["on"], $summary["off"]);

            // generate pdf report of vehicle 
            // $this->generatePdfReport($trips, $summary, $gps);
            // update daily km calculation of vehicle based on new calculation and return live packet processed km
            $km_from_live_packets   = (new DailyKm)->updateDailyKm($km_from_all_packets, $gps->id, $this->trip_date);
            //update gps odometer 
            (new Gps)->updateOdometer($gps->id, $km_from_all_packets, $km_from_live_packets);
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
        // view()->share();
        $file_name = $gps->imei.'-'.$this->trip_date.'.pdf';
        $pdf       = PDF::loadView('Exports::trip-report', ['trips' => $trips, 'date' => $this->trip_date, 'summary' => $summary, 'gps' => $gps]);
        $file = "documents/tripreports/".$client_id."/".$vehicle_id."/".$this->trip_date."/".$file_name;
        $pdf->save("public/".$file);
        

        (new VehicleTripSummary)->addNewReport($client_id, $vehicle_id, $file, $summary["km"], $this->trip_date);
    }

    /**
     * 
     *
     * 
     */
    public function getPlacenameFromGeoCords($latitude,$longitude)
    {  
        // $app_id              = "RN9UIyGura2lyToc9aPg";
        // $app_code            = "4YMdYfSTVVe1MOD_bDp_ZA";    
        // $ch = curl_init();  
        // curl_setopt($ch,CURLOPT_URL,'https://reverse.geocoder.api.here.com/6.2/reversegeocode.json?prox='.$latitude.'%2C'.$longitude.'%2C118&mode=retrieveAddresses&maxresults=1&gen=9&app_id='.$app_id.'&app_code='.$app_code);
        // curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        // //  curl_setopt($ch,CURLOPT_HEADER, false);
        // $output=curl_exec($ch);
        // curl_close($ch);
        // $data=json_decode($output,true);
        // return $data['Response']['View'][0]['Result'][0]['Location']['Address']['Label'];
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            try
            {
                    $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key='.config('eclipse.keys.googleMap'));
                    $output = json_decode($geocodeFromLatLong);
                    $status = $output->status;
                    $address = ($status=="OK")?$output->results[0]->formatted_address:'';
                    if(!empty($address)){
                        $address = removeUrlFromString($address);
                        return $address;
                    }else{
                        return false;
                    }
            }
            catch(Exception $e)
            {
                report($e);
            }
       
        }else{
            return false;
        }
    }  

}

