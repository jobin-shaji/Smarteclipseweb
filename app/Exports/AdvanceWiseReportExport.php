<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WaybillAdvanceBooking\Models\WaybillAdvanceBooking;

class AdvanceWiseReportExport implements FromView
{

	protected $AdvanceWiseExport;
	public function __construct($depot,$from,$to)
    {
        $query = WaybillAdvanceBooking::where('depot_id',$depot);
        if($from){
            $query = $query->whereBetween('date',[$from,$to]);
        }

        $this->AdvanceWiseExport = $query->get();
    }


    public function view(): View
	{
	    return view('Exports::advance-wise-report', [
	        'AdvanceWiseExport' => $this->AdvanceWiseExport
	    ]);
	}
    
}

