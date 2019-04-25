<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;

class ConductorwiseReportExport implements FromView
{

	protected $conductorwiseExport;
	public function __construct($depot,$from,$to)
    {
        $query = Waybill::where('depot_id',$depot);
        if($from){
            $query = $query->whereBetween('date',[$from,$to]);
        }

        $this->conductorwiseExport = $query->get();
    }


    public function view(): View
	{
	    return view('Exports::conductor-wise-report', [
	        'conductorwiseExport' => $this->conductorwiseExport
	    ]);
	}
    
}

