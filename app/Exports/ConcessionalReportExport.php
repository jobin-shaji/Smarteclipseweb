<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Ticket\Models\TicketLog;

class ConcessionalReportExport implements FromView
{

	protected $concessions;

	public function __construct($depot,$concession_id,$from,$to)
    {
    	if($concession_id==0){
    		$query = TicketLog::where('depot_id',$depot)
        							->whereNotIn('concession_id',[11,14,15]);
            if($from){
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
        $this->concessions = $query->get();
        							
    	}else{
    		$query = TicketLog::where('depot_id',$depot)
        							->where('concession_id',$concession_id);
        	if($from){
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
        $this->concessions = $query->get();
                                    						
    	}
    }


    public function view(): View
	{
	    return view('Exports::concessional-report', [
	        'concessions' => $this->concessions
	    ]);
	}
    
}

