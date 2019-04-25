<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBillAdvanceBooking\Models\WayBillAdvanceBooking;
use App\Modules\Ticket\Models\TicketLogAdvanceBooking;

class AgentCombinedConcessionReportExport implements FromView
{

	protected $concessions;

	public function __construct($depot,$from,$to)
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
      $query=TicketLogAdvanceBooking::select(
                  'id',
                  'concession_id',
                  \DB::raw('DATE(created_at) as date'),
                  \DB::raw('sum(count) as count'),
                  \DB::raw('sum(total_amount) as total_amount'),
                  \DB::raw('sum(actual_amount) as actual_amount')
             )
            ->with('concession:id,name')
            ->whereIn('waybill_id',$includes)
            ->whereNotIn('concession_id',[11])
            ->where('depot_id',$depot)
            ->groupBy('concession_id');
      if($from){
          $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
      }
      $this->concessions = $query->get();
                                    						
    }


  public function view(): View
	{
	    return view('Exports::agent-combined-concession-report', [
	        'concessions' => $this->concessions
	    ]);
	}
    
}

