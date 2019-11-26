<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
class OverSpeedReportExport implements FromView
{
	protected $overspeedReportExport;
	public function __construct($client,$vehicle,$from,$to)
    {  
        if($vehicle!=0)
        {
            $vehicle_details =Vehicle::withTrashed()->find($vehicle);
            $single_vehicle_ids = $vehicle_details->gps_id;
        }
        else
        {
            $single_vehicle_id=[];
            $vehicle_details =Vehicle::withTrashed()->where('client_id',$client)->get(); 
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
        ->with('vehicle:id,name,register_number')
        ->orderBy('device_time', 'DESC');
        if($vehicle==0 || $vehicle==null)
        {
            $query = $query->whereIn('gps_id',$single_vehicle_id)
            ->where('alert_type_id',12);
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
            ->where('alert_type_id',12);
            // ->where('status',1);
            if($from){
                $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
            }
        }
        $this->overspeedReportExport = $query->get();          
    }
    public function view(): View
	{
       return view('Exports::over-speed-report', [
            'overspeedReportExport' => $this->overspeedReportExport
        ]);
	}
    
}

