<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\Trip\Models\TripLog;

class SingledriverReportExport implements FromView
{
	protected $SingledriverReportExport;
	public function __construct($depot,$driver,$from,$to)
    {

      $waybill_etm =Waybill::select(
             'id',
            'code', 
            'etm_id',    
            'date',
            'driver_id'
        )
        ->whereBetween('date',[$from,$to])
        ->where('driver_id',$driver)
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
            'conductor_id',       
            'waybill_id',
            'route_id',
            'has_closed',
            'etm_id',
            'created_at',                    
             \DB::raw('DATE(created_at) as date'),
             \DB::raw('sum(total_collection_amount) as cash'),
             \DB::raw('sum(advance_booking_amount) as advance'),
             \DB::raw('count(km) as count_km'),
             \DB::raw('sum(km) as km')
        )         
         ->with('waybill:id,code')
         ->with('driver:id,name,employee_code')     
         ->with('conductor:id,name,employee_code')
         ->with('vehicle:id,register_number')
           ->whereIn('waybill_id',$etm_waybill_close)
           ->where('has_closed',1)
           ->where('depot_id',$depot)
           ->where('driver_id',$driver)
            ->with('etm:id,name,imei')
           ->groupBy('date');
          
        if($from)
        {
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
        $this->SingledriverReportExport = $query->get();
    } 
    public function view(): View
	{
	    return view('Exports::single-driver-report', [
	        'SingledriverReportExport' => $this->SingledriverReportExport
	    ]);
	}    
}

