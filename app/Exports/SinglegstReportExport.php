<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\Trip\Models\TripLog;
use App\Modules\Trip\Models\TripCoveredKm;
use App\Modules\WayBill\Models\StateWiseCollection;
class SinglegstReportExport implements FromView
{
	protected $SinglegstReportExport;
	public function __construct($depot,$state,$vehicle_type,$from,$to)
    {

      $waybill_etm =Waybill::select(
             'id',
            'code',           
            'date',
            'depot_id'           
        )
        
        ->where('depot_id',$depot)
        ->where('status',1)        
        ->get();
        $etm_waybill_close = [];
        foreach($waybill_etm as $waybill){
            $etm_waybill_close[] = $waybill->id;
        }
        $query =TripCoveredKm::select(
            'id',
            'waybill_id',
            'route_id',
            'state_id',
            'trip_id',
            'vehicle_type_id',            
          \DB::raw('DATE(created_at) as date'),            
          \DB::raw('sum(km) as covered_km'),
          \DB::raw('sum(missed_km) as missed_km')
        )                         
        ->with('totalCollection')   
        ->with('srtcalculation')    
        ->where('state_id',$state)
        ->with('vehicleType:id,name')
        ->where('vehicle_type_id',$vehicle_type)
        ->whereIn('waybill_id',$etm_waybill_close)           
        ->groupBy('date');

          
        if($from)
        {
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
        $this->SinglegstReportExport = $query->get();
    } 
    public function view(): View
	{
	    return view('Exports::single-gst-report', [
	        'SinglegstReportExport' => $this->SinglegstReportExport
	    ]);
	}    
}

