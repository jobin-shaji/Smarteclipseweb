<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;

class ConductorWaybillReportExport implements FromView
{

	protected $waybills;

	public function __construct($depot,$from,$to)
    {
        $query = Waybill::where('depot_id',$depot)
        						   	->where('status',1);
        if($from){
            $query = $query->whereBetween('date',[$from,$to]);
        }

        $this->waybills = $query->get();						
    }


    public function view(): View
	{
	    return view('Exports::conductor-waybill-report', [
	        'waybills' => $this->waybills
	    ]);
	}
    
}

