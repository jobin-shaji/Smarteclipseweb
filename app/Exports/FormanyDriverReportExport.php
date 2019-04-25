<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\Trip\Models\TripLog;

class FormanyDriverReportExport implements FromView
{
	protected $FormanyDriverReportExport;
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
            'driver_id',     
            'waybill_id', 
            'trip_id', 
            'conductor_id',
            'etm_id',         
            'has_closed',
            'created_at',
            'route_id',                     
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
         ->whereIn('waybill_id',$etm_waybill_close)
         ->where('has_closed',1)
         ->where('depot_id',$depot)
          ->with('etm:id,name,imei')
           // ->where('driver_id',$driver)
           ->groupBy('driver_id');
        // $query = Waybill::where('depot_id',$depot);
          // $query = TripLog::where('depot_id',$depot)
          // ->groupBy('driver_id');
        
        if($from)
        {
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
        $this->FormanyDriverReportExport = $query->get();
    } 
    public function view(): View
	{
	    return view('Exports::formany-driver-report', [
	        'FormanyDriverReportExport' => $this->FormanyDriverReportExport
	    ]);
	}    
}

