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
    
	public function __construct($client_id,$vehicle_id,$from_date,$to_date)
    {  
     
    
        $single_vehicle_gps_ids         =   []; 
        $from_date                      =     $from_date;
        $to_date                        =     $to_date;
        if($vehicle_id != 0)
        {
            $vehicle_gps_ids            =   (new VehicleGps())->getGpsDetailsBasedOnVehicleWithDates($vehicle_id,$from_date,$to_date); 
        }
        else
        {
            $vehicle_details            =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
            $vehicle_ids                =   [];
            foreach($vehicle_details as $each_vehicle)
            {
                $vehicle_ids[]          =   $each_vehicle->id; 
            }  
            $vehicle_gps_ids            =   (new VehicleGps())->getGpsDetailsBasedOnVehiclesWithDates($vehicle_ids,$from_date,$to_date);
        }
        foreach($vehicle_gps_ids as $vehicle_gps_id)
        {
            $single_vehicle_gps_ids[]   =   $vehicle_gps_id->gps_id;
        }
        $this->dailykmReportExport      =   (new DailyKm())->getDailyKmBasedOnFromDateAndToDateGps($single_vehicle_gps_ids,$from_date,$to_date);          
    }
    public function view(): View
	{
       return view('Exports::daily-km-report', [
            'dailykmReportExport' => $this->dailykmReportExport
        ]);
	}
    
}

