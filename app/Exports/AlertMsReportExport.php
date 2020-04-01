<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Alert\Models\Alert;
class AlertMsReportExport implements FromView
{
     protected $alertReportExport;

     /**
      * initial alert export
      */
	public function __construct($user_id,$alert_type,$vehicle_id,$start_date,$end_date)
     {   
          $filter  = [ 'user_id' => $user_id, 'alert_type' => $alert_type , 'vehicle_id' => $vehicle_id , 'start_date' => $start_date , 'end_date' => $end_date ,'limit' => 10000 ]; 
          $this->alertReportExport = $this->getAlertsFromMicroService( $filter );
     }

     /**
      * get report view
      */
     public function view(): View
	{
        return view('Exports::alert-report', [
	        'alertReportExport' => $this->alertReportExport
	    ]);
     }
     
     /**
      * get report view
      */
      public function getAlertsFromMicroService($filter)
      {
          $client 	     = new \GuzzleHttp\Client();
		$response 	= $client->request('POST',config('eclipse.urls.ms_alerts').'/alert-report', ['json' => $filter]);
          $responseBody  = $response->getBody();
          $responseData  = json_decode($responseBody->getContents(),true);
          return  $responseData['data']['alerts'];   
      }
    
}

