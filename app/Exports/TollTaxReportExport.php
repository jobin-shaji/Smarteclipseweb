<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Expense\Models\Expense;

class TollTaxReportExport implements FromView
{

	protected $expenses;

	public function __construct($depot,$from,$to)
    {
        $query = Expense::where('depot_id',$depot)
        							->where('expense_type_id',1);
        if($from){
            $query = $query->whereBetween('created_at',[$from,$to]);
        }

        $this->expenses = $query->get();						
    }


    public function view(): View
	{
	    return view('Exports::toll-tax-report', [
	        'expenses' => $this->expenses
	    ]);
	}
    
}

