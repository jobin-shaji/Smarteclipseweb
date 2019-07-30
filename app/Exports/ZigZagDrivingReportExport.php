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
         $query =Alert::select(
            'id',
            'alert_type_id', 
            'device_time',    
            'vehicle_id',
            'gps_id',
            'client_id',  
            'latitude',
            'longitude', 
            'status'
        )
        ->with('alertType:id,description')
        ->with('vehicle:id,name,register_number');
        if($vehicle==0 || $vehicle==null)
        {
            $query = $query->where('client_id',$client)
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
            $query = $query->where('client_id',$client)
            ->where('alert_type_id',3)
            ->where('vehicle_id',$vehicle);
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

