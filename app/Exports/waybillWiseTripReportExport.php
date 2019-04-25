<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Trip\Models\TripLog;

class waybillWiseTripReportExport implements FromView
{

	protected $waybillwisetripExport;

	public function __construct($waybill_id,$from,$to)
    {
        $query = TripLog::where('waybill_id',$waybill_id)
                            ->where('has_closed',1);
        if($from){
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }

        $this->waybillwisetripExport = $query->get();									 
    }


    public function view(): View
	{
	    return view('Exports::waybill-wise-trip-report', [
	        'waybillwisetripExport' => $this->waybillwisetripExport
	    ]);
	}
    
}

