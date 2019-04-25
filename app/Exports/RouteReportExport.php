<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Trip\Models\TripLog;

class RouteReportExport implements FromView
{

	protected $routes;

	public function __construct($depot,$route_id,$from,$to)
    {
    	$query = TripLog::where('depot_id',$depot)
        						->where('route_id',$route_id)
                                ->where('has_closed',1);
        if($from){
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }

        $this->routes = $query->get();
        							
    }


    public function view(): View
	{
	    return view('Exports::route-report', [
	        'routes' => $this->routes
	    ]);
	}
    
}

