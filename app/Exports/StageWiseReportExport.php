<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
  use App\Modules\Ticket\Models\TicketLog;
use App\Modules\Stage\Models\Stage;
class StageWiseReportExport implements FromView
{

	protected $StagewiseExport;

	public function __construct($depot,$from,$to)
    {
        $query = TicketLog::where('depot_id',$depot);
        if($from){
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }

        $this->StagewiseExport = $query->get();
    }


    public function view(): View
	{
	    return view('Exports::stage-wise-report', [
	        'StagewiseExport' => $this->StagewiseExport
	    ]);
	}
    
}

