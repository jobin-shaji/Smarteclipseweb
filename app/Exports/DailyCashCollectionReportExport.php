<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;

class DailyCashCollectionReportExport implements FromView
{

	protected $dailycashcollectionExport;
	public function __construct($depot,$from,$to)
    {
        $query = Waybill::where('depot_id',$depot);
        if($from){
            $query = $query->whereBetween('date',[$from,$to]);
        }

        $this->dailycashcollectionExport = $query->get();	
    }


    public function view(): View
	{
	    return view('Exports::dailycash-collection-report', [
	        'dailycashcollectionExport' => $this->dailycashcollectionExport
	    ]);
	}
    
}

