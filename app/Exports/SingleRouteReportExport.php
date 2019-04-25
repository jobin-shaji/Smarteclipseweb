<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\Trip\Models\TripLog;

class SingleRouteReportExport implements FromView
{

	protected $routes;

	public function __construct($depot,$route_id,$from,$to)
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
                  \DB::raw('DATE(created_at) as date'),
                  \DB::raw('sum(km) as covered_km'),
                  \DB::raw('sum(total_collection_amount) as collection_amount'),
                  \DB::raw('sum(advance_booking_amount) as advance_booking_amount')
             )
            ->with('route:id,code,total_km')
            ->where('route_id',$route_id)
            ->whereIn('waybill_id',$includes)
            ->where('depot_id',$depot)
            ->groupBy('date');
      if($from){
          $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
      }
        $this->routes = $query->get();
                                    						
    }


    public function view(): View
	{
	    return view('Exports::single-route-report', [
	        'routes' => $this->routes
	    ]);
	}
    
}

