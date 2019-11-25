<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
class ZigZagDrivingReportExport implements FromView
{
	protected $zigzagdrivingReportExport;
	public function __construct($client,$vehicle,$from,$to)
    {  
         $single_vehicle_id = [];
          if($vehicle!=0)
        {
            $vehicle_details =Vehicle::withTrashed()->find($vehicle);
            $single_vehicle_ids = $vehicle_details->gps_id;
        }
        else
        {
            $vehicle_details =Vehicle::where('client_id',$client)->withTrashed()->get(); 
            
            foreach($vehicle_details as $vehicle_detail){
                $single_vehicle_id[] = $vehicle_detail->gps_id; 

            }
        }
         $query =Alert::select(
            'id',
            'alert_type_id', 
            'device_time',    
            'gps_id',
            'latitude',
            'longitude', 
            'status'
        )
        ->with('alertType:id,description')
        ->with('gps.vehicle')
        ->orderBy('device_time', 'DESC');
        if($vehicle==0 || $vehicle==null)
        {
            $query = $query->whereIn('gps_id',$single_vehicle_id)
            ->where('alert_type_id',3);
            // ->where('status',1);
            if($from){
               $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
            }
        }
        else
        {
            $query = $query->where('gps_id',$single_vehicle_ids)
            ->where('alert_type_id',3);
            // ->where('status',1);
            if($from){
               $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
            }
        }
        $this->zigzagdrivingReportExport = $query->get();          
    }
    public function view(): View
	{
       return view('Exports::zig-zag-driving-report', [
            'zigzagdrivingReportExport' => $this->zigzagdrivingReportExport
        ]);
	}
    
}

