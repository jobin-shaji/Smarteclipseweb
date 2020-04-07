<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExcelDocumentExport implements FromView
{
     /**
      * variables
      */
     protected $columns;
     protected $data;

     /**
      * initialization  export
      */
	public function __construct($columns,$data)
     {   
          $this->columns      = $columns;
          $this->data         = $data;
         
     }

     /**
      * get report view
      */
     public function view(): View
	{
        return view('Exports::excel-document-view', [
	        'columns'   => $this->columns,
	        'data'      => $this->data
	    ]);
     }
     
    
    
}

