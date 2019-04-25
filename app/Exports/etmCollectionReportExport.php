<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
class etmCollectionReportExport implements FromView
{

	protected $EtmCollectionExport;
	public function __construct($depot)
    {
        $this->EtmCollectionExport = Waybill::where('depot_id',$depot)
        ->get();
    }


    public function view(): View
	{
	    return view('Exports::etm-collection-report', [
	        'EtmCollectionExport' => $this->EtmCollectionExport
	    ]);
	}
    
}

