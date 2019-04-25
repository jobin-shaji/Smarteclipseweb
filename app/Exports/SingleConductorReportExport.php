<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\Trip\Models\TripLog;

class SingleConductorReportExport implements FromView
{
	protected $singleconductorwiseExport;
	public function __construct($depot,$conductor_id,$from,$to)
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
                ->where('conductor_id',$conductor_id)
                ->whereIn('waybill_id',$includes)
                ->where('depot_id',$depot)
                ->with('vehicle:id,register_number')
                ->with('conductor:id,name')
                ->with('driver:id,name')
                ->with('waybill:id,code')
                ->with('etm:id,name,imei')
                ->groupBy('date');
        if($from){
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
        $this->conductors = $query->get();
    } 
    public function view(): View
	{
	    return view('Exports::single-conductor-report', [
	        'conductors' => $this->conductors
	    ]);
	}    
}

