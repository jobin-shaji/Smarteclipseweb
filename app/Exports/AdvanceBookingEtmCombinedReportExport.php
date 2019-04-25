<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\Trip\Models\TripLogAdvanceBooking;
class AdvanceBookingEtmCombinedReportExport implements FromView
{

	protected $AdvanceBookingEtmCombinedReportExport;
	public function __construct($depot,$fromdate,$todate)
    {

 $closed_waybills = Waybill::select(
            'id',
            'date'
            )
            ->where('status',1)
            ->where('depot_id',$depot)
            ->get();
      $includes = [];
      foreach($closed_waybills as $waybill){
        $includes[] = $waybill->id;
      }
        $query =TripLogAdvanceBooking::select(
              'id',
            'vehicle_id',               
            'waybill_id',           
            'trip_id',
            'etm_id', 
            'route_id', 
                    
            \DB::raw('DATE(created_at) as date'),           
            \DB::raw('sum(total_collection_amount) as total_amount') ,
            \DB::raw('sum(km) as km')             
        )
        ->with('etm:id,name,imei')
        ->with('waybill:id,code') 
         ->with('route:id,code,total_km')      
        
        ->where('has_closed',1) 
        ->whereIn('waybill_id',$includes)
         ->where('depot_id',$depot)
         ->groupBy('waybill_id');
        if($fromdate){          
           $query = $query->whereDate('created_at', '>=', $fromdate)->whereDate('created_at', '<=', $todate);
        }
        $this->AdvanceBookingEtmCombinedReportExport = $query->get();

    }


    public function view(): View
	{
	    return view('Exports::advance-booking-etm-combined-report', [
	        'AdvanceBookingEtmCombinedReportExport' => $this->AdvanceBookingEtmCombinedReportExport
	    ]);
	}
    
}

