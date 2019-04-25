<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\Trip\Models\TripLog;
use App\Modules\Trip\Models\TripCoveredKm;
class SingleStateWiseReportExport implements FromView
{
	protected $SingleStateWiseExport;
	public function __construct($depot,$state,$from,$to)
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
        ->with('waybill:id,code')
        ->with('vehicle:id,register_number')
        ->with('totalCollection')
        ->where('state_id',$state) 
        ->whereIn('waybill_id',$etm_waybill_close)           
        ->groupBy('date');

       if($from){
          $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
      }
       
        $this->SingleStateWiseExport = $query->get();
    } 
    public function view(): View
	{
	    return view('Exports::single-state-wise-report', [
	        'SingleStateWiseExport' => $this->SingleStateWiseExport
	    ]);
	}    
}

