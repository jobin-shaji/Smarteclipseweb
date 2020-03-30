<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Vehicle\Models\DailyKm;

class DailyKMReportExport implements FromView
{
    protected $dailykmReportExport;
    
	public function __construct($client_id,$vehicle_id,$date)
    {  
        $single_vehicle_gps_ids     =   []; 
        $search_date                =   date("Y-m-d", strtotime($date)); 
        if($vehicle_id != 0)
        {
            $vehicle_gps_ids        =   (new VehicleGps())->getGpsDetailsBasedOnVehicleWithSingleDate($vehicle_id,$search_date); 
        }
        else
        {
            $vehicle_details        =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
            $vehicle_ids            =   [];
            foreach($vehicle_details as $each_vehicle)
            {
                $vehicle_ids[]      =   $each_vehicle->id; 
            }  
            $vehicle_gps_ids        =   (new VehicleGps())->getGpsDetailsBasedOnVehiclesWithSingleDate($vehicle_ids,$search_date);
        }
        $single_vehicle_gps_ids     =   ['5'];
        $this->dailykmReportExport  =   (new DailyKm())->getDailyKmBasedOnDateAndGps($single_vehicle_gps_ids,$search_date);          
    }
    public function view(): View
	{
       return view('Exports::daily-km-report', [
            'dailykmReportExport' => $this->dailykmReportExport
        ]);
	}
    
}

