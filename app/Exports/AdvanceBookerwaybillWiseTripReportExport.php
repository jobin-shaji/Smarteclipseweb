<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Trip\Models\TripLogAdvanceBooking;

class AdvanceBookerwaybillWiseTripReportExport implements FromView
{

	protected $waybillwisetripExport;

	public function __construct($depo_id,$waybill_id,$from,$to)
    {
        $query = TripLogAdvanceBooking::where('waybill_id',$waybill_id)
                            ->where('has_closed',1)
                            ->where('depot_id',$depo_id);
        if($from){
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }

        $this->waybillwisetripExport = $query->get();									 
    }


    public function view(): View
	{
	    return view('Exports::advance-booker-waybill-wise-trip-report', [
	        'waybillwisetripExport' => $this->waybillwisetripExport
	    ]);
	}
    
}

