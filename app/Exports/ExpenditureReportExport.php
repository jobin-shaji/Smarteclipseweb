<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Expense\Models\Expense;
class ExpenditureReportExport implements FromView
{

	protected $ExpenseExport;
	public function __construct($depot,$from,$to)
    {
        $query = Expense::where('depot_id',$depot);
        if($from){
            $query = $query->whereBetween('created_at',[$from,$to]);
        }

        $this->ExpenseExport = $query->get();	
    }


    public function view(): View
	{
	    return view('Exports::expenditure-report', [
	        'ExpenseExport' => $this->ExpenseExport
	    ]);
	}
    
}

