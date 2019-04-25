<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\Trip\Models\TripLog;

class CombinedDriverReportExport implements FromView
{
	protected $CombinedDriverReportExport;
	public function __construct($depot,$from,$to)
    {


        $waybill_etm =Waybill::select(
             'id',
            'code', 
            'etm_id',    
           
            'date',
            'driver_id'
        )
        ->whereBetween('date',[$from,$to])
        ->where('status',1)       
        ->get();
        $etm_waybill_close = [];
        foreach($waybill_etm as $waybill){
            $etm_waybill_close[] = $waybill->id;
        }
        $query =TripLog::select(
            'id',
            'vehicle_id',
            'trip_id',
            'driver_id', 
            'etm_id',
            'conductor_id',       
            'waybill_id',
            'route_id',
            'has_closed',
            'created_at',
            // 'km',           
             \DB::raw('DATE(created_at) as date'),
             \DB::raw('count(km) as count_km'),
             \DB::raw('sum(total_collection_amount) as cash'),
             \DB::raw('sum(advance_booking_amount) as advance'),
             \DB::raw('sum(km) as km')
        )         
         ->with('waybill:id,code')
         ->with('driver:id,name,employee_code')
         ->with('conductor:id,name,employee_code')
         ->with('route:id,code,total_km')
         ->with('vehicle:id,register_number')
         ->whereIn('waybill_id',$etm_waybill_close)
         ->where('has_closed',1)
         ->where('depot_id',$depot)
          ->with('etm:id,name,imei')
         ->groupBy('waybill_id');
        
        // $query = Waybill::where('depot_id',$depot);
          // $query = TripLog::where('depot_id',$depot)
          // ->groupBy('waybill_id');
        
        if($from)
        {
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
        $this->CombinedDriverReportExport = $query->get();
    } 
    public function view(): View
	{
	    return view('Exports::combined-driver-report', [
	        'CombinedDriverReportExport' => $this->CombinedDriverReportExport
	    ]);
	}    
}

