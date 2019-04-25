<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Penality\Models\Penality;

class InspectorReportExport implements FromView
{

	protected $penalties;

	public function __construct($depot,$from,$to)
    {
        $query = Penality::where('depot_id',$depot);
        if($from){
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }

        $this->penalties = $query->get();
    }


    public function view(): View
	{
	    return view('Exports::inspector-report', [
	        'penalties' => $this->penalties
	    ]);
	}
    
}

