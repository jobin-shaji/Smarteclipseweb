<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\Gps;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Vehicle\Models\DailyKm;
class TotalKMReportExport implements FromView
{
	protected $totalkmReportExport;
	public function __construct($client_id,$vehicle_id)
    { 
        $vehicle_gps_ids                =   [];
        $total_km_details               =   [];
        if($vehicle_id != 0)
        {
            $vehicle_details            =   (new Vehicle())->getSingleVehicleDetailsBasedOnVehicleId($vehicle_id);
            $vehicle_gps_details        =   (new VehicleGps())->getGpsDetailsBasedOnVehicle($vehicle_id);
            foreach($vehicle_gps_details as $each_vehicle_gps)
            {
                $vehicle_gps_ids[]      =   $each_vehicle_gps->gps_id;
            }
            $km                         =   (new Gps())->getSumOfKmBasedOnGpsOfVehicle($vehicle_gps_ids);
            $total_km_details[]         =   [   'vehicle_name'              => $vehicle_details->name,
                                                'vehicle_register_number'   => $vehicle_details->register_number,
                                                'total_km'                  => $km                             
                                            ];
        }
        else
        {
            $vehicle_details            =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
            foreach($vehicle_details as $each_vehicle)
            {
                $vehicle_id             =   $each_vehicle->id; 
                $vehicle_gps_details    =   (new VehicleGps())->getGpsDetailsBasedOnVehicle($vehicle_id);
                foreach($vehicle_gps_details as $each_vehicle_gps)
                {
                    $vehicle_gps_ids[]  =   $each_vehicle_gps->gps_id;
                }
                $km                     =   (new Gps())->getSumOfKmBasedOnGpsOfVehicle($vehicle_gps_ids);
                $total_km_details[]     =   [   'vehicle_name'              => $each_vehicle->name,
                                                'vehicle_register_number'   => $each_vehicle->register_number,
                                                'total_km'                  => $km                             
                                            ];
            }
        }
        $this->totalkmReportExport      =   $total_km_details;
    }
    public function view(): View
	{
        return view('Exports::total-km-report', [
            'totalkmReportExport' => $this->totalkmReportExport
        ]);
	}
    
}

