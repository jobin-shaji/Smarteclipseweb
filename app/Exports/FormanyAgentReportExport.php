<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WaybillAdvanceBooking\Models\WaybillAdvanceBooking;
use App\Modules\Trip\Models\TripLogAdvanceBooking;

class FormanyAgentReportExport implements FromView
{
	protected $FormanyAgentReportExport;
	public function __construct($depot,$from,$to)
    {       
      $closed_waybills = WaybillAdvanceBooking::select(
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
                  'trip_id',
                  'vehicle_id',
                  'agent_id',                 
                  'etm_id',
                  'waybill_id',
                  \DB::raw('DATE(created_at) as date'),
                  \DB::raw('sum(km) as covered_km'),
                  \DB::raw('count(km) as count_km'),
                  \DB::raw('sum(total_collection_amount) as collection_amount')                 
             )
            
            ->whereIn('waybill_id',$includes)
            ->where('depot_id',$depot)
            ->with('vehicle:id,register_number')         
            ->with('agent:id,name,employee_code')
            ->with('waybill:id,code')
            ->with('etm:id,name,imei')
            ->groupBy('agent_id');
      if($from){
          $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
      }
        
        $this->FormanyAgentReportExport = $query->get();

    } 
    public function view(): View
	{
	    return view('Exports::formany-agent-report', [
	        'FormanyAgentReportExport' => $this->FormanyAgentReportExport
	    ]);
	}    
}

