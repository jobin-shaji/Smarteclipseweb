<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\Ticket\Models\TicketLog;

class SingleConcessionReportExport implements FromView
{

	protected $concessions;

	public function __construct($depot,$concession_id,$from,$to)
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
        $query=TicketLog::select(
                  'id',
                  'concession_id',
                  \DB::raw('DATE(created_at) as date'),
                  \DB::raw('sum(count) as count'),
                  \DB::raw('sum(total_amount) as total_amount'),
                  \DB::raw('sum(actual_amount) as actual_amount')
             )
            ->with('concession:id,name')
            ->where('concession_id',$concession_id)
            ->whereIn('waybill_id',$includes)
            ->where('depot_id',$depot)
            ->groupBy('date');
        if($from){
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        } 
        $this->concessions = $query->get();
                                    						
    }


    public function view(): View
	{
	    return view('Exports::single-concession-report', [
	        'concessions' => $this->concessions
	    ]);
	}
    
}

