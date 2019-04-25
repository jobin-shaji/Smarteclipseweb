<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Route\Models\Route;

class FareSlabExport implements FromView
{
    protected $route;
    protected $vehicle_type;

	public function __construct($route,$vehicle_type)
    {
        $this->route = Route::find($route);
    }

    public function view(): View
	{
	    return view('Exports::fare-slab', [
	        'route' => $this->route,
	        'vehicle_type' => $this->vehicle_type
	    ]);
	}
    
}
