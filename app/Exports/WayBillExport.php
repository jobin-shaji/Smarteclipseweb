<?php

namespace App\Exports;

use App\Modules\WayBill\Models\WayBill;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WayBillExport implements FromView
{
   protected $waybill;

	public function __construct($id)
    {
        $this->waybill = $id;
    }

  
	public function view(): View
	{
	    return view('Exports::waybill', [
	        'waybill' => WayBill::find($this->waybill)
	    ]);
	}
}
