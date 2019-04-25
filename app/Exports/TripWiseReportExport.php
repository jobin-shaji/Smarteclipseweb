<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
  use App\Modules\Trip\Models\TripLog;

class TripWiseReportExport implements FromView
{

	protected $TripwiseExport;

	public function __construct($depot,$from,$to)
    {
        $query = TripLog::where('has_closed',1)
                        ->where('depot_id',$depot);
        if($from){
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }

        $this->TripwiseExport = $query->get();
    }


    public function view(): View
	{
	    return view('Exports::trip-wise-report', [
	        'TripwiseExport' => $this->TripwiseExport
	    ]);
	}
    
}

