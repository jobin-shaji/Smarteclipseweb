<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
class MainBatteryDisconnectReportExport implements FromView
{
	protected $mainBatteryDisconnectReportExport;
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
        if($from==null || $to==null || $vehicle==null)
        {
            $query = $query->where('client_id',$client)
            ->where('alert_type_id',11)
            ->where('status',1);
        }   
        else if($vehicle==0)
        {
            $query = $query->where('client_id',$client)
            ->where('alert_type_id',11)
            ->where('status',1);
            if($from){
                $query = $query->whereDate('device_time', '>=', $from)->whereDate('device_time', '<=', $to);
            }
        }
        else
        {
            $query = $query->where('client_id',$client)
            ->where('alert_type_id',11)
            ->where('vehicle_id',$vehicle)
            ->where('status',1);
            if($from){
                $query = $query->whereDate('device_time', '>=', $from)->whereDate('device_time', '<=', $to);
            }
        }
        $this->mainBatteryDisconnectReportExport = $query->get();          
    }
    public function view(): View
	{
       return view('Exports::main-battery-disconnect-report', [
            'mainBatteryDisconnectReportExport' => $this->mainBatteryDisconnectReportExport
        ]);
	}
    
}

