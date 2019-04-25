<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\StateFareSlab\Models\StateFareSlab;

class StateWiseFareReportExport implements FromView
{

	protected $state_fares;

	public function __construct($state_id)
    {
    	if($state_id==0){
    		$this->state_fares = StateFareSlab::all();
    	}else{
    		$this->state_fares = StateFareSlab::where('state_id',$state_id)
    											->get();
    	}
    }


    public function view(): View
	{
	    return view('Exports::state-fare-report', [
	        'state_fares' => $this->state_fares
	    ]);
	}
    
}

