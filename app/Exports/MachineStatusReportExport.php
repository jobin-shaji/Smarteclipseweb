<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Etm\Models\Etm;

class MachineStatusReportExport implements FromView
{

	protected $machines;

	public function __construct($depot)
    {
        $this->machines = Etm::where('depot_id',$depot)
        						->get();
    }


    public function view(): View
	{
	    return view('Exports::machine-status-report', [
	        'machines' => $this->machines
	    ]);
	}
    
}

