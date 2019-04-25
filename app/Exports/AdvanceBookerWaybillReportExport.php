<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\WaybillAdvanceBooking\Models\WaybillAdvanceBooking;
class AdvanceBookerWaybillReportExport implements FromView
{

	protected $waybills;

	public function __construct($depot,$from,$to)
    {
        $query = WaybillAdvanceBooking::where('depot_id',$depot)
        						   	->where('status',1);
        if($from){
            $query = $query->whereBetween('date',[$from,$to]);
        }

        $this->waybills = $query->get();						
    }


    public function view(): View
	{
	    return view('Exports::advance-booker-waybill-report', [
	        'waybills' => $this->waybills
	    ]);
	}
    
}

