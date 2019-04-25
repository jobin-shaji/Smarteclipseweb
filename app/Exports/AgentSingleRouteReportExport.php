<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBillAdvanceBooking\Models\WayBillAdvanceBooking;
use App\Modules\Trip\Models\TripLogAdvanceBooking;

class AgentSingleRouteReportExport implements FromView
{

	protected $routes;

	public function __construct($depot,$route_id,$from,$to)
  {
		$closed_waybills = WayBillAdvanceBooking::select(
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
      $query=TripLogAdvanceBooking::select(
                  'id',
                  'route_id',
                  \DB::raw('DATE(created_at) as date'),
                  \DB::raw('sum(km) as covered_km'),
                  \DB::raw('sum(total_collection_amount) as total_collection_amount'),
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
	    return view('Exports::agent-single-route-report', [
	        'routes' => $this->routes
	    ]);
	}
    
}

