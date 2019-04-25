<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\Trip\Models\TripLog;

class CombinedConductorReportExport implements FromView
{
	protected $CombinedConductorReportExport;
	public function __construct($depot,$from,$to)
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
      $query=TripLog::select(
                  'id',
                  'route_id',
                  'trip_id',
                  'vehicle_id',
                  'driver_id',
                  'conductor_id',
                  'etm_id',
                  'waybill_id',
                  \DB::raw('DATE(created_at) as date'),
                  \DB::raw('sum(km) as covered_km'),
                  \DB::raw('count(km) as count_km'),
                  \DB::raw('sum(total_collection_amount) as collection_amount'),
                  \DB::raw('sum(advance_booking_amount) as advance_booking_amount')
             )
            
            ->whereIn('waybill_id',$includes)
            ->where('depot_id',$depot)
            ->with('vehicle:id,register_number')
            ->with('route:id,code,total_km')
            ->with('conductor:id,name,employee_code')
            ->with('driver:id,name,employee_code')
            ->with('waybill:id,code')
            ->with('etm:id,name,imei')
            ->groupBy('waybill_id');
      if($from){
          $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
      }  
        // $query = Waybill::where('depot_id',$depot);
          // $query = TripLog::where('depot_id',$depot)
          // ->groupBy('waybill_id');
        // ->where('conductor_id',$conductor);
        // if($from)
        // {
        //     $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        // }
        $this->CombinedConductorReportExport = $query->get();
    } 
    public function view(): View
	{
	    return view('Exports::combined-conductor-report', [
	        'CombinedConductorReportExport' => $this->CombinedConductorReportExport
	    ]);
	}    
}

