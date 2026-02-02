<?php

namespace App\Http\Controllers;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Vehicle\Models\VehicleTripSummary;
use App\Http\Traits\LocationTrait;
use Illuminate\Support\Facades\Log;
use App\Modules\Client\Models\OnDemandTripReportRequests;
use PDF;
use App\Modules\Gps\Models\GpsOrder;
use Carbon\Carbon AS Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Queue;
use App\Exceptions\CustomException;
use \Exception;
use \stdClass;
use App\Modules\User\Models\User;
use App\Modules\Gps\Models\Gps;

class GeneralController extends Controller
{
    /**
     * 
     * 
     */
    use LocationTrait;

    /**
     * 
     * 
     */
    public $trip_date;

     /**
     * 
     * 
     */
    public $on_demand_request_id;

     /**
     * 
     * 
     */
    public $source_table;

    /**
     * 
     * 
     */
    public function __construct()
    {
        $this->trip_date                = null;
        $this->on_demand_request_id     = null;
        $this->source_table             = null;
    }

    public function processGeneralTrip($trip_report_date,$vehicle_id,$on_demand_request_id)
    {
        $this->trip_date                = $trip_report_date;
        $this->on_demand_request_id     = $on_demand_request_id;
        $removed_alphanumeric_from_date = preg_replace( '/[\W]/', '',$this->trip_date);
        $this->source_table             = 'gps_data_'.$removed_alphanumeric_from_date;
        $vehicle                        = Vehicle::find($vehicle_id);
        if(!$vehicle)   
        {
            
            echo "vehicle not found"."\n";
            return; 
        }else{
            
            $this->processTripsofVehicle($vehicle->gps);
            echo "processing completed !!"."\n";
            return;
        }
    }
    /* 
    *process trip of vehicle
    * 
    */
   public function processTripsofVehicle($gps)
   {
       
       $source_table_gps            = new GpsData;
       $vehicle_records             = $source_table_gps->fetchDateWiseRecordsOfVehicleDevice($gps->imei,$this->source_table,$this->trip_date);
       $geo_locations               = [];
       $trips                       = [];
       $km_from_all_packets         = 0;
       $summary                     = [];
       $pending_trip                = (new OnDemandTripReportRequests())->getSinglePendingReport($this->on_demand_request_id); 
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

               $result              = $this->getDistanceOfTrip($geo_locations, (count($trips)+1), $gps->vehicle->client->id, $gps->vehicle->id);
               $distance            = m2Km($result);
               $km_from_all_packets = $km_from_all_packets + $result;
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
           $summary["km"]           = m2Km($km_from_all_packets);
           $summary["duration"]     = dateTimediff($summary["on"], $summary["off"]);
           // generate pdf report of vehicle 
         
           $this->generatePdfReport($trips, $summary, $gps);
           // update daily km calculation of vehicle based on new calculation and return live packet processed km
           $km_from_live_packets   = (new DailyKm)->updateDailyKm($km_from_all_packets, $gps->id, $this->trip_date);
           //update gps odometer 
           (new Gps)->updateOdometer($gps->id, $km_from_all_packets, $km_from_live_packets);
       }else
       {
           $pending_trip =   (new OnDemandTripReportRequests())->getSinglePendingReport($this->on_demand_request_id); 
           $pending_trip->job_completed_on=Carbon::now()->format('Y-m-d H:i:s');
           $pending_trip->is_job_failed = 0;
           $pending_trip->save();
       }
       return;

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
    public function generatePdfReport($trips, $summary, $gps)
    {
       
        $client_id  = $gps->vehicle->client->id;
        $vehicle_id = $gps->vehicle->id;
        $file_name  = $gps->imei.'-'.$this->trip_date.'.pdf';
        $pdf        = PDF::loadView('Exports::trip-report', ['trips' => $trips, 'date' => $this->trip_date, 'summary' => $summary, 'gps' => $gps]);
        $file       = "documents/tripreports/".$client_id."/".$vehicle_id."/".$this->trip_date."/".$file_name;
        $pdf->save("public/".$file);
       
        if (file_exists("public/documents/tripreports/".$client_id."/".$vehicle_id."/".$this->trip_date."/".$file_name)) {
            $pending_trip = (new OnDemandTripReportRequests())->getSinglePendingReport($this->on_demand_request_id); 
            $pending_trip->download_link = $file;
            $pending_trip->job_completed_on = Carbon::now()->format('Y-m-d H:i:s');
            $pending_trip->is_job_failed = 0;
            $pending_trip->save();
        }else{
            $pending_trip =   (new OnDemandTripReportRequests())->getSinglePendingReport($this->on_demand_request_id); 
            $pending_trip->job_completed_on = Carbon::now()->format('Y-m-d H:i:s');
            $pending_trip->save();
        }
        (new VehicleTripSummary)->addNewReport($client_id, $vehicle_id, $file, $summary["km"], $this->trip_date);
        return;
    }


    public function generateInvoicePdf($id)
    {

      
       
        $order =  GpsOrder::with('gps')->where('gps_id',$id)->first();
       

    
        if($order == null){
            return view('Gps::404');
        }

       
        if($order->gps->vehicle){
               $words=$this->getIndianCurrency($order->total_amount);
                $client_id  = $order->vehicle->client_id;
              
            
                $vehicle_id = $order->gps->vehicle->id;
                $file_name  = $order->gps->imei.'-'.time().'.pdf';
            
                if($client_id==1778){
                
                    $pdf        = PDF::loadView('invoice', ['gps' => $order,'words'=> $words]);
                  //  return view('invoice')->with(['gps' => $gps]);
                 return $pdf->download($file_name.'.pdf');   
                }
                else{
                    $pdf        = PDF::loadView('invoice1', ['gps' => $order,'words'=> $words]);
                    // return view('invoice1')->with(['gps' => $gps]);
                     return $pdf->download($file_name.'.pdf');
                 }
          }
      else{
            $file_name  = $order->gps->imei.'-'.time().'.pdf';
           /* $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);
            $dompdf = new \Dompdf\Dompdf($options);
            
            $dompdf->loadHtml(view('invoice1',['gps' => $order])->render());
            $dompdf->render();
            return $dompdf->stream();*/
            $words=$this->getIndianCurrency($order->total_amount);
           $pdf        = PDF::setOptions(['isRemoteEnabled' => true])->loadView('invoice1', ['gps' => $order,'words'=> $words]);
          //return view('invoice1')->with(['gps' => $order,'words'=> $words]);
            return $pdf->download($file_name.'.pdf');
        }
      //INVOICE NO: //VIOT/24-25/1665
    }

// cmc report

public function generateCMCPdf($id)
    {

       
       
        $order =  GpsOrder::with('gps')->where('gps_id',$id)->first();

    
        if($order == null){
            return view('Gps::404');
        }

       
        if($order->gps->vehicle){
               $words=$this->getIndianCurrency($order->total_amount);
                $client_id  = $order->vehicle->client->id;
            
                $vehicle_id = $order->gps->vehicle->id;
                $file_name  = $order->gps->imei.'-'.time().'.pdf';
            
                if($client_id==1778){
                
                    $pdf = PDF::loadView('invoice_cmc', ['gps' => $order,'words'=> $words]);
                  //  return view('invoice')->with(['gps' => $gps]);
                    return $pdf->download($file_name.'.pdf');   
                }
                
          }
      
      //INVOICE NO: //VIOT/24-25/1665
    }












public  function getIndianCurrency(float $number)
{

$decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
      $paise ="";$pais="";
    $paise =($decimal > 0) ? " " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' paisa' : '';
    if($paise){
      $pais=  'and'. $paise;
    }
    return ($Rupees ? ucfirst($Rupees). 'Rupees '  : '') . $pais;
}

}